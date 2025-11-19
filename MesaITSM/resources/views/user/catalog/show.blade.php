<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('catalogo.categoria', $service->category) }}" class="mr-2 text-indigo-600 hover:text-indigo-900">
                @svg('heroicon-o-chevron-left', 'w-5 h-5')
            </a>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $service->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Descripción del servicio --}}
            <div class="p-8 bg-white rounded-lg shadow-sm">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 w-10 h-10 text-indigo-600">
                                @svg('heroicon-o-' . $service->icon)
                            </div>
                            <h2 class="ml-4 text-2xl font-bold text-gray-900">
                                {{ $service->name }}
                            </h2>
                        </div>

                        <div class="prose max-w-none">
                            <p>{{ $service->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-6 sm:grid-cols-4">
                            <div class="overflow-hidden bg-white rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        @svg('heroicon-o-clock', 'w-5 h-5 mr-2')
                                        Tiempo Estimado
                                    </dt>
                                    <dd class="mt-1 text-xl font-semibold text-gray-900">
                                        {{ $service->estimated_time }}
                                    </dd>
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        @svg('heroicon-o-office-building', 'w-5 h-5 mr-2')
                                        Departamento
                                    </dt>
                                    <dd class="mt-1 text-xl font-semibold text-gray-900">
                                        {{ $service->department }}
                                    </dd>
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        @svg('heroicon-o-tag', 'w-5 h-5 mr-2')
                                        Categoría
                                    </dt>
                                    <dd class="mt-1 text-xl font-semibold text-gray-900">
                                        {{ $service->category->name }}
                                    </dd>
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        @svg('heroicon-o-exclamation', 'w-5 h-5 mr-2')
                                        Prioridad
                                    </dt>
                                    <dd class="mt-1">
                                        <span @class([
                                            'px-2 inline-flex text-sm font-semibold rounded-full',
                                            'bg-gray-100 text-gray-800' => $service->priority_default === 'baja',
                                            'bg-yellow-100 text-yellow-800' => $service->priority_default === 'media',
                                            'bg-orange-100 text-orange-800' => $service->priority_default === 'alta',
                                            'bg-red-100 text-red-800' => $service->priority_default === 'critica',
                                        ])>
                                            {{ ucfirst($service->priority_default) }}
                                        </span>
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <a href="{{ route('catalogo.solicitar', $service) }}"
                                class="inline-flex items-center px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                @svg('heroicon-o-plus', 'w-5 h-5 mr-2')
                                Solicitar Servicio
                            </a>
                        </div>
                    </div>

                    <div class="hidden mt-8 md:block md:mt-0">
                        <div class="sticky p-6 space-y-6 bg-gray-50 rounded-lg top-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    Información Importante
                                </h3>
                                <div class="mt-2 space-y-4 text-sm text-gray-500">
                                    <p class="flex items-start">
                                        @svg('heroicon-o-clock', 'w-5 h-5 mr-2 text-gray-400 flex-shrink-0')
                                        El tiempo de resolución es estimado y puede variar según la complejidad de la solicitud.
                                    </p>
                                    <p class="flex items-start">
                                        @svg('heroicon-o-document-text', 'w-5 h-5 mr-2 text-gray-400 flex-shrink-0')
                                        Al solicitar el servicio, deberás completar un formulario con información específica.
                                    </p>
                                    <p class="flex items-start">
                                        @svg('heroicon-o-chat-alt', 'w-5 h-5 mr-2 text-gray-400 flex-shrink-0')
                                        Podrás hacer seguimiento y agregar comentarios a tu solicitud.
                                    </p>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    ¿Necesitas ayuda?
                                </h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p>Si tienes dudas sobre este servicio, contacta al departamento de soporte.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>