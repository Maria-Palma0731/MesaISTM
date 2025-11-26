<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\KnowledgeArticle;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Obtener estadísticas generales del sistema
     * GET /api/reports/dashboard
     */
    public function dashboard(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30));
        $dateTo = $request->input('date_to', now());

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
                'tecnicos' => User::where('role', 'tecnico')->count(),
                'administradores' => User::where('role', 'admin')->count(),
                'usuarios' => User::where('role', 'usuario')->count(),
            ],
            'conocimiento' => [
                'total_articulos' => KnowledgeArticle::count(),
                'publicados' => KnowledgeArticle::where('is_published', true)->count(),
                'borradores' => KnowledgeArticle::where('is_published', false)->count(),
                'total_vistas' => KnowledgeArticle::sum('views'),
            ],
            'servicios' => [
                'total' => Service::count(),
                'activos' => Service::where('is_active', true)->count(),
                'categorias' => DB::table('service_categories')->count(),
            ],
            'rendimiento' => [
                'tiempo_promedio_resolucion' => $this->getAverageResolutionTime($dateFrom, $dateTo),
                'tasa_resolucion_primer_contacto' => $this->getFirstContactResolutionRate($dateFrom, $dateTo),
                'tickets_por_dia' => $this->getTicketsPerDay($dateFrom, $dateTo),
                'satisfaccion_promedio' => $this->getAverageSatisfaction($dateFrom, $dateTo),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'period' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ],
        ]);
    }

    /**
     * Obtener reporte de tickets
     * GET /api/reports/tickets
     */
    public function tickets(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'estado' => 'nullable|in:nuevo,asignado,en_proceso,pendiente_usuario,resuelto,cerrado',
            'prioridad' => 'nullable|in:baja,media,alta,critica',
            'tipo' => 'nullable|in:incidente,solicitud',
            'tecnico_id' => 'nullable|exists:users,id',
        ]);

        $query = Ticket::with(['user', 'assignedTo']);

        if ($request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('created_at', '<=', $request->date_to);
        }

        if ($request->estado) {
            $query->where('status', $request->estado);
        }

        if ($request->prioridad) {
            $query->where('priority', $request->prioridad);
        }

        if ($request->tipo) {
            $query->where('category', $request->tipo);
        }

        if ($request->tecnico_id) {
            $query->where('tecnico_asignado_id', $request->tecnico_id);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(50);

        // Estadísticas del reporte
        $stats = [
            'total' => $query->count(),
            'por_estado' => Ticket::selectRaw('status, COUNT(*) as total')
                ->whereBetween('created_at', [$request->date_from ?? now()->subDays(30), $request->date_to ?? now()])
                ->groupBy('status')
                ->pluck('total', 'status'),
            'por_prioridad' => Ticket::selectRaw('priority, COUNT(*) as total')
                ->whereBetween('created_at', [$request->date_from ?? now()->subDays(30), $request->date_to ?? now()])
                ->groupBy('priority')
                ->pluck('total', 'priority'),
            'por_tipo' => Ticket::selectRaw('category, COUNT(*) as total')
                ->whereBetween('created_at', [$request->date_from ?? now()->subDays(30), $request->date_to ?? now()])
                ->groupBy('category')
                ->pluck('total', 'category'),
        ];

        return response()->json([
            'success' => true,
            'data' => $tickets,
            'stats' => $stats,
        ]);
    }

    /**
     * Obtener reporte de rendimiento de técnicos
     * GET /api/reports/technicians
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
                'assignedTickets as tickets_cerrados' => function ($query) use ($dateFrom, $dateTo) {
                    $query->where('status', 'cerrado')
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

                return [
                    'id' => $tecnico->id,
                    'nombre' => $tecnico->name,
                    'email' => $tecnico->email,
                    'tickets_asignados' => $tecnico->tickets_asignados,
                    'tickets_resueltos' => $tecnico->tickets_resueltos,
                    'tickets_cerrados' => $tecnico->tickets_cerrados,
                    'tasa_resolucion' => $tecnico->tickets_asignados > 0 
                        ? round(($tecnico->tickets_resueltos / $tecnico->tickets_asignados) * 100, 2) 
                        : 0,
                    'tiempo_promedio_resolucion' => round($tiempoResolucion, 2),
                    'tiempo_promedio_resolucion_texto' => $this->formatHours($tiempoResolucion),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $technicians,
            'period' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ],
        ]);
    }

    /**
     * Obtener reporte de servicios más solicitados
     * GET /api/reports/services
     */
    public function services(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30));
        $dateTo = $request->input('date_to', now());

        $services = Service::withCount([
            'tickets as tickets_count' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            },
            'tickets as tickets_resueltos' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'resuelto')
                    ->whereBetween('created_at', [$dateFrom, $dateTo]);
            },
        ])
        ->with('category')
        ->get()
        ->filter(function ($service) {
            return $service->tickets_count > 0;
        })
        ->sortByDesc('tickets_count')
        ->take(20)
        ->map(function ($service) {
            return [
                'id' => $service->id,
                'nombre' => $service->name,
                'categoria' => $service->category->name ?? 'Sin categoría',
                'total_solicitudes' => $service->tickets_count,
                'solicitudes_resueltas' => $service->tickets_resueltos,
                'tasa_resolucion' => $service->tickets_count > 0
                    ? round(($service->tickets_resueltos / $service->tickets_count) * 100, 2)
                    : 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $services,
            'period' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ],
        ]);
    }

    /**
     * Obtener reporte de base de conocimiento
     * GET /api/reports/knowledge-base
     */
    public function knowledgeBase(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30));
        $dateTo = $request->input('date_to', now());

        $articles = KnowledgeArticle::with('creator')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->orderBy('views', 'desc')
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'titulo' => $article->title,
                    'categoria' => $article->category,
                    'vistas' => $article->views,
                    'autor' => $article->creator->name,
                    'publicado' => $article->is_published,
                    'fecha_creacion' => $article->created_at->format('Y-m-d'),
                ];
            });

        $stats = [
            'total_articulos' => KnowledgeArticle::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'articulos_publicados' => KnowledgeArticle::where('is_published', true)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count(),
            'total_vistas' => KnowledgeArticle::whereBetween('created_at', [$dateFrom, $dateTo])->sum('views'),
            'promedio_vistas' => round(KnowledgeArticle::whereBetween('created_at', [$dateFrom, $dateTo])->avg('views'), 2),
            'por_categoria' => KnowledgeArticle::selectRaw('category, COUNT(*) as total, SUM(views) as vistas')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->groupBy('category')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $articles,
            'stats' => $stats,
            'period' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ],
        ]);
    }

    /**
     * Obtener tendencias temporales
     * GET /api/reports/trends
     */
    public function trends(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30));
        $dateTo = $request->input('date_to', now());
        $groupBy = $request->input('group_by', 'day'); // day, week, month

        // Compatible con SQLite
        $tickets = Ticket::selectRaw("DATE(created_at) as fecha, COUNT(*) as total")
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $resueltos = Ticket::selectRaw("DATE(updated_at) as fecha, COUNT(*) as total")
            ->where('status', 'resuelto')
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'tickets_creados' => $tickets,
                'tickets_resueltos' => $resueltos,
            ],
            'period' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ],
        ]);
    }

    /**
     * Exportar reporte
     * GET /api/reports/export
     */
    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:tickets,technicians,services,knowledge-base',
            'format' => 'required|in:json,csv,pdf',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ]);

        $type = $request->input('type');
        $format = $request->input('format');

        // Obtener datos según el tipo
        $data = match($type) {
            'tickets' => $this->tickets($request)->getData()->data,
            'technicians' => $this->technicians($request)->getData()->data,
            'services' => $this->services($request)->getData()->data,
            'knowledge-base' => $this->knowledgeBase($request)->getData()->data,
        };

        // Exportar según el formato
        if ($format === 'json') {
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }

        if ($format === 'csv') {
            return $this->exportToCsv($data, $type);
        }

        // PDF se puede implementar con una librería como DomPDF
        return response()->json([
            'success' => false,
            'message' => 'Formato PDF en desarrollo',
        ], 501);
    }

    // Métodos auxiliares privados

    private function getAverageResolutionTime($dateFrom, $dateTo)
    {
        $tickets = Ticket::where('status', 'resuelto')
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->get();

        if ($tickets->isEmpty()) {
            return 0;
        }

        $totalHours = $tickets->sum(function ($ticket) {
            return $ticket->created_at->diffInHours($ticket->updated_at);
        });

        return round($totalHours / $tickets->count(), 2);
    }

    private function getFirstContactResolutionRate($dateFrom, $dateTo)
    {
        $totalTickets = Ticket::whereBetween('created_at', [$dateFrom, $dateTo])->count();
        
        if ($totalTickets === 0) {
            return 0;
        }

        // Tickets resueltos sin comentarios (primera interacción)
        $resolvedFirstContact = Ticket::where('status', 'resuelto')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->whereDoesntHave('comments')
            ->count();

        return round(($resolvedFirstContact / $totalTickets) * 100, 2);
    }

    private function getTicketsPerDay($dateFrom, $dateTo)
    {
        $days = Carbon::parse($dateFrom)->diffInDays(Carbon::parse($dateTo));
        $totalTickets = Ticket::whereBetween('created_at', [$dateFrom, $dateTo])->count();

        return $days > 0 ? round($totalTickets / $days, 2) : 0;
    }

    private function getAverageSatisfaction($dateFrom, $dateTo)
    {
        // Esto requeriría un sistema de calificación de tickets
        // Por ahora retornamos un valor placeholder
        return 4.2;
    }

    private function formatHours($hours)
    {
        if ($hours < 1) {
            return round($hours * 60) . ' minutos';
        }

        if ($hours < 24) {
            return round($hours, 1) . ' horas';
        }

        $days = floor($hours / 24);
        $remainingHours = $hours % 24;

        return $days . ' días ' . round($remainingHours) . ' horas';
    }

    private function exportToCsv($data, $type)
    {
        $filename = $type . '_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Escribir encabezados
            if (!empty($data)) {
                fputcsv($file, array_keys((array) $data[0]));
            }

            // Escribir datos
            foreach ($data as $row) {
                fputcsv($file, (array) $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
