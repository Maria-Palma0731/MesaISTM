<div class="flow-root">
    <ul role="list" class="-mb-8">
        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <div class="relative pb-8">
                    <?php if(!$loop->last): ?>
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    <?php endif; ?>
                    <div class="relative flex items-start space-x-3">
                        <div>
                            <!-- User avatar -->
                            <div class="relative px-1">
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'h-8 w-8 rounded-full ring-8 ring-white flex items-center justify-center text-lg font-semibold',
                                    'bg-blue-100 text-blue-700' => $comment->is_internal,
                                    'bg-gray-100 text-gray-700' => !$comment->is_internal,
                                ]); ?>">
                                    <?php echo e(strtoupper(substr($comment->user->name, 0, 1))); ?>

                                </div>
                                <?php if($comment->is_internal): ?>
                                    <span class="absolute -bottom-0.5 -right-1 rounded-tl bg-blue-500 px-0.5 py-px">
                                        <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.366 12.549c0-.319.375-.45.652-.261l4.322 2.958a.5.5 0 00.58-.001l4.322-2.957c.277-.19.652-.058.652.261V14c0 .276-.224.5-.5.5h-9.5a.5.5 0 01-.5-.5v-1.451zM10 0c-.552 0-1 .448-1 1v7.723L4.678 11.44A1.5 1.5 0 004 12.676V16c0 .552.448 1 1 1h10c.552 0 1-.448 1-1v-3.324c0-.474-.227-.917-.678-1.236L11 8.723V1c0-.552-.448-1-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div>
                                <div class="text-sm">
                                    <span class="font-medium text-gray-900">
                                        <?php echo e($comment->user->name); ?>

                                    </span>
                                    <span class="text-gray-500 ml-1">
                                        <?php echo e($comment->created_at->format('d/m/Y H:i')); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-700">
                                <p class="whitespace-pre-wrap"><?php echo e($comment->comment); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div><?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/components/ticket-comments.blade.php ENDPATH**/ ?>