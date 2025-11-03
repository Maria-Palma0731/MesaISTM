<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('catalogo.servicio', $service) }}" class="mr-2 text-indigo-600 hover:text-indigo-900">
                @svg('heroicon-o-chevron-left', 'w-5 h-5')
            </a>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Solicitar: {{ $service->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Detalles del Servicio
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Completa la siguiente información para enviar tu solicitud.
                            Los campos marcados con asterisco son obligatorios.
                        </p>

                        <div class="mt-6 space-y-4">
                            <div class="flex items-center">
                                @svg('heroicon-o-clock', 'w-5 h-5 mr-2 text-gray-400')
                                <span class="text-sm text-gray-500">
                                    Tiempo estimado: {{ $service->estimated_time }}
                                </span>
                            </div>
                            
                            <div class="flex items-center">
                                @svg('heroicon-o-office-building', 'w-5 h-5 mr-2 text-gray-400')
                                <span class="text-sm text-gray-500">
                                    Departamento: {{ $service->department }}
                                </span>
                            </div>

                            <div class="flex items-center">
                                @svg('heroicon-o-exclamation', 'w-5 h-5 mr-2 text-gray-400')
                                <span class="text-sm text-gray-500">
                                    Prioridad:
                                    <span @class([
                                        'px-2 inline-flex text-xs font-semibold rounded-full ml-1',
                                        'bg-gray-100 text-gray-800' => $service->priority_default === 'baja',
                                        'bg-yellow-100 text-yellow-800' => $service->priority_default === 'media',
                                        'bg-orange-100 text-orange-800' => $service->priority_default === 'alta',
                                        'bg-red-100 text-red-800' => $service->priority_default === 'critica',
                                    ])>
                                        {{ ucfirst($service->priority_default) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('catalogo.request', $service) }}" method="POST">
                        @csrf

                        <input type="hidden" name="service_id" value="{{ $service->id }}">

                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                                {!! $service->generateFormHtml() !!}

                                @if($errors->any())
                                    <div class="p-4 rounded-md bg-red-50">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                @svg('heroicon-s-x-circle', 'h-5 w-5 text-red-400')
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">
                                                    Se encontraron {{ $errors->count() }} errores
                                                </h3>
                                                <div class="mt-2 text-sm text-red-700">
                                                    <ul class="pl-5 space-y-1 list-disc">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                <a href="{{ route('catalogo.servicio', $service) }}"
                                    class="inline-flex justify-center px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Enviar Solicitud
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>