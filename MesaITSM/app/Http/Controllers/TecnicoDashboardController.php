<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TecnicoDashboardController extends Controller
{
    /**
     * Display the technician dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Tickets asignados
        $assignedTickets = $user->assignedTickets()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Estadísticas
        $totalAssigned = $user->assignedTickets()->count();
        $inProgress = $user->assignedTickets()->where('status', 'en_proceso')->count();
        $resolvedToday = $user->assignedTickets()
            ->where('status', 'resuelto')
            ->whereDate('updated_at', today())
            ->count();
        
        // Tiempo promedio de resolución
        $avgResolutionResult = $user->assignedTickets()
            ->where('status', 'resuelto')
            ->select(DB::raw('AVG((julianday(updated_at) - julianday(created_at)) * 24) as average'))
            ->first();
        
        $avgResolutionTime = $avgResolutionResult && $avgResolutionResult->average 
            ? round($avgResolutionResult->average, 1) 
            : 0;

        // Tickets pendientes sin asignar
        $unassignedTickets = Ticket::whereNull('assigned_to')
            ->where('status', 'nuevo')
            ->count();
        
        // Tickets próximos a vencer SLA (ejemplo: más de 24 horas sin actualizar)
        $ticketsProximosVencer = $user->assignedTickets()
            ->whereIn('status', ['nuevo', 'asignado', 'en_proceso'])
            ->where('updated_at', '<', now()->subHours(24))
            ->count();
        
        // Array de contadores para la vista
        $counts = [
            'total_asignados' => $totalAssigned,
            'abiertos' => $inProgress,
            'resueltos_hoy' => $resolvedToday,
            'sin_asignar' => $unassignedTickets,
            'proximos_vencer' => $ticketsProximosVencer,
        ];
        
        // Tickets por estado del técnico (para el gráfico)
        $ticketsPorEstado = $user->assignedTickets()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        return view('tecnico.dashboard', compact(
            'assignedTickets',
            'totalAssigned',
            'inProgress',
            'resolvedToday',
            'avgResolutionTime',
            'unassignedTickets',
            'counts',
            'ticketsPorEstado'
        ));
    }
}