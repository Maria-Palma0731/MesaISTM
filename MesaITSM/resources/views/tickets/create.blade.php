<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Instrucciones -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Por favor, proporciona la mayor cantidad de detalles posible para ayudarnos a atender tu solicitud de manera eficiente.
                    </p>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Título -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            Título del Ticket <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror"
                            placeholder="Describe brevemente tu problema o solicitud">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Descripción Detallada <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
                            placeholder="Proporciona todos los detalles que consideres relevantes">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid de Categoría, Subcategoría y Prioridad -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Categoría -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">
                                Categoría <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category') border-red-500 @enderror">
                                <option value="">Selecciona una categoría</option>
                                <option value="incidente" {{ old('category') === 'incidente' ? 'selected' : '' }}>Incidente</option>
                                <option value="solicitud_servicio" {{ old('category') === 'solicitud_servicio' ? 'selected' : '' }}>Solicitud de Servicio</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategoría -->
                        <div>
                            <label for="subcategory" class="block text-sm font-medium text-gray-700">
                                Subcategoría <span class="text-red-500">*</span>
                            </label>
                            <select name="subcategory" id="subcategory"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('subcategory') border-red-500 @enderror">
                                <option value="">Selecciona una subcategoría</option>
                                <option value="hardware" {{ old('subcategory') === 'hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="software" {{ old('subcategory') === 'software' ? 'selected' : '' }}>Software</option>
                                <option value="red" {{ old('subcategory') === 'red' ? 'selected' : '' }}>Red</option>
                                <option value="accesos" {{ old('subcategory') === 'accesos' ? 'selected' : '' }}>Accesos</option>
                                <option value="otro" {{ old('subcategory') === 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('subcategory')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prioridad -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">
                                Prioridad <span class="text-red-500">*</span>
                            </label>
                            <select name="priority" id="priority"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('priority') border-red-500 @enderror">
                                <option value="">Selecciona la prioridad</option>
                                <option value="baja" {{ old('priority') === 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('priority') === 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('priority') === 'alta' ? 'selected' : '' }}>Alta</option>
                                <option value="critica" {{ old('priority') === 'critica' ? 'selected' : '' }}>Crítica</option>
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Archivos Adjuntos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Archivos Adjuntos
                            <span class="text-xs text-gray-500">(Máximo 3 archivos, 5MB cada uno. Formatos: jpg, png, pdf, doc, docx)</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="attachments" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Seleccionar archivos</span>
                                        <input id="attachments" name="attachments[]" type="file" multiple class="sr-only" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('attachments')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('attachments.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Crear Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview de archivos seleccionados
        document.getElementById('attachments').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            if (files.length > 3) {
                alert('Solo puedes seleccionar hasta 3 archivos');
                e.target.value = '';
                return;
            }

            const validTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            const invalidFiles = files.filter(file => !validTypes.includes(file.type));
            
            if (invalidFiles.length > 0) {
                alert('Algunos archivos tienen un formato no permitido. Solo se permiten: jpg, png, pdf, doc, docx');
                e.target.value = '';
                return;
            }

            const tooLargeFiles = files.filter(file => file.size > 5 * 1024 * 1024);
            if (tooLargeFiles.length > 0) {
                alert('Algunos archivos superan el límite de 5MB');
                e.target.value = '';
                return;
            }
        });
    </script>
    @endpush
</x-app-layout>