<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\KnowledgeArticle;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    /**
     * Mostrar dashboard de reportes
     */
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        // Estadísticas generales
        $stats = [
            'tickets' => [
                'total' => Ticket::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
                'nuevos' => Ticket::where('status', 'nuevo')->count(),
                'en_proceso' => Ticket::whereIn('status', ['asignado', 'en_proceso'])->count(),
                'resueltos' => Ticket::where('status', 'resuelto')->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
                'cerrados' => Ticket::where('status', 'cerrado')->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            ],
            'usuarios' => [
                'total' => User::count(),
                'tecnicos' => User::where('rol', 'tecnico')->count(),
                'administradores' => User::where('rol', 'admin')->count(),
                'usuarios' => User::where('rol', 'usuario')->count(),
            ],
            'conocimiento' => [
                'total_articulos' => KnowledgeArticle::count(),
                'publicados' => KnowledgeArticle::where('is_published', true)->count(),
                'total_vistas' => KnowledgeArticle::sum('views'),
            ],
            'servicios' => [
                'total' => Service::count(),
                'activos' => Service::where('is_active', true)->count(),
            ],
        ];

        // Tickets por estado (para gráfico)
        $ticketsPorEstado = Ticket::selectRaw('status, COUNT(*) as total')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('status')
            ->get();

        // Tickets por prioridad
        $ticketsPorPrioridad = Ticket::selectRaw('priority, COUNT(*) as total')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('priority')
            ->get();

        // Tickets por tipo
        $ticketsPorTipo = Ticket::selectRaw('category, COUNT(*) as total')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('category')
            ->get();

        // Tendencias (últimos 7 días)
        $tendencias = Ticket::selectRaw("DATE(created_at) as fecha, COUNT(*) as total")
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Top 5 técnicos
        $topTecnicos = User::where('role', 'tecnico')
            ->withCount(['assignedTickets as resueltos' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'resuelto')
                    ->whereBetween('updated_at', [$dateFrom, $dateTo]);
            }])
            ->orderBy('resueltos', 'desc')
            ->limit(5)
            ->get();

        // Servicios más solicitados
        $topServicios = Service::withCount(['tickets as solicitudes' => function ($query) use ($dateFrom, $dateTo) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }])
        ->with('category')
        ->get()
        ->filter(function ($service) {
            return $service->solicitudes > 0;
        })
        ->sortByDesc('solicitudes')
        ->take(5);

        return view('admin.reports.index', compact(
            'stats',
            'ticketsPorEstado',
            'ticketsPorPrioridad',
            'ticketsPorTipo',
            'tendencias',
            'topTecnicos',
            'topServicios',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Reporte detallado de tickets
     */
    public function tickets(Request $request)
    {
        $query = Ticket::with(['user', 'assignedTo']);

        // Aplicar filtros
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        if ($request->filled('estado')) {
            $query->where('status', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('priority', $request->prioridad);
        }

        if ($request->filled('tipo')) {
            $query->where('category', $request->tipo);
        }

        if ($request->filled('tecnico_id')) {
            $query->where('tecnico_asignado_id', $request->tecnico_id);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(20);

        $tecnicos = User::where('role', 'tecnico')->get();

        return view('admin.reports.tickets', compact('tickets', 'tecnicos'));
    }

    /**
     * Reporte de rendimiento de técnicos
     */
    public function technicians(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30));
        $dateTo = $request->input('date_to', now());

        $technicians = User::where('role', 'tecnico')
            ->withCount([
                'assignedTickets as tickets_asignados' => function ($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                },
                'assignedTickets as tickets_resueltos' => function ($query) use ($dateFrom, $dateTo) {
                    $query->where('status', 'resuelto')
                        ->whereBetween('updated_at', [$dateFrom, $dateTo]);
                },
            ])
            ->get()
            ->map(function ($tecnico) use ($dateFrom, $dateTo) {
                $tickets = $tecnico->assignedTickets()
                    ->where('status', 'resuelto')
                    ->whereBetween('updated_at', [$dateFrom, $dateTo])
                    ->get();

                $tiempoResolucion = $tickets->avg(function ($ticket) {
                    return $ticket->created_at->diffInHours($ticket->updated_at);
                });

                $tecnico->tasa_resolucion = $tecnico->tickets_asignados > 0 
                    ? round(($tecnico->tickets_resueltos / $tecnico->tickets_asignados) * 100, 2) 
                    : 0;
                
                $tecnico->tiempo_promedio = round($tiempoResolucion ?? 0, 2);

                return $tecnico;
            });

        return view('admin.reports.technicians', compact('technicians', 'dateFrom', 'dateTo'));
    }

    /**
     * Exportar reporte
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'tickets');
        $format = $request->input('format', 'csv');

        if ($type === 'tickets') {
            return $this->exportTickets($request, $format);
        }

        return redirect()->back()->with('error', 'Tipo de reporte no válido');
    }

    private function exportTickets(Request $request, $format)
    {
        $tickets = Ticket::with(['user', 'assignedTo', 'service'])
            ->when($request->date_from, fn($q) => $q->where('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->where('created_at', '<=', $request->date_to))
            ->when($request->estado, fn($q) => $q->where('status', $request->estado))
            ->orderBy('created_at', 'desc')
            ->get();

        if ($format === 'csv') {
            $filename = 'tickets_' . now()->format('Y-m-d_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function() use ($tickets) {
                $file = fopen('php://output', 'w');
                
                // BOM para UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // Encabezados
                fputcsv($file, [
                    'ID',
                    'Título',
                    'Estado',
                    'Prioridad',
                    'Categoría',
                    'Usuario',
                    'Técnico',
                    'Servicio',
                    'Fecha Creación',
                    'Última Actualización'
                ]);

                // Datos
                foreach ($tickets as $ticket) {
                    fputcsv($file, [
                        $ticket->id,
                        $ticket->title,
                        $ticket->status,
                        $ticket->priority,
                        $ticket->category,
                        $ticket->user->name ?? 'N/A',
                        $ticket->assignedTo->name ?? 'Sin asignar',
                        $ticket->service->name ?? 'N/A',
                        $ticket->created_at->format('Y-m-d H:i:s'),
                        $ticket->updated_at->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Formato no soportado');
    }
}
