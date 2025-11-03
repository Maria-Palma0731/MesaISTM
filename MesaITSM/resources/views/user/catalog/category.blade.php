<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('catalogo') }}" class="mr-2 text-indigo-600 hover:text-indigo-900">
                @svg('heroicon-o-chevron-left', 'w-5 h-5')
            </a>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $category->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Descripción de la categoría --}}
            <div class="p-6 mb-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 text-indigo-600">
                            @svg('heroicon-o-' . $category->icon)
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            Acerca de esta categoría
                        </h3>
                        <p class="mt-1 text-gray-500">
                            {{ $category->description }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Lista de servicios --}}
            <div class="grid gap-6 md:grid-cols-2">
                @forelse($services as $service)
                    <a href="{{ route('catalogo.servicio', $service) }}"
                        class="flex flex-col h-full p-6 transition duration-200 bg-white rounded-lg shadow-sm hover:shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 text-indigo-600">
                                @svg('heroicon-o-' . $service->icon)
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">
                                {{ $service->name }}
                            </h3>
                        </div>

                        <p class="mt-3 text-sm text-gray-500 line-clamp-2">
                            {{ $service->description }}
                        </p>

                        <div class="flex items-center mt-4 space-x-4">
                            <div class="flex items-center text-sm text-gray-500">
                                @svg('heroicon-o-clock', 'w-5 h-5 mr-1')
                                {{ $service->estimated_time }}
                            </div>

                            <div class="flex items-center text-sm text-gray-500">
                                @svg('heroicon-o-office-building', 'w-5 h-5 mr-1')
                                {{ $service->department }}
                            </div>

                            <div>
                                <span @class([
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    'bg-gray-100 text-gray-800' => $service->priority_default === 'baja',
                                    'bg-yellow-100 text-yellow-800' => $service->priority_default === 'media',
                                    'bg-orange-100 text-orange-800' => $service->priority_default === 'alta',
                                    'bg-red-100 text-red-800' => $service->priority_default === 'critica',
                                ])>
                                    Prioridad {{ $service->priority_default }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-2">
                        <div class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-sm">
                            <div class="w-12 h-12 text-gray-400">
                                @svg('heroicon-o-inbox')
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay servicios</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                No se encontraron servicios activos en esta categoría.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>