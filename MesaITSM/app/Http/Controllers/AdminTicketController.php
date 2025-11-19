<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Exports\TicketsExport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AdminTicketController extends Controller
{
    /**
     * Dashboard administrativo
     */
    public function dashboard(): View
    {
        // Obtener estadísticas
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        // Contadores generales
        $counts = [
            'hoy' => Ticket::whereDate('created_at', $today)->count(),
            'semana' => Ticket::whereBetween('created_at', [$weekStart, now()])->count(),
            'mes' => Ticket::whereBetween('created_at', [$monthStart, now()])->count(),
        ];

        // Tickets por estado
        $ticketsPorEstado = Ticket::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Tiempo promedio de resolución (en horas)
        $tiempoResolucion = round(Ticket::where('status', 'resuelto')
            ->whereNotNull('updated_at')
            ->get()
            ->avg(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->updated_at);
            }) ?? 0, 1);

        // Calificación promedio
        $calificacionPromedio = round(Ticket::whereNotNull('rating')
            ->avg('rating') ?? 0, 1);

        // Top 5 categorías
        $topCategorias = Ticket::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'counts',
            'ticketsPorEstado',
            'tiempoResolucion',
            'calificacionPromedio',
            'topCategorias'
        ));
    }

    /**
     * Lista de todos los tickets
     */
    public function index(Request $request): View
    {
        $query = Ticket::with(['user', 'assignedTo']);

        // Aplicar filtros
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('department')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('department', $request->department);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled(['date_from', 'date_to'])) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()
            ->paginate(15)
            ->withQueryString();

        $tecnicos = User::where('role', 'tecnico')
            ->orderBy('name')
            ->get();

        $departamentos = User::distinct()
            ->whereNotNull('department')
            ->pluck('department')
            ->sort();

        return view('admin.tickets.index', compact('tickets', 'tecnicos', 'departamentos'));
    }

    /**
     * Vista de asignación masiva de tickets
     */
    public function massAssignForm(): View
    {
        $tickets = Ticket::whereNull('assigned_to')
            ->where('status', 'nuevo')
            ->with('user')
            ->latest()
            ->get();

        $tecnicos = User::where('role', 'tecnico')
            ->orderBy('name')
            ->get();

        return view('admin.tickets.mass-assign', compact('tickets', 'tecnicos'));
    }

    /**
     * Asignar tickets masivamente
     */
    public function massAssign(Request $request): RedirectResponse
    {
        $request->validate([
            'tickets' => ['required', 'array', 'min:1'],
            'tickets.*' => ['exists:tickets,id'],
            'assigned_to' => ['required', 'exists:users,id'],
        ]);

        try {
            DB::beginTransaction();

            $tecnico = User::findOrFail($request->assigned_to);

            Ticket::whereIn('id', $request->tickets)
                ->whereNull('assigned_to')
                ->where('status', 'nuevo')
                ->update([
                    'assigned_to' => $tecnico->id,
                    'status' => 'asignado',
                ]);

            DB::commit();

            return redirect()
                ->route('admin.tickets.mass-assign')
                ->with('success', 'Tickets asignados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error en asignación masiva: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al asignar los tickets. Por favor intenta nuevamente.');
        }
    }

    /**
     * Asignar o reasignar un ticket
     */
    public function assignTicket(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
        ]);

        try {
            $oldTecnico = $ticket->assignedTo;
            $newTecnico = User::findOrFail($request->assigned_to);

            DB::beginTransaction();

            $ticket->update([
                'assigned_to' => $newTecnico->id,
                'status' => $ticket->status === 'nuevo' ? 'asignado' : $ticket->status,
            ]);

            DB::commit();

            return back()->with('success', 'Ticket asignado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al asignar ticket: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al asignar el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Actualizar prioridad del ticket
     */
    public function updatePriority(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            'priority' => ['required', 'in:baja,media,alta,critica'],
        ]);

        try {
            DB::beginTransaction();

            $ticket->update(['priority' => $request->priority]);

            DB::commit();

            return back()->with('success', 'Prioridad actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar prioridad: " . $e->getMessage());

            return back()->with('error', 'Error al actualizar la prioridad.');
        }
    }

    /**
     * Cerrar ticket
     */
    public function closeTicket(Ticket $ticket): RedirectResponse
    {
        if ($ticket->status !== 'resuelto') {
            return back()->with('error', 'Solo se pueden cerrar tickets resueltos.');
        }

        try {
            DB::beginTransaction();

            $ticket->update(['status' => 'cerrado']);

            DB::commit();

            return back()->with('success', 'Ticket cerrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al cerrar ticket: " . $e->getMessage());

            return back()->with('error', 'Error al cerrar el ticket.');
        }
    }

    /**
     * Vista de reportes
     */
    public function reports(Request $request): View
    {
        $tecnicos = User::where('role', 'tecnico')
            ->orderBy('name')
            ->get();

        $metrics = null;

        if ($request->filled(['from_date', 'to_date'])) {
            $query = Ticket::query();

            // Aplicar filtros
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);

            if ($request->filled('assigned_to')) {
                $query->where('assigned_to', $request->assigned_to);
            }

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            // Calcular métricas
            $metrics = [
                'total' => (clone $query)->count(),
                'por_estado' => (clone $query)
                    ->select('status', DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->pluck('total', 'status')
                    ->toArray(),
                'tiempo_promedio' => round((clone $query)
                    ->where('status', 'resuelto')
                    ->whereNotNull('updated_at')
                    ->get()
                    ->avg(function($ticket) {
                        return $ticket->created_at->diffInHours($ticket->updated_at);
                    }) ?? 0, 1),
                'por_tecnico' => (clone $query)
                    ->whereNotNull('assigned_to')
                    ->select('assigned_to', DB::raw('count(*) as total'))
                    ->groupBy('assigned_to')
                    ->with('assignedTo')
                    ->get()
                    ->pluck('total', 'assignedTo.name')
                    ->toArray(),
                'calificacion' => round((clone $query)
                    ->whereNotNull('rating')
                    ->avg('rating') ?? 0, 1),
            ];
        }

        return view('admin.tickets.reports', compact('tecnicos', 'metrics'));
    }

    /**
     * Exportar reporte a Excel
     */
    public function export(Request $request)
    {
        $filename = 'reporte_tickets_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        $filters = [
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'assigned_to' => $request->assigned_to,
            'category' => $request->category,
        ];

        return Excel::download(new TicketsExport($filters), $filename);
    }
}