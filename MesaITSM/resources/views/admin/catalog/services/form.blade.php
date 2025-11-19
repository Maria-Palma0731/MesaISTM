<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ isset($service) ? 'Editar Servicio' : 'Nuevo Servicio' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Información del Servicio
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Completa la información básica del servicio. Los campos personalizados
                            del formulario se configuran en la siguiente sección.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ isset($service) ? route('admin.catalog.services.update', $service) : route('admin.catalog.services.store') }}"
                        method="POST"
                        id="serviceForm">
                        @csrf
                        @if(isset($service))
                            @method('PUT')
                        @endif

                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                                {{-- Categoría --}}
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">
                                        Categoría
                                    </label>
                                    <div class="mt-1">
                                        <select name="category_id" id="category_id"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            required>
                                            <option value="">Selecciona una categoría</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $service->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nombre --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        Nombre del Servicio
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            value="{{ old('name', $service->name ?? '') }}"
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
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $service->description ?? '') }}</textarea>
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
                                                'cog' => 'Engranaje',
                                                'desktop-computer' => 'Computadora',
                                                'device-mobile' => 'Teléfono',
                                                'printer' => 'Impresora',
                                                'server' => 'Servidor',
                                                'wifi' => 'WiFi',
                                                'mail' => 'Correo',
                                                'key' => 'Llave',
                                                'document-text' => 'Documento',
                                                'chat' => 'Chat',
                                                'user-group' => 'Usuarios',
                                                'cloud' => 'Nube',
                                                'shield-check' => 'Escudo',
                                                'camera' => 'Cámara',
                                                'microphone' => 'Micrófono',
                                                'video-camera' => 'Videocámara',
                                                'database' => 'Base de datos',
                                                'chip' => 'Chip',
                                                'code' => 'Código',
                                                'cube' => 'Cubo'
                                            ] as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('icon', $service->icon ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('icon')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Tiempo Estimado --}}
                                <div>
                                    <label for="estimated_time" class="block text-sm font-medium text-gray-700">
                                        Tiempo Estimado de Resolución
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="estimated_time" id="estimated_time"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            value="{{ old('estimated_time', $service->estimated_time ?? '24 horas') }}"
                                            required>
                                    </div>
                                    @error('estimated_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Departamento --}}
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700">
                                        Departamento Responsable
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="department" id="department"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            value="{{ old('department', $service->department ?? '') }}"
                                            required>
                                    </div>
                                    @error('department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Prioridad por Defecto --}}
                                <div>
                                    <label for="priority_default" class="block text-sm font-medium text-gray-700">
                                        Prioridad por Defecto
                                    </label>
                                    <div class="mt-1">
                                        <select name="priority_default" id="priority_default"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            required>
                                            @foreach(['baja', 'media', 'alta', 'critica'] as $priority)
                                                <option value="{{ $priority }}"
                                                    {{ old('priority_default', $service->priority_default ?? '') == $priority ? 'selected' : '' }}>
                                                    {{ ucfirst($priority) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('priority_default')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Estado --}}
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_active" id="is_active"
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                            {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-700">Servicio activo</label>
                                        <p class="text-gray-500">Los servicios inactivos no serán visibles para los usuarios.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Campos del Formulario --}}
                        <div class="mt-6">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="md:col-span-1">
                                    <div class="px-4 sm:px-0">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                                            Campos del Formulario
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Define los campos que el usuario deberá completar al solicitar este servicio.
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <div class="shadow sm:rounded-md">
                                        <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                                            <div id="form-fields">
                                                <!-- Los campos se agregarán dinámicamente aquí -->
                                            </div>

                                            <div class="flex justify-end space-x-3">
                                                <button type="button" id="addField"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    Agregar Campo
                                                </button>
                                                <button type="button" id="previewForm"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 border border-transparent rounded-md hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Vista Previa
                                                </button>
                                            </div>
                                        </div>

                                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                            <input type="hidden" name="form_fields" id="form_fields_json">
                                            <a href="{{ route('admin.catalog.services') }}"
                                                class="inline-flex justify-center px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Cancelar
                                            </a>
                                            <button type="submit"
                                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                {{ isset($service) ? 'Actualizar' : 'Crear' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Vista Previa --}}
    <div class="fixed inset-0 z-10 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="previewModal">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                    <button type="button" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="closePreview">
                        <span class="sr-only">Cerrar</span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Vista Previa del Formulario
                        </h3>
                        <div class="mt-4">
                            <div id="previewContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formFields = document.getElementById('form-fields');
            const addFieldButton = document.getElementById('addField');
            const formFieldsInput = document.getElementById('form_fields_json');
            const previewButton = document.getElementById('previewForm');
            const previewModal = document.getElementById('previewModal');
            const closePreviewButton = document.getElementById('closePreview');
            const previewContent = document.getElementById('previewContent');

            // Cargar campos existentes si es edición
            @if(isset($service) && $service->form_fields)
                const existingFields = @json($service->form_fields);
                if (existingFields.campos) {
                    existingFields.campos.forEach(field => addFieldToForm(field));
                }
            @endif

            // Agregar nuevo campo
            addFieldButton.addEventListener('click', () => addFieldToForm());

            // Vista previa del formulario
            previewButton.addEventListener('click', function() {
                const fields = getFormFields();
                if (fields.campos.length === 0) {
                    alert('Agrega al menos un campo al formulario');
                    return;
                }

                fetch('{{ route("admin.catalog.services.preview") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        form_fields: fields
                    })
                })
                .then(response => response.text())
                .then(html => {
                    previewContent.innerHTML = html;
                    previewModal.classList.remove('hidden');
                });
            });

            // Cerrar modal de vista previa
            closePreviewButton.addEventListener('click', () => {
                previewModal.classList.add('hidden');
            });

            // Al enviar el formulario
            document.getElementById('serviceForm').addEventListener('submit', function() {
                const fields = getFormFields();
                if (fields.campos.length === 0) {
                    alert('Debes agregar al menos un campo al formulario');
                    event.preventDefault();
                    return;
                }
                formFieldsInput.value = JSON.stringify(fields);
            });

            function addFieldToForm(fieldData = null) {
                const fieldContainer = document.createElement('div');
                fieldContainer.className = 'p-4 mb-4 border border-gray-200 rounded-lg';

                const field = fieldData || {
                    name: '',
                    type: 'text',
                    label: '',
                    required: true,
                    options: {}
                };

                fieldContainer.innerHTML = `
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre del Campo</label>
                            <input type="text" class="field-name mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="${field.name}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Campo</label>
                            <select class="field-type mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="text" ${field.type === 'text' ? 'selected' : ''}>Texto</option>
                                <option value="textarea" ${field.type === 'textarea' ? 'selected' : ''}>Área de Texto</option>
                                <option value="select" ${field.type === 'select' ? 'selected' : ''}>Lista Desplegable</option>
                                <option value="radio" ${field.type === 'radio' ? 'selected' : ''}>Opción Única (Radio)</option>
                                <option value="checkbox" ${field.type === 'checkbox' ? 'selected' : ''}>Casilla de Verificación</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Etiqueta</label>
                            <input type="text" class="field-label mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="${field.label}" required>
                        </div>
                        <div class="options-container ${['select', 'radio'].includes(field.type) ? '' : 'hidden'} sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Opciones (una por línea)</label>
                            <textarea class="field-options mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="3">${
                                field.options ? Object.entries(field.options).map(([key, value]) => `${key}:${value}`).join('\n') : ''
                            }</textarea>
                        </div>
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" class="field-required w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                    ${field.required ? 'checked' : ''}>
                                <span class="ml-2 text-sm text-gray-700">Campo requerido</span>
                            </label>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="delete-field inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-100 border border-transparent rounded-md hover:bg-red-200">
                                Eliminar Campo
                            </button>
                        </div>
                    </div>
                `;

                // Eventos
                fieldContainer.querySelector('.field-type').addEventListener('change', function(e) {
                    const optionsContainer = fieldContainer.querySelector('.options-container');
                    optionsContainer.classList.toggle('hidden', !['select', 'radio'].includes(e.target.value));
                });

                fieldContainer.querySelector('.delete-field').addEventListener('click', () => {
                    fieldContainer.remove();
                });

                formFields.appendChild(fieldContainer);
            }

            function getFormFields() {
                const fields = [];
                formFields.querySelectorAll('.p-4').forEach(container => {
                    const field = {
                        name: container.querySelector('.field-name').value.trim(),
                        type: container.querySelector('.field-type').value,
                        label: container.querySelector('.field-label').value.trim(),
                        required: container.querySelector('.field-required').checked
                    };

                    if (['select', 'radio'].includes(field.type)) {
                        const options = {};
                        container.querySelector('.field-options').value.split('\n')
                            .map(line => line.trim())
                            .filter(line => line)
                            .forEach(line => {
                                const [key, value] = line.split(':').map(part => part.trim());
                                options[key] = value || key;
                            });
                        field.options = options;
                    }

                    fields.push(field);
                });

                return { campos: fields };
            }
        });
    </script>
    @endpush
</x-app-layout>