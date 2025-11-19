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
            Ticket #<?php echo e($ticket->folio); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Card principal del ticket -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4 text-gray-900">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium">
                            <?php echo e($ticket->title); ?>

                        </h3>
                        <div class="flex items-center space-x-3">
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php switch($ticket->priority):
                                    case ('baja'): ?> bg-green-100 text-green-800 <?php break; ?>
                                    <?php case ('media'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                    <?php case ('alta'): ?> bg-red-100 text-red-800 <?php break; ?>
                                <?php endswitch; ?>">
                                <?php echo e(ucfirst($ticket->priority)); ?>

                            </span>
                        </div>
                    </div>

                    <!-- Detalles del ticket -->
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Categoría:</span>
                            <?php echo e(ucfirst($ticket->category)); ?>

                            <?php if($ticket->subcategory): ?>
                                - <?php echo e(ucfirst($ticket->subcategory)); ?>

                            <?php endif; ?>
                        </div>
                        <div>
                            <span class="font-medium">Creado por:</span>
                            <?php echo e($ticket->user->name); ?>

                        </div>
                        <div>
                            <span class="font-medium">Creado el:</span>
                            <?php echo e($ticket->created_at->format('d/m/Y H:i')); ?>

                        </div>
                        <?php if($ticket->assignedTo): ?>
                            <div>
                                <span class="font-medium">Asignado a:</span>
                                <?php echo e($ticket->assignedTo->name); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Descripción -->
                    <div class="pt-4 border-t">
                        <h4 class="mb-2 font-medium">Descripción</h4>
                        <div class="max-w-none prose">
                            <?php echo nl2br(e($ticket->description)); ?>

                        </div>
                    </div>

                    <!-- Archivos adjuntos -->
                    <?php if($ticket->attachments->count() > 0): ?>
                        <div class="pt-4 border-t">
                            <h4 class="mb-2 font-medium">Archivos Adjuntos</h4>
                            <ul class="space-y-2">
                                <?php $__currentLoopData = $ticket->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route('tickets.attachment.download', $attachment)); ?>" 
                                            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                            </svg>
                                            <?php echo e($attachment->filename); ?>

                                            <span class="ml-1 text-gray-500">
                                                (<?php echo e(number_format($attachment->file_size / 1024, 1)); ?> KB)
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario de calificación -->
                    <?php if($ticket->status === 'resuelto' && $ticket->user_id === auth()->id()): ?>
                        <div class="pt-4 border-t">
                            <form action="<?php echo e(route('tickets.close', $ticket)); ?>" method="POST" class="space-y-4">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>

                                <h4 class="mb-2 font-medium">Calificar y cerrar ticket</h4>
                                
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        ¿Qué tan satisfecho estás con la atención recibida?
                                    </label>
                                    <div class="flex gap-4">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <label class="flex items-center">
                                                <input type="radio" name="rating" value="<?php echo e($i); ?>" class="sr-only peer" required>
                                                <div class="w-8 h-8 text-center text-gray-500 border rounded-full cursor-pointer peer-checked:bg-yellow-400 peer-checked:border-yellow-400 peer-checked:text-white hover:bg-yellow-50">
                                                    <?php echo e($i); ?>

                                                </div>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                    <?php $__errorArgs = ['rating'];
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
                                    <label for="rating_comment" class="block text-sm font-medium text-gray-700">
                                        Comentarios adicionales (opcional)
                                    </label>
                                    <textarea name="rating_comment" id="rating_comment" rows="3"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                    <?php $__errorArgs = ['rating_comment'];
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

                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Calificar y cerrar ticket
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Historial del ticket -->
            <?php if($ticket->history->isNotEmpty()): ?>
                <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="mb-4 text-lg font-medium">Historial del ticket</h4>

                        <div class="flow-root">
                            <ul class="-mb-8">
                                <?php $__currentLoopData = $ticket->history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <div class="relative pb-8">
                                            <?php if(!$loop->last): ?>
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            <?php endif; ?>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="flex items-center justify-center w-8 h-8 rounded-full <?php echo e($history->getIconClass()); ?>">
                                                        <?php echo $history->getIcon(); ?>

                                                    </span>
                                                </div>
                                                <div class="flex justify-between flex-1 min-w-0 space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            <?php echo $history->getDescription(); ?>

                                                        </p>
                                                    </div>
                                                    <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                                        <time datetime="<?php echo e($history->created_at->format('Y-m-d H:i:s')); ?>">
                                                            <?php echo e($history->created_at->format('d/m/Y H:i')); ?>

                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\Proyecto-mesa\resources\views/tickets/show.blade.php ENDPATH**/ ?>