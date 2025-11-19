<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ isset($category) ? 'Editar Categoría' : 'Nueva Categoría' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Información de la Categoría
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Las categorías ayudan a organizar los servicios en grupos lógicos para facilitar su búsqueda.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ isset($category) ? route('admin.catalog.categories.update', $category) : route('admin.catalog.categories.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($category))
                            @method('PUT')
                        @endif

                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                                {{-- Nombre --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        Nombre
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            value="{{ old('name', $category->name ?? '') }}"
                                            required>
                                    </div>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Descripción --}}
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">
                                        Descripción
                                    </label>
                                    <div class="mt-1">
                                        <textarea name="description" id="description" rows="3"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $category->description ?? '') }}</textarea>
                                    </div>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Icono --}}
                                <div>
                                    <label for="icon" class="block text-sm font-medium text-gray-700">
                                        Icono
                                    </label>
                                    <div class="mt-1">
                                        <select name="icon" id="icon"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            required>
                                            @foreach([
                                                'cube' => 'Cubo',
                                                'cog' => 'Engranaje',
                                                'desktop-computer' => 'Computadora',
                                                'device-mobile' => 'Teléfono',
                                                'printer' => 'Impresora',
                                                'server' => 'Servidor',
                                                'wifi' => 'WiFi',
                                                'mail' => 'Correo',
                                                'key' => 'Llave',
                                                'user-group' => 'Usuarios',
                                                'document-text' => 'Documento',
                                                'chat' => 'Chat',
                                                'cloud' => 'Nube',
                                                'shield-check' => 'Escudo',
                                                'camera' => 'Cámara',
                                                'microphone' => 'Micrófono',
                                                'video-camera' => 'Videocámara',
                                                'database' => 'Base de datos',
                                                'chip' => 'Chip',
                                                'code' => 'Código'
                                            ] as $value => $label)
                                                <option value="{{ $value }}" 
                                                    {{ old('icon', $category->icon ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('icon')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Estado --}}
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_active" id="is_active"
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                            {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-700">Categoría activa</label>
                                        <p class="text-gray-500">Las categorías inactivas no serán visibles para los usuarios.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                <a href="{{ route('admin.catalog.categories') }}"
                                    class="inline-flex justify-center px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ isset($category) ? 'Actualizar' : 'Crear' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($category))
        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="mt-10 sm:mt-0">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Zona de Peligro</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Las acciones en esta sección son irreversibles.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                                <div class="space-y-4">
                                    <h4 class="text-lg font-medium text-red-600">Eliminar Categoría</h4>
                                    <p class="text-sm text-gray-500">
                                        Una vez eliminada la categoría, todos sus servicios también serán eliminados.
                                        Esta acción no se puede deshacer.
                                    </p>
                                    <form action="{{ route('admin.catalog.categories.destroy', $category) }}" 
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar esta categoría? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Eliminar Categoría
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>