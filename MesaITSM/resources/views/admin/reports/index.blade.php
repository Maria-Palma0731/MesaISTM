<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Reportes y Estadísticas</h1>
                <p class="mt-2 text-gray-600">Análisis de rendimiento y métricas del sistema</p>
            </div>

            {{-- Filtros de Fecha --}}
            <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" name="date_from" id="date_from" value="{{ $dateFrom }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" name="date_to" id="date_to" value="{{ $dateTo }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Aplicar Filtros
                    </button>
                </form>
            </div>

            {{-- Estadísticas Generales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Tickets --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Tickets</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['tickets']['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        <span class="text-green-600 font-medium">{{ $stats['tickets']['resueltos'] }} resueltos</span>
                    </div>
                </div>

                {{-- Usuarios --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Usuarios</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['usuarios']['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        <span class="font-medium">{{ $stats['usuarios']['tecnicos'] }} técnicos</span>
                    </div>
                </div>

                {{-- Artículos KB --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Artículos KB</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['conocimiento']['total_articulos'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        <span class="font-medium">{{ number_format($stats['conocimiento']['total_vistas']) }} vistas</span>
                    </div>
                </div>

                {{-- Servicios --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Servicios</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['servicios']['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        <span class="text-green-600 font-medium">{{ $stats['servicios']['activos'] }} activos</span>
                    </div>
                </div>
            </div>

            {{-- Gráficos y Tablas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Tickets por Estado --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tickets por Estado</h3>
                    <div class="space-y-3">
                        @foreach($ticketsPorEstado as $item)
                            @php
                                $percentage = $stats['tickets']['total'] > 0 ? ($item->total / $stats['tickets']['total']) * 100 : 0;
                                $colorClass = match($item->status) {
                                    'nuevo' => 'bg-blue-500',
                                    'asignado' => 'bg-yellow-500',
                                    'en_proceso' => 'bg-orange-500',
                                    'pendiente_usuario' => 'bg-purple-500',
                                    'resuelto' => 'bg-green-500',
                                    'cerrado' => 'bg-gray-500',
                                    default => 'bg-gray-400'
                                };
                            @endphp
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $item->status) }}</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $item->total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tickets por Prioridad --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tickets por Prioridad</h3>
                    <div class="space-y-3">
                        @foreach($ticketsPorPrioridad as $item)
                            @php
                                $percentage = $stats['tickets']['total'] > 0 ? ($item->total / $stats['tickets']['total']) * 100 : 0;
                                $colorClass = match($item->priority) {
                                    'critica' => 'bg-red-600',
                                    'alta' => 'bg-orange-500',
                                    'media' => 'bg-yellow-500',
                                    'baja' => 'bg-green-500',
                                    default => 'bg-gray-400'
                                };
                            @endphp
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 capitalize">{{ $item->priority }}</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $item->total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Top Técnicos y Servicios --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Top 5 Técnicos --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Top 5 Técnicos</h3>
                    <div class="space-y-4">
                        @forelse($topTecnicos as $tecnico)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold text-sm">{{ substr($tecnico->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $tecnico->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $tecnico->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">{{ $tecnico->resueltos }}</p>
                                    <p class="text-xs text-gray-500">resueltos</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No hay datos disponibles</p>
                        @endforelse
                    </div>
                </div>

                {{-- Top 5 Servicios --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Servicios Más Solicitados</h3>
                    <div class="space-y-4">
                        @forelse($topServicios as $servicio)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $servicio->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $servicio->category->name ?? 'Sin categoría' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-purple-600">{{ $servicio->solicitudes }}</p>
                                    <p class="text-xs text-gray-500">solicitudes</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No hay datos disponibles</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Accesos Rápidos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.reports.tickets') }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Reporte de Tickets</h3>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">Vista detallada de todos los tickets con filtros avanzados</p>
                </a>

                <a href="{{ route('admin.reports.technicians') }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Rendimiento Técnicos</h3>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">Métricas de productividad y eficiencia de técnicos</p>
                </a>

                <a href="{{ route('admin.reports.export', ['type' => 'tickets', 'format' => 'csv', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
                   class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Exportar Datos</h3>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">Descargar reportes en formato CSV o JSON</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
