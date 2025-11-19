<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Reportes de Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Filtros --}}
                    <form action="{{ route('admin.tickets.reports') }}" method="GET" class="mb-6 space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            {{-- Rango de Fechas --}}
                            <div>
                                <label for="from_date" class="block text-sm font-medium text-gray-700">
                                    Fecha Inicial
                                </label>
                                <input type="date" name="from_date" id="from_date"
                                    value="{{ request('from_date') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="to_date" class="block text-sm font-medium text-gray-700">
                                    Fecha Final
                                </label>
                                <input type="date" name="to_date" id="to_date"
                                    value="{{ request('to_date') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            {{-- Técnico --}}
                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700">
                                    Técnico
                                </label>
                                <select name="assigned_to" id="assigned_to"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Todos los técnicos</option>
                                    @foreach($tecnicos as $tecnico)
                                        <option value="{{ $tecnico->id }}" {{ request('assigned_to') == $tecnico->id ? 'selected' : '' }}>
                                            {{ $tecnico->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Categoría --}}
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">
                                    Categoría
                                </label>
                                <select name="category" id="category"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Todas las categorías</option>
                                    {{-- Aquí deberías listar las categorías de tu sistema --}}
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Generar Reporte
                            </button>

                            @if($metrics)
                                <a href="{{ route('admin.tickets.export') }}?{{ http_build_query(request()->all()) }}"
                                    class="px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 border border-transparent rounded-md shadow-sm hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Exportar a Excel
                                </a>
                            @endif
                        </div>
                    </form>

                    @if($metrics)
                        {{-- Métricas Generales --}}
                        <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                            {{-- Total de Tickets --}}
                            <div class="p-4 bg-white rounded-lg shadow">
                                <h4 class="text-sm font-medium text-gray-500">Total de Tickets</h4>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $metrics['total'] }}</p>
                            </div>

                            {{-- Tiempo Promedio de Resolución --}}
                            <div class="p-4 bg-white rounded-lg shadow">
                                <h4 class="text-sm font-medium text-gray-500">Tiempo Promedio de Resolución</h4>
                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ $metrics['tiempo_promedio'] }}
                                    <span class="text-base font-normal text-gray-500">horas</span>
                                </p>
                            </div>

                            {{-- Calificación Promedio --}}
                            <div class="p-4 bg-white rounded-lg shadow">
                                <h4 class="text-sm font-medium text-gray-500">Calificación Promedio</h4>
                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ $metrics['calificacion'] }}
                                    <span class="text-base font-normal text-gray-500">/ 5</span>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                            {{-- Gráfico de Estado de Tickets --}}
                            <div class="p-6 bg-white rounded-lg shadow">
                                <h3 class="mb-4 text-lg font-medium text-gray-900">Tickets por Estado</h3>
                                <canvas id="ticketsEstadoChart"></canvas>
                            </div>

                            {{-- Gráfico de Tickets por Técnico --}}
                            <div class="p-6 bg-white rounded-lg shadow">
                                <h3 class="mb-4 text-lg font-medium text-gray-900">Tickets por Técnico</h3>
                                <canvas id="ticketsTecnicoChart"></canvas>
                            </div>
                        </div>

                        @push('scripts')
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            // Configuración de colores
                            const colors = {
                                nuevo: '#60A5FA',      // blue-400
                                asignado: '#F59E0B',   // amber-500
                                proceso: '#10B981',    // emerald-500
                                espera: '#6366F1',     // indigo-500
                                resuelto: '#34D399',   // emerald-400
                                cerrado: '#9CA3AF',    // gray-400
                                rechazado: '#EF4444',  // red-500
                            };

                            // Gráfico de Estado de Tickets
                            const ticketsEstadoCtx = document.getElementById('ticketsEstadoChart').getContext('2d');
                            new Chart(ticketsEstadoCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: Object.keys(@json($metrics['por_estado'])),
                                    datasets: [{
                                        data: Object.values(@json($metrics['por_estado'])),
                                        backgroundColor: Object.keys(@json($metrics['por_estado'])).map(estado => colors[estado]),
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                        }
                                    }
                                }
                            });

                            // Gráfico de Tickets por Técnico
                            const ticketsTecnicoCtx = document.getElementById('ticketsTecnicoChart').getContext('2d');
                            new Chart(ticketsTecnicoCtx, {
                                type: 'bar',
                                data: {
                                    labels: Object.keys(@json($metrics['por_tecnico'])),
                                    datasets: [{
                                        label: 'Tickets Asignados',
                                        data: Object.values(@json($metrics['por_tecnico'])),
                                        backgroundColor: '#6366F1',
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                        @endpush
                    @else
                        <div class="p-4 text-sm text-center text-gray-500">
                            Selecciona un rango de fechas para generar el reporte.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>