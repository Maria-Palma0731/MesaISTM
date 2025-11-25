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
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="<?php echo e(route('admin.knowledge-base.index')); ?>" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver a la base de conocimiento
                </a>
            </div>

            
            <article class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                
                <div class="p-8 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-white">
                    <div class="flex items-center justify-between mb-4">
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'px-4 py-2 text-sm font-semibold rounded-full',
                            'bg-blue-100 text-blue-700' => $article->category === 'guias',
                            'bg-green-100 text-green-700' => $article->category === 'faq',
                            'bg-purple-100 text-purple-700' => $article->category === 'tecnica',
                            'bg-orange-100 text-orange-700' => $article->category === 'politicas',
                        ]); ?>">
                            <?php echo e($article->category_name); ?>

                        </span>
                        
                        <div class="flex items-center space-x-4">
                            <a href="<?php echo e(route('admin.knowledge-base.edit', $article->id)); ?>" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo e($article->title); ?></h1>
                    
                    <?php if($article->summary): ?>
                        <p class="text-lg text-gray-600 mb-6"><?php echo e($article->summary); ?></p>
                    <?php endif; ?>

                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <?php echo e($article->creator->name); ?>

                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php echo e($article->created_at->format('d M Y')); ?>

                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <?php echo e($article->views); ?> vistas
                        </div>
                    </div>
                </div>

                
                <div class="p-8">
                    <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-a:text-yellow-600 prose-code:text-yellow-600 prose-pre:bg-gray-50">
                        <?php echo nl2br(e($article->content)); ?>

                    </div>
                </div>

                
                <?php if($article->tags): ?>
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Etiquetas</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $article->tags_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="px-3 py-1 text-sm bg-white border border-gray-200 text-gray-700 rounded-full">
                                    #<?php echo e(trim($tag)); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="px-8 py-6 bg-yellow-50 border-t border-yellow-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ¿Te resultó útil este artículo?
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                👍 Sí
                            </button>
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                👎 No
                            </button>
                        </div>
                    </div>
                </div>
            </article>
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
<?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/admin/knowledge-base/show.blade.php ENDPATH**/ ?>