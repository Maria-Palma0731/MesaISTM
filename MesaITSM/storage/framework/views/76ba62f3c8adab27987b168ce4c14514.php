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
            Dashboard de Técnico
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Contadores -->
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-4">
                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Total de tickets asignados</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900"><?php echo e($counts['total_asignados']); ?></div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Tickets abiertos</div>
                    <div class="mt-1 text-3xl font-semibold text-blue-600"><?php echo e($counts['abiertos']); ?></div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Resueltos hoy</div>
                    <div class="mt-1 text-3xl font-semibold text-green-600"><?php echo e($counts['resueltos_hoy']); ?></div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Próximos a vencer SLA</div>
                    <div class="mt-1 text-3xl font-semibold text-yellow-500"><?php echo e($counts['proximos_vencer']); ?></div>
                </div>
            </div>

            <!-- Grid de 2 columnas -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Gráfica de tickets por estado -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">
                        Distribución de tickets por estado
                    </h3>
                    <div class="relative w-full" style="height: 300px;">
                        <canvas id="ticketsChart"></canvas>
                    </div>
                </div>

                <!-- Últimos 5 tickets -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Mis últimos tickets</h3>
                        <a href="<?php echo e(route('tecnico.tickets.index')); ?>" class="text-sm text-indigo-600 hover:text-indigo-900">
                            Ver todos
                        </a>
                    </div>
                    <div class="overflow-hidden">
                        <ul role="list" class="divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $assignedTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="py-4">
                                    <a href="<?php echo e(route('tecnico.tickets.show', $ticket)); ?>" class="block hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                <?php echo e($ticket->title); ?>

                                            </p>
                                            <div class="ml-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    <?php switch($ticket->status):
                                                        case ('nuevo'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                                        <?php case ('asignado'): ?> bg-purple-100 text-purple-800 <?php break; ?>
                                                        <?php case ('en_proceso'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                                        <?php case ('pendiente_usuario'): ?> bg-orange-100 text-orange-800 <?php break; ?>
                                                        <?php case ('resuelto'): ?> bg-green-100 text-green-800 <?php break; ?>
                                                        <?php case ('cerrado'): ?> bg-gray-100 text-gray-800 <?php break; ?>
                                                    <?php endswitch; ?>">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="flex text-sm text-gray-500">
                                                <p class="truncate">
                                                    De: <?php echo e($ticket->user->name); ?>

                                                </p>
                                                <p class="ml-auto">
                                                    <?php echo e($ticket->created_at->diffForHumans()); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="py-4 text-center text-gray-500">
                                    No hay tickets asignados
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos para la gráfica
        const ticketsData = <?php echo json_encode($ticketsPorEstado, 15, 512) ?>;
        
        // Colores para cada estado
        const statusColors = {
            'nuevo': '#3B82F6',       // blue-500
            'asignado': '#8B5CF6',    // purple-500
            'en_proceso': '#F59E0B',  // yellow-500
            'pendiente_usuario': '#F97316', // orange-500
            'resuelto': '#10B981',    // green-500
            'cerrado': '#6B7280'      // gray-500
        };

        // Preparar datos para Chart.js
        const labels = Object.keys(ticketsData).map(status => 
            status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ')
        );
        const data = Object.values(ticketsData);
        const colors = Object.keys(ticketsData).map(status => statusColors[status]);

        // Crear la gráfica
        new Chart(document.getElementById('ticketsChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
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
<?php endif; ?><?php /**PATH C:\laragon\www\Proyecto-mesa\resources\views/tecnico/dashboard.blade.php ENDPATH**/ ?>