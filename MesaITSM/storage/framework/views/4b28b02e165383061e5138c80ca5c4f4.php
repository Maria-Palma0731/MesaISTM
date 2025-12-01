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
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Mis Tickets Asignados
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="p-4 mb-8 bg-white rounded-lg shadow">
                <form action="<?php echo e(route('tecnico.tickets.index')); ?>" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="status" id="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="asignado" <?php echo e(request('status') == 'asignado' ? 'selected' : ''); ?>>Asignado</option>
                            <option value="en_proceso" <?php echo e(request('status') == 'en_proceso' ? 'selected' : ''); ?>>En Proceso</option>
                            <option value="pendiente_usuario" <?php echo e(request('status') == 'pendiente_usuario' ? 'selected' : ''); ?>>Pendiente de Usuario</option>
                            <option value="resuelto" <?php echo e(request('status') == 'resuelto' ? 'selected' : ''); ?>>Resuelto</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Prioridad</label>
                        <select name="priority" id="priority" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todas</option>
                            <option value="alta" <?php echo e(request('priority') == 'alta' ? 'selected' : ''); ?>>Alta</option>
                            <option value="media" <?php echo e(request('priority') == 'media' ? 'selected' : ''); ?>>Media</option>
                            <option value="baja" <?php echo e(request('priority') == 'baja' ? 'selected' : ''); ?>>Baja</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                        <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" 
                            placeholder="Folio, título o descripción..."
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Filtrar
                        </button>
                        <a href="<?php echo e(route('tecnico.tickets.index')); ?>" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Lista de tickets -->
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <a href="<?php echo e(route('tecnico.tickets.show', $ticket)); ?>" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                <?php echo e($ticket->title); ?>

                                            </p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                <?php switch($ticket->priority):
                                                    case ('baja'): ?> bg-green-100 text-green-800 <?php break; ?>
                                                    <?php case ('media'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                                    <?php case ('alta'): ?> bg-red-100 text-red-800 <?php break; ?>
                                                <?php endswitch; ?>">
                                                <?php echo e(ucfirst($ticket->priority)); ?>

                                            </span>
                                        </div>
                                        <div class="flex flex-shrink-0 ml-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                <?php switch($ticket->status):
                                                    case ('asignado'): ?> bg-purple-100 text-purple-800 <?php break; ?>
                                                    <?php case ('en_proceso'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                                    <?php case ('pendiente_usuario'): ?> bg-orange-100 text-orange-800 <?php break; ?>
                                                    <?php case ('resuelto'): ?> bg-green-100 text-green-800 <?php break; ?>
                                                <?php endswitch; ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex gap-6">
                                            <p class="flex items-center text-sm text-gray-500">
                                                <span class="truncate">Folio: <?php echo e($ticket->folio); ?></span>
                                            </p>
                                            <p class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                                De: <?php echo e($ticket->user->name); ?>

                                            </p>
                                        </div>
                                        <div class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                            <svg class="flex-shrink-0 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-1">
                                                Creado el <?php echo e($ticket->created_at->format('d/m/Y H:i')); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="px-4 py-6 text-center text-gray-500 sm:px-6">
                            No hay tickets asignados
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                <?php echo e($tickets->links()); ?>

            </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/tecnico/tickets/index.blade.php ENDPATH**/ ?>