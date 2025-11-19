<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard de {{ auth()->user()->name }}</h1>
                <p class="text-gray-600 mt-1">Gestión de tickets asignados</p>
            </div>
            <!-- Contadores -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Total Asignados</div>
                    <div class="text-4xl font-bold text-gray-900">{{ $counts['total_asignados'] }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">En Progreso</div>
                    <div class="text-4xl font-bold text-blue-600">{{ $counts['abiertos'] }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Resueltos Hoy</div>
                    <div class="text-4xl font-bold text-green-600">{{ $counts['resueltos_hoy'] }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Sin Asignar</div>
                    <div class="text-4xl font-bold text-orange-600">{{ $counts['sin_asignar'] }}</div>
                </div>
            </div>

            <!-- Grid de 2 columnas -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Mis últimos tickets -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Mis Últimos Tickets</h3>
                            <p class="text-sm text-gray-600 mt-1">Tickets asignados recientemente</p>
                        </div>
                        <a href="{{ route('tecnico.tickets.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                            Ver todos →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($assignedTickets as $ticket)
                            <a href="{{ route('tecnico.tickets.show', $ticket) }}" class="block group">
                                <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-gray-50 border border-gray-200 hover:border-gray-300 transition-all">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-sm font-medium text-gray-600">{{ $ticket->folio }}</span>
                                            <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded
                                                @if($ticket->priority === 'critica') bg-red-100 text-red-700
                                                @elseif($ticket->priority === 'alta') bg-orange-100 text-orange-700
                                                @elseif($ticket->priority === 'media') bg-yellow-100 text-yellow-700
                                                @else bg-green-100 text-green-700
                                                @endif">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900 mb-2 line-clamp-1">
                                            {{ $ticket->title }}
                                        </p>
                                        <div class="flex items-center gap-3 text-xs">
                                            <span class="inline-flex px-2 py-1 rounded-md bg-blue-100 text-blue-700">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                            <span class="text-gray-500">
                                                De: {{ $ticket->user->name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white font-semibold text-xs">
                                            {{ strtoupper(substr($ticket->user->name, 0, 2)) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay tickets asignados</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Módulos del Sistema -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Acciones Rápidas</h2>
                        <p class="text-sm text-gray-600">Acceso rápido a funcionalidades</p>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('tecnico.tickets.index') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-blue-50 transition-colors group border border-gray-200 hover:border-blue-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Mis Tickets</h3>
                                    <p class="text-xs text-gray-600">Ver todos mis tickets asignados</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="{{ route('tickets.create') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-green-50 transition-colors group border border-gray-200 hover:border-green-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-green-100 group-hover:bg-green-200 transition-colors">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Crear Ticket</h3>
                                    <p class="text-xs text-gray-600">Registrar nueva solicitud</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Reportes</h3>
                                    <p class="text-xs text-gray-600">Próximamente</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>