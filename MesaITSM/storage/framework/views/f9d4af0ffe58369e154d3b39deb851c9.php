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
                <h1 class="text-3xl font-bold text-gray-900">Categorías de Servicios</h1>
                <p class="mt-2 text-gray-600">Gestiona las categorías del catálogo de servicios</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Lista de Categorías</h2>
                            <p class="text-sm text-gray-600 mt-1">Arrastra para reordenar las categorías</p>
                        </div>
                        <a href="<?php echo e(route('admin.catalog.categories.create')); ?>"
                            class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-indigo-600 border border-transparent rounded-xl shadow-sm hover:bg-indigo-700 transition-colors">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nueva Categoría
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-3 py-3"></th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Descripción
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                        Servicios
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                        Orden
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" data-sortable>
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr data-id="<?php echo e($category->id); ?>" class="hover:bg-gray-50 transition-colors">
                                        <td class="px-3 py-4 cursor-move">
                                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6zm0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z"/>
                                            </svg>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-8 h-8 mr-3 flex items-center justify-center bg-indigo-100 rounded-lg">
                                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                    </svg>
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo e($category->name); ?>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 max-w-md">
                                                <?php echo e($category->description); ?>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                <?php echo e($category->services->count()); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                'px-3 py-1 inline-flex text-sm font-semibold rounded-full',
                                                'bg-green-100 text-green-800' => $category->is_active,
                                                'bg-gray-100 text-gray-800' => !$category->is_active,
                                            ]); ?>">
                                                <?php echo e($category->is_active ? 'Activa' : 'Inactiva'); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                            <?php echo e($category->order); ?>

                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap space-x-3">
                                            <a href="<?php echo e(route('admin.catalog.categories.edit', $category)); ?>" 
                                                class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                Editar
                                            </a>
                                            <form action="<?php echo e(route('admin.catalog.categories.destroy', $category)); ?>" 
                                                method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                </svg>
                                                <p class="text-gray-500 font-medium mb-2">No hay categorías registradas</p>
                                                <p class="text-gray-400 text-sm">Crea tu primera categoría para comenzar</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('[data-sortable]');
            
            if (table) {
                new Sortable(table, {
                    handle: '.cursor-move',
                    animation: 150,
                    onEnd: function() {
                        const items = [...table.querySelectorAll('[data-id]')];
                        const ids = items.map(item => item.dataset.id);

                        // Enviar orden al servidor
                        fetch('<?php echo e(route("admin.catalog.categories.reorder")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                categories: ids
                            })
                        }).then(response => {
                            if (!response.ok) {
                                console.error('Error al reordenar categorías');
                            }
                        });
                    }
                });
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
<?php endif; ?><?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/admin/catalog/categories/index.blade.php ENDPATH**/ ?>