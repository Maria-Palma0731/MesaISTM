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
                <h1 class="text-3xl font-bold text-gray-900">Mis Tickets</h1>
                <p class="text-gray-600 mt-1">Gestiona tus tickets asignados</p>
            </div>

            <!-- Filtros -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                <form action="<?php echo e(route('tecnico.tickets.index')); ?>" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos</option>
                                <option value="asignado" <?php echo e(request('status') == 'asignado' ? 'selected' : ''); ?>>Asignado</option>
                                <option value="en_proceso" <?php echo e(request('status') == 'en_proceso' ? 'selected' : ''); ?>>En Proceso</option>
                                <option value="pendiente_usuario" <?php echo e(request('status') == 'pendiente_usuario' ? 'selected' : ''); ?>>Pendiente de Usuario</option>
                                <option value="resuelto" <?php echo e(request('status') == 'resuelto' ? 'selected' : ''); ?>>Resuelto</option>
                            </select>
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                            <select name="priority" id="priority" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todas</option>
                                <option value="critica" <?php echo e(request('priority') == 'critica' ? 'selected' : ''); ?>>Crítica</option>
                                <option value="alta" <?php echo e(request('priority') == 'alta' ? 'selected' : ''); ?>>Alta</option>
                                <option value="media" <?php echo e(request('priority') == 'media' ? 'selected' : ''); ?>>Media</option>
                                <option value="baja" <?php echo e(request('priority') == 'baja' ? 'selected' : ''); ?>>Baja</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                            <input type="date" name="date_from" id="date_from" value="<?php echo e(request('date_from')); ?>"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                            <input type="date" name="date_to" id="date_to" value="<?php echo e(request('date_to')); ?>"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" 
                                placeholder="Folio o título..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                Filtrar
                            </button>
                            <a href="<?php echo e(route('tecnico.tickets.index')); ?>" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Limpiar
                            </a>
                        </div>
                        <a href="<?php echo e(route('tickets.create')); ?>" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                            + Crear Ticket
                        </a>
                    </div>
                </form>
            </div>

            <!-- Lista de tickets -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('tecnico.tickets.show', $ticket)); ?>" class="block hover:bg-gray-50 transition-colors">
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-1 min-w-0">
                                        
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-sm font-medium text-gray-600"><?php echo e($ticket->folio); ?></span>
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded
                                                <?php if($ticket->priority === 'critica'): ?> bg-red-100 text-red-700
                                                <?php elseif($ticket->priority === 'alta'): ?> bg-orange-100 text-orange-700
                                                <?php elseif($ticket->priority === 'media'): ?> bg-yellow-100 text-yellow-700
                                                <?php else: ?> bg-green-100 text-green-700
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($ticket->priority)); ?>

                                            </span>
                                        </div>
                                        
                                        
                                        <h3 class="text-base font-semibold text-gray-900 mb-3 line-clamp-2">
                                            <?php echo e($ticket->title); ?>

                                        </h3>
                                        
                                        
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <span class="inline-flex px-3 py-1 rounded-md bg-blue-100 text-blue-700 text-xs font-medium">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

                                            </span>
                                            <span>De: <?php echo e($ticket->user->name); ?></span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <?php echo e($ticket->created_at->format('d/m/Y H:i')); ?>

                                            </span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 text-white font-semibold text-sm">
                                            <?php echo e(strtoupper(substr($ticket->user->name, 0, 2))); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No hay tickets asignados</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Paginación -->
            <?php if($tickets->hasPages()): ?>
            <div class="mt-6">
                <?php echo e($tickets->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
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
<?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/tecnico/tickets/index.blade.php ENDPATH**/ ?>