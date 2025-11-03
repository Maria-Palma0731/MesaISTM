<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UsuarioDashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Tickets del usuario
        $recentTickets = $user->tickets()
            ->latest()
            ->take(5)
            ->get();

        // Estadísticas
        $totalTickets = $user->tickets()->count();
        $activeTickets = $user->tickets()
            ->whereIn('status', ['nuevo', 'asignado', 'en_proceso'])
            ->count();
        $resolvedTickets = $user->tickets()
            ->where('status', 'resuelto')
            ->count();
        
        // Contadores por estado específico
        $openTickets = $user->tickets()
            ->where('status', 'nuevo')
            ->count();
        $inProgressTickets = $user->tickets()
            ->whereIn('status', ['asignado', 'en_proceso'])
            ->count();

        // Servicios populares
        $popularServices = Service::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->take(3)
            ->get();

        // Categorías de servicios
        $serviceCategories = ServiceCategory::with('services')
            ->get();
        
        return view('usuario.dashboard', compact(
            'recentTickets',
            'totalTickets',
            'activeTickets',
            'resolvedTickets',
            'openTickets',
            'inProgressTickets',
            'popularServices',
            'serviceCategories'
        ));
    }
}