<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Rendimiento de Técnicos</h1>
                    <p class="mt-2 text-gray-600">Métricas de productividad y eficiencia</p>
                </div>
                <a href="{{ route('admin.reports.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    ← Volver a Reportes
                </a>
            </div>

            {{-- Filtro de Fechas --}}
            <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <form method="GET" action="{{ route('admin.reports.technicians') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" name="date_from" id="date_from" value="{{ $dateFrom->format('Y-m-d') }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" name="date_to" id="date_to" value="{{ $dateTo->format('Y-m-d') }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Aplicar Filtros
                    </button>
                </form>
            </div>

            {{-- Tabla de Técnicos --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Rendimiento por Técnico</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Técnico</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets Asignados</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets Resueltos</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tasa de Resolución</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tiempo Promedio</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($technicians as $tecnico)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold text-sm">{{ substr($tecnico->name, 0, 2) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $tecnico->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tecnico->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        {{ $tecnico->tickets_asignados }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-green-600">
                                        {{ $tecnico->tickets_resueltos }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $tecnico->tasa_resolucion }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $tecnico->tasa_resolucion }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        {{ $tecnico->tiempo_promedio }} horas
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        No hay datos de técnicos disponibles para el período seleccionado
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Resumen General --}}
            @if($technicians->isNotEmpty())
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Tickets Asignados</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $technicians->sum('tickets_asignados') }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Tickets Resueltos</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $technicians->sum('tickets_resueltos') }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tasa Promedio de Resolución</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ round($technicians->avg('tasa_resolucion'), 2) }}%</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
