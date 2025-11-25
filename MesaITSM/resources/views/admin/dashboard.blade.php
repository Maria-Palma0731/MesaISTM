<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Panel de Control</h1>
                <p class="mt-2 text-gray-600">Bienvenido al sistema de gestión de servicios de TI</p>
            </div>

            {{-- Tarjetas de estadísticas principales --}}
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Tickets Abiertos --}}
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">Tickets Abiertos</h3>
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-4xl font-bold text-gray-900">{{ $pendingTickets }}</p>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">+3 desde ayer</p>
                </div>

                {{-- En Progreso --}}
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">En Progreso</h3>
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cyan-100">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-4xl font-bold text-gray-900">{{ $ticketsPorEstado['en_proceso'] ?? 0 }}</p>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">8 asignados a ti</p>
                </div>

                {{-- Resueltos Hoy --}}
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">Resueltos Hoy</h3>
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-4xl font-bold text-gray-900">{{ $resolvedToday }}</p>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">+6 vs. promedio</p>
                </div>

                {{-- Críticos --}}
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">Críticos</h3>
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-100">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <p class="text-4xl font-bold text-gray-900">{{ $ticketsPorEstado['critico'] ?? 0 }}</p>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Requieren atención</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Tickets Recientes --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Tickets Recientes</h2>
                        <p class="text-sm text-gray-600">Últimas solicitudes de soporte registradas</p>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($recentTickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="block group">
                            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white font-medium text-sm">
                                        {{ strtoupper(substr($ticket->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $ticket->folio }}</p>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                                            @if($ticket->priority === 'critica') bg-red-100 text-red-700
                                            @elseif($ticket->priority === 'alta') bg-orange-100 text-orange-700
                                            @elseif($ticket->priority === 'media') bg-yellow-100 text-yellow-700
                                            @else bg-green-100 text-green-700
                                            @endif">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-900 truncate">{{ $ticket->title }}</p>
                                    <div class="flex items-center mt-2 space-x-2">
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-md bg-cyan-100 text-cyan-700">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                        <span class="text-xs text-gray-500">Hace {{ $ticket->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-8">No hay tickets recientes</p>
                        @endforelse
                    </div>
                </div>

                {{-- Módulos del Sistema --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Módulos del Sistema</h2>
                        <p class="text-sm text-gray-600">Acceso rápido a funcionalidades</p>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('tickets.index') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-blue-50 transition-colors group">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Gestión de Tickets</h3>
                                    <p class="text-xs text-gray-600">Registro y seguimiento</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="{{ route('admin.catalog.categories') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-purple-50 transition-colors group">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 group-hover:bg-purple-200 transition-colors">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Catálogo de Servicios</h3>
                                    <p class="text-xs text-gray-600">Servicios disponibles</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="{{ route('administrador.users.index') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-green-50 transition-colors group">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 group-hover:bg-green-200 transition-colors">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Gestión de Usuarios</h3>
                                    <p class="text-xs text-gray-600">Técnicos y solicitantes</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="#" class="flex items-center justify-between p-4 rounded-xl hover:bg-orange-50 transition-colors group">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-100 group-hover:bg-orange-200 transition-colors">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Reportes y Estadísticas</h3>
                                    <p class="text-xs text-gray-600">Análisis de rendimiento</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="{{ route('admin.knowledge-base.index') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-yellow-50 transition-colors group">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-yellow-100 group-hover:bg-yellow-200 transition-colors">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Base de Conocimiento</h3>
                                    <p class="text-xs text-gray-600">Artículos y documentación</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-yellow-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>