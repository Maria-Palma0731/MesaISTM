<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Catálogo de Servicios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Categorías --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($categories as $category)
                    <a href="{{ route('catalogo.categoria', $category) }}"
                        class="flex flex-col h-full p-6 transition duration-200 bg-white rounded-lg shadow-sm hover:shadow-md">
                        <div class="flex items-center mb-4 text-indigo-600">
                            <div class="w-10 h-10">
                                @svg('heroicon-o-' . $category->icon)
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">
                                {{ $category->name }}
                            </h3>
                        </div>

                        <div class="flex-grow">
                            <p class="text-sm text-gray-500">
                                {{ $category->description }}
                            </p>
                        </div>

                        <div class="flex items-center mt-4">
                            <span class="px-2 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 rounded-full">
                                {{ $category->activeServices->count() }} servicios
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>