<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Contadores de tickets por periodo
        $counts = [
            'hoy' => Ticket::whereDate('created_at', today())->count(),
            'semana' => Ticket::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'mes' => Ticket::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        // Tickets por estado
        $ticketsPorEstado = Ticket::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Top 5 categorías más solicitadas
        $topCategorias = Ticket::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Tiempo promedio de resolución (en horas)
        $avgResolutionTime = DB::table('tickets')
            ->where('status', 'resuelto')
            ->whereNotNull('updated_at')
            ->select(DB::raw('AVG((julianday(updated_at) - julianday(created_at)) * 24) as average'))
            ->value('average');
        
        $tiempoResolucion = $avgResolutionTime ? round($avgResolutionTime, 1) . ' hrs' : 'N/A';

        // Calificación promedio (si tienes un campo de calificación)
        $avgRating = DB::table('tickets')
            ->whereNotNull('rating')
            ->avg('rating');
        
        $calificacionPromedio = $avgRating ? round($avgRating, 1) : 'N/A';

        // Estadísticas generales (las que ya tenías)
        $totalTickets = Ticket::count();
        $pendingTickets = Ticket::whereIn('status', ['nuevo', 'asignado', 'en_proceso'])->count();
        $activeTechnicians = User::where('role', 'tecnico')->where('is_active', true)->count();
        $resolvedToday = Ticket::where('status', 'resuelto')
            ->whereDate('updated_at', today())
            ->count();

        // Agregar conteo de críticos para el dashboard
        $ticketsPorEstado['critico'] = Ticket::where('priority', 'critica')->count();

        // Tickets por categoría
        $ticketsByCategory = DB::table('tickets')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        // Tiempo promedio de resolución por día (últimos 7 días)
        $resolutionTime = DB::table('tickets')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('AVG((julianday(updated_at) - julianday(created_at)) * 24) as average')
            )
            ->where('status', 'resuelto')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tickets recientes
        $recentTickets = Ticket::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Estadísticas del catálogo de servicios
        $totalServices = Service::count();
        $totalCategories = ServiceCategory::count();
        $mostRequestedService = Service::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->first();

        return view('admin.dashboard', compact(
            'counts',
            'ticketsPorEstado',
            'topCategorias',
            'tiempoResolucion',
            'calificacionPromedio',
            'totalTickets',
            'pendingTickets',
            'activeTechnicians',
            'resolvedToday',
            'ticketsByCategory',
            'resolutionTime',
            'recentTickets',
            'totalServices',
            'totalCategories',
            'mostRequestedService'
        ));
    }
}