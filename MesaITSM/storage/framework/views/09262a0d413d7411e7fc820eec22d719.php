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
        <div class="flex items-center">
            <a href="<?php echo e(route('catalog.category', $service->category)); ?>" class="mr-2 text-indigo-600 hover:text-indigo-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                <?php echo e($service->name); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            <div class="p-8 bg-white rounded-lg shadow-sm">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-indigo-100">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <h2 class="ml-4 text-2xl font-bold text-gray-900">
                                <?php echo e($service->name); ?>

                            </h2>
                        </div>

                        <div class="prose max-w-none">
                            <p><?php echo e($service->description); ?></p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-6 sm:grid-cols-4">
                            <div class="overflow-hidden bg-gray-50 rounded-lg border border-gray-200">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Tiempo Estimado
                                    </dt>
                                    <dd class="mt-1 text-xl font-semibold text-gray-900">
                                        <?php echo e($service->estimated_time); ?>

                                    </dd>
                                </div>
                            </div>

                            <div class="overflow-hidden bg-gray-50 rounded-lg border border-gray-200">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        Departamento
                                    </dt>
                                    <dd class="mt-1 text-xl font-semibold text-gray-900">
                                        <?php echo e($service->department); ?>

                                    </dd>
                                </div>
                            </div>

                            <div class="overflow-hidden bg-gray-50 rounded-lg border border-gray-200">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        Categoría
                                    </dt>
                                    <dd class="mt-1 text-xl font-semibold text-gray-900">
                                        <?php echo e($service->category->name); ?>

                                    </dd>
                                </div>
                            </div>

                            <div class="overflow-hidden bg-gray-50 rounded-lg border border-gray-200">
                                <div class="px-4 py-5 sm:p-6">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Prioridad
                                    </dt>
                                    <dd class="mt-1">
                                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                            'px-2 inline-flex text-sm font-semibold rounded-full',
                                            'bg-gray-100 text-gray-800' => $service->priority_default === 'baja',
                                            'bg-yellow-100 text-yellow-800' => $service->priority_default === 'media',
                                            'bg-orange-100 text-orange-800' => $service->priority_default === 'alta',
                                            'bg-red-100 text-red-800' => $service->priority_default === 'critica',
                                        ]); ?>">
                                            <?php echo e(ucfirst($service->priority_default)); ?>

                                        </span>
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <a href="<?php echo e(route('tickets.create', ['service_id' => $service->id])); ?>"
                                class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Solicitar Servicio
                            </a>
                        </div>
                    </div>

                    <div class="hidden mt-8 md:block md:mt-0">
                        <div class="sticky p-6 space-y-6 bg-gray-50 rounded-lg top-8 border border-gray-200">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    Información Importante
                                </h3>
                                <div class="mt-2 space-y-4 text-sm text-gray-500">
                                    <p class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        El tiempo de resolución es estimado y puede variar según la complejidad de la solicitud.
                                    </p>
                                    <p class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Al solicitar el servicio, deberás completar un formulario con información específica.
                                    </p>
                                    <p class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        Podrás hacer seguimiento y agregar comentarios a tu solicitud.
                                    </p>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    ¿Necesitas ayuda?
                                </h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p>Si tienes dudas sobre este servicio, contacta al departamento de soporte.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/user/catalog/show.blade.php ENDPATH**/ ?>