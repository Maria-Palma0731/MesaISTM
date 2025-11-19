<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard de Usuario</h1>
            </div>

            
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Total de Tickets</div>
                    <div class="text-4xl font-bold text-gray-900"><?php echo e($totalTickets); ?></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Tickets Activos</div>
                    <div class="text-4xl font-bold text-yellow-600"><?php echo e($activeTickets); ?></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Tickets Resueltos</div>
                    <div class="text-4xl font-bold text-green-600"><?php echo e($resolvedTickets); ?></div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                Mis Tickets
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Gestiona tus solicitudes de soporte</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <span class="text-sm font-medium text-blue-900">Abiertos</span>
                            <span class="text-2xl font-bold text-blue-600"><?php echo e($openTickets); ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-cyan-50 rounded-lg">
                            <span class="text-sm font-medium text-cyan-900">En Progreso</span>
                            <span class="text-2xl font-bold text-cyan-600"><?php echo e($inProgressTickets); ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <span class="text-sm font-medium text-green-900">Resueltos</span>
                            <span class="text-2xl font-bold text-green-600"><?php echo e($resolvedTickets); ?></span>
                        </div>
                    </div>

                    <button onclick="openCreateModal()" 
                       class="flex items-center justify-center w-full px-4 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear Nuevo Ticket
                    </button>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Módulos del Sistema</h2>
                        <p class="text-sm text-gray-600 mt-1">Acceso rápido a funcionalidades</p>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="<?php echo e(route('tickets.index')); ?>" 
                           class="flex items-center justify-between p-4 rounded-xl hover:bg-blue-50 transition-colors group border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Mis Tickets</h3>
                                    <p class="text-xs text-gray-600">Ver mis solicitudes</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="#" 
                           class="flex items-center justify-between p-4 rounded-xl hover:bg-purple-50 transition-colors group border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-100 group-hover:bg-purple-200 transition-colors">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Catálogo de Servicios</h3>
                                    <p class="text-xs text-gray-600">Solicitar servicios</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="#" 
                           class="flex items-center justify-between p-4 rounded-xl hover:bg-cyan-50 transition-colors group border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-cyan-100 group-hover:bg-cyan-200 transition-colors">
                                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">Base de Conocimiento</h3>
                                    <p class="text-xs text-gray-600">Buscar soluciones</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-cyan-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Mis Tickets Recientes</h2>
                    <p class="text-sm text-gray-600 mt-1">Tus últimas solicitudes de soporte</p>
                </div>
                
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $recentTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="block">
                        <div class="flex items-center justify-between p-4 rounded-xl hover:bg-gray-50 transition-colors border border-gray-200">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-sm font-medium text-gray-500"><?php echo e($ticket->folio); ?></span>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                        <?php switch($ticket->priority):
                                            case ('baja'): ?> bg-green-100 text-green-700 <?php break; ?>
                                            <?php case ('media'): ?> bg-yellow-100 text-yellow-700 <?php break; ?>
                                            <?php case ('alta'): ?> bg-orange-100 text-orange-700 <?php break; ?>
                                            <?php case ('critica'): ?> bg-red-100 text-red-700 <?php break; ?>
                                        <?php endswitch; ?>">
                                        <?php echo e(ucfirst($ticket->priority)); ?>

                                    </span>
                                </div>
                                <h3 class="font-medium text-gray-900"><?php echo e($ticket->title); ?></h3>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-md
                                        <?php switch($ticket->status):
                                            case ('nuevo'): ?> bg-blue-100 text-blue-700 <?php break; ?>
                                            <?php case ('asignado'): ?> bg-purple-100 text-purple-700 <?php break; ?>
                                            <?php case ('en_proceso'): ?> bg-cyan-100 text-cyan-700 <?php break; ?>
                                            <?php case ('pendiente_usuario'): ?> bg-orange-100 text-orange-700 <?php break; ?>
                                            <?php case ('resuelto'): ?> bg-green-100 text-green-700 <?php break; ?>
                                            <?php case ('cerrado'): ?> bg-gray-100 text-gray-700 <?php break; ?>
                                        <?php endswitch; ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

                                    </span>
                                    <span class="flex items-center text-xs text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Hace <?php echo e($ticket->created_at->diffForHumans()); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay tickets</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza creando tu primer ticket de soporte</p>
                        <div class="mt-6">
                            <a href="<?php echo e(route('tickets.index')); ?>" 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                Crear Ticket
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if($recentTickets->count() > 0): ?>
                <div class="mt-6 text-center">
                    <a href="<?php echo e(route('tickets.index')); ?>" 
                       class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                        Ver todos los tickets
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeCreateModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="px-8 pt-6 pb-6 bg-white">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="text-2xl font-semibold text-gray-900" id="modal-title">
                            Crear Nuevo Ticket
                        </h3>
                        <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="createTicketForm" method="POST" action="<?php echo e(route('tickets.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="space-y-5 mt-6">
                            <div>
                                <label for="create_title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                                <input type="text" name="title" id="create_title" required
                                    placeholder="Breve descripción del problema"
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0">
                            </div>

                            <div>
                                <label for="create_description" class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                                <textarea name="description" id="create_description" rows="4" required
                                    placeholder="Describe detalladamente el problema o solicitud"
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0 resize-none"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="create_category" class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
                                    <select name="category" id="create_category" required
                                        class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0">
                                        <option value="">Selecciona una categoría</option>
                                        <option value="hardware">Hardware</option>
                                        <option value="software">Software</option>
                                        <option value="red">Red</option>
                                        <option value="acceso">Acceso</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="create_subcategory" class="block text-sm font-medium text-gray-700 mb-2">Subcategoría *</label>
                                    <select name="subcategory" id="create_subcategory" required
                                        class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0">
                                        <option value="">Selecciona una subcategoría</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="create_priority" class="block text-sm font-medium text-gray-700 mb-2">Prioridad *</label>
                                <select name="priority" id="create_priority" required
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0">
                                    <option value="baja">Baja</option>
                                    <option value="media" selected>Media</option>
                                    <option value="alta">Alta</option>
                                    <option value="critica">Crítica</option>
                                </select>
                            </div>

                            <div>
                                <label for="create_attachments" class="block text-sm font-medium text-gray-700 mb-2">Archivos adjuntos (opcional)</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="create_attachments" class="flex flex-col items-center justify-center w-full h-20 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex items-center space-x-2 text-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <span class="text-sm text-gray-500"><span class="font-semibold">Elegir archivos</span> o arrastrar aquí</span>
                                        </div>
                                        <input id="create_attachments" name="attachments[]" type="file" class="hidden" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" />
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Máximo 3 archivos, 5MB cada uno. Formatos: imágenes, PDF, documentos de Office.</p>
                                <div id="fileList" class="mt-2 text-sm text-gray-600"></div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-8">
                            <button type="button" onclick="closeCreateModal()"
                                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                                Crear Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Subcategorías por categoría
        const subcategories = {
            'hardware': ['Computadora', 'Impresora', 'Pantalla', 'Teclado/Mouse', 'Otro'],
            'software': ['Windows', 'Office', 'Navegador', 'Aplicación específica', 'Otro'],
            'red': ['Internet lento', 'Sin conexión', 'WiFi', 'VPN', 'Otro'],
            'acceso': ['Contraseña', 'Permisos', 'Usuario bloqueado', 'Nuevo acceso', 'Otro'],
            'otro': ['Consulta general', 'Solicitud', 'Otro']
        };

        function openCreateModal() {
            // Limpiar el formulario
            document.getElementById('createTicketForm').reset();
            document.getElementById('create_title').value = '';
            document.getElementById('create_description').value = '';
            document.getElementById('create_priority').value = 'media';
            document.getElementById('create_category').value = '';
            document.getElementById('create_subcategory').value = '';
            document.getElementById('create_subcategory').innerHTML = '<option value="">Selecciona una subcategoría</option>';
            document.getElementById('fileList').innerHTML = '';
            
            // Mostrar modal
            document.getElementById('createModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cambio de categoría actualiza subcategorías
        document.getElementById('create_category').addEventListener('change', function() {
            const category = this.value;
            const subcategorySelect = document.getElementById('create_subcategory');
            
            subcategorySelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';
            
            if (category && subcategories[category]) {
                subcategories[category].forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.toLowerCase().replace(/ /g, '_');
                    option.textContent = sub;
                    subcategorySelect.appendChild(option);
                });
            }
        });

        // Mostrar archivos seleccionados
        document.getElementById('create_attachments').addEventListener('change', function(e) {
            const fileList = document.getElementById('fileList');
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                fileList.innerHTML = '<strong>Archivos seleccionados:</strong> ' + files.map(f => f.name).join(', ');
            } else {
                fileList.innerHTML = '';
            }
        });

        // Envío del formulario con AJAX
        document.getElementById('createTicketForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert('✅ Ticket creado exitosamente!\nFolio: ' + data.folio);
                    closeCreateModal();
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'No se pudo crear el ticket'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al crear el ticket. Por favor intenta de nuevo.');
            }
        });

        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/usuario/dashboard.blade.php ENDPATH**/ ?>