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
            
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="<?php echo e(route('tecnico.tickets.index')); ?>" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                        ← Volver a mis tickets
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($ticket->folio ?? 'Sin folio'); ?></h1>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                <?php echo e($ticket->title); ?>

                            </h2>
                            <div class="flex gap-2">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded
                                    <?php if($ticket->priority === 'critica'): ?> bg-red-100 text-red-700
                                    <?php elseif($ticket->priority === 'alta'): ?> bg-orange-100 text-orange-700
                                    <?php elseif($ticket->priority === 'media'): ?> bg-yellow-100 text-yellow-700
                                    <?php else: ?> bg-green-100 text-green-700
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($ticket->priority)); ?>

                                </span>
                                <span class="inline-flex px-3 py-1 rounded-md bg-blue-100 text-blue-700 text-xs font-medium">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

                                </span>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm text-gray-600 mb-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium">Usuario:</span>
                                <span><?php echo e($ticket->user->name); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span class="font-medium">Categoría:</span>
                                <span><?php echo e(ucfirst($ticket->category)); ?>

                                    <?php if($ticket->subcategory): ?>
                                        - <?php echo e(ucfirst($ticket->subcategory)); ?>

                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">Creado:</span>
                                <span><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></span>
                            </div>
                            <?php if($ticket->timeLogs->isNotEmpty()): ?>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <span class="font-medium">Tiempo invertido:</span>
                                <span><?php echo e($ticket->timeLogs->sum('minutes')); ?> minutos</span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-2">Descripción</h3>
                            <div class="text-sm text-gray-600 whitespace-pre-wrap"><?php echo e($ticket->description); ?></div>
                        </div>
                    </div>

                    
                    <?php if(!in_array($ticket->status, ['cerrado', 'resuelto', 'cancelado'])): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                        
                        <form action="<?php echo e(route('tecnico.tickets.update', $ticket)); ?>" method="POST" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cambiar Estado
                                    </label>
                                    <select name="status" id="status" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Seleccionar estado</option>
                                        <?php if($ticket->status === 'nuevo'): ?>
                                            <option value="asignado">Asignado</option>
                                            <option value="en_proceso">En Proceso</option>
                                        <?php endif; ?>
                                        <?php if($ticket->status === 'asignado'): ?>
                                            <option value="en_proceso">En Proceso</option>
                                        <?php endif; ?>
                                        <?php if(in_array($ticket->status, ['asignado', 'en_proceso'])): ?>
                                            <option value="pendiente_usuario">Pendiente de Usuario</option>
                                            <option value="resuelto">Resuelto</option>
                                        <?php endif; ?>
                                        <?php if($ticket->status === 'pendiente_usuario'): ?>
                                            <option value="en_proceso">En Proceso</option>
                                            <option value="resuelto">Resuelto</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cambiar Prioridad
                                    </label>
                                    <select name="priority" id="priority"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">No cambiar</option>
                                        <option value="baja" <?php echo e($ticket->priority === 'baja' ? 'selected' : ''); ?>>Baja</option>
                                        <option value="media" <?php echo e($ticket->priority === 'media' ? 'selected' : ''); ?>>Media</option>
                                        <option value="alta" <?php echo e($ticket->priority === 'alta' ? 'selected' : ''); ?>>Alta</option>
                                        <option value="critica" <?php echo e($ticket->priority === 'critica' ? 'selected' : ''); ?>>Crítica</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                
                                <div>
                                    <label for="time_minutes" class="block text-sm font-medium text-gray-700 mb-1">
                                        Tiempo Invertido (minutos)
                                    </label>
                                    <input type="number" name="time_minutes" id="time_minutes" 
                                        min="1" max="480" placeholder="15"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <?php $__errorArgs = ['time_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div>
                                    <label for="time_description" class="block text-sm font-medium text-gray-700 mb-1">
                                        Descripción del Trabajo
                                    </label>
                                    <input type="text" name="time_description" id="time_description" 
                                        placeholder="Ej: Análisis del problema"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <?php $__errorArgs = ['time_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div>
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                                    Agregar Comentario
                                </label>
                                <textarea name="comment" id="comment" rows="3" 
                                    placeholder="Describe las acciones realizadas o actualizaciones..."
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                                <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="flex items-center">
                                <input type="checkbox" name="is_internal" id="is_internal" value="1"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="is_internal" class="ml-2 block text-sm text-gray-700">
                                    Marcar como comentario interno (no visible para el usuario)
                                </label>
                            </div>

                            
                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                                <button type="button" onclick="document.getElementById('modalEscalar').classList.remove('hidden')"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Escalar Ticket
                                </button>
                                <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                    Actualizar Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($ticket->attachments->isNotEmpty()): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Archivos adjuntos</h3>
                        <ul class="divide-y divide-gray-200">
                            <?php $__currentLoopData = $ticket->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-center justify-between py-3">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                <?php echo e($attachment->filename); ?>

                                            </p>
                                            <p class="text-xs text-gray-500">
                                                <?php echo e(number_format($attachment->file_size / 1024, 1)); ?> KB
                                            </p>
                                        </div>
                                    </div>
                                    <a href="<?php echo e(route('tickets.attachment.download', $attachment)); ?>" 
                                        class="ml-4 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        Descargar
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($ticket->comments->isNotEmpty()): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Comentarios</h3>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $ticket->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-500 text-white font-semibold text-sm">
                                            <?php echo e(strtoupper(substr($comment->user->name, 0, 2))); ?>

                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold text-gray-900"><?php echo e($comment->user->name); ?></span>
                                            <span class="text-xs text-gray-500"><?php echo e($comment->created_at->format('d/m/Y H:i')); ?></span>
                                            <?php if($comment->is_internal): ?>
                                                <span class="inline-flex px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded">
                                                    Interno
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-1"><?php echo e($comment->comment); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                
                <div class="space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Historial</h3>
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $ticket->history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="relative pb-4">
                                    <?php if(!$loop->last): ?>
                                        <span class="absolute top-5 left-2.5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <?php endif; ?>
                                    <div class="relative flex items-start gap-3">
                                        <div>
                                            <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-100 ring-4 ring-white">
                                                <div class="h-2 w-2 rounded-full bg-gray-400"></div>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm text-gray-900"><?php echo e($history->description); ?></p>
                                                <p class="mt-0.5 text-xs text-gray-500">
                                                    <?php echo e($history->user->name); ?> - <?php echo e($history->created_at->format('d/m/Y H:i')); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-sm text-gray-500">No hay historial disponible</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if($ticket->timeLogs->isNotEmpty()): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Registro de tiempo</h3>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $ticket->timeLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between items-start py-2 border-b border-gray-100 last:border-0">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900"><?php echo e($log->description); ?></p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php echo e($log->user->name); ?> - <?php echo e($log->created_at->format('d/m/Y H:i')); ?>

                                        </p>
                                    </div>
                                    <span class="text-sm font-semibold text-indigo-600"><?php echo e($log->minutes); ?> min</span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="pt-3 border-t-2 border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-900">Total:</span>
                                    <span class="text-base font-bold text-indigo-600">
                                        <?php echo e($ticket->timeLogs->sum('minutes')); ?> min
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div id="modalEscalar" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-2xl bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Escalar Ticket</h3>
                    <button onclick="document.getElementById('modalEscalar').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="<?php echo e(route('tecnico.tickets.escalate', $ticket)); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">
                            Asignar a Técnico <span class="text-red-500">*</span>
                        </label>
                        <select name="assigned_to" id="assigned_to" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Seleccionar técnico</option>
                            <?php $__currentLoopData = $tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tecnico->id); ?>"><?php echo e($tecnico->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="escalate_comment" class="block text-sm font-medium text-gray-700 mb-1">
                            Motivo del Escalamiento <span class="text-red-500">*</span>
                        </label>
                        <textarea name="comment" id="escalate_comment" rows="3" required
                            placeholder="Explica por qué se escala este ticket..."
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        <p class="mt-1 text-xs text-gray-500">Este comentario será interno (no visible para el usuario)</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" 
                            onclick="document.getElementById('modalEscalar').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700">
                            Escalar Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Cerrar modal al hacer click fuera
        document.getElementById('modalEscalar')?.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
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
<?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/tecnico/tickets/show.blade.php ENDPATH**/ ?>