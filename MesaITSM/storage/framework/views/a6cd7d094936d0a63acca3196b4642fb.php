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
            
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="<?php echo e(route('admin.knowledge-base.index')); ?>" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Editar Artículo</h1>
                            <p class="mt-2 text-gray-600">Modifica el artículo de la base de conocimiento</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <form action="<?php echo e(route('admin.knowledge-base.update', $article->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="space-y-6">
                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Título del Artículo *
                            </label>
                            <input type="text" name="title" id="title" required
                                value="<?php echo e(old('title', $article->title)); ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Ej: Cómo resetear tu contraseña">
                        </div>

                        
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Categoría *
                            </label>
                            <select name="category" id="category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                <option value="">Seleccionar categoría</option>
                                <option value="guias" <?php echo e(old('category', $article->category) == 'guias' ? 'selected' : ''); ?>>
                                    Guías y Tutoriales
                                </option>
                                <option value="faq" <?php echo e(old('category', $article->category) == 'faq' ? 'selected' : ''); ?>>
                                    Preguntas Frecuentes
                                </option>
                                <option value="tecnica" <?php echo e(old('category', $article->category) == 'tecnica' ? 'selected' : ''); ?>>
                                    Documentación Técnica
                                </option>
                                <option value="politicas" <?php echo e(old('category', $article->category) == 'politicas' ? 'selected' : ''); ?>>
                                    Políticas y Procedimientos
                                </option>
                            </select>
                        </div>

                        
                        <div>
                            <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                                Resumen
                            </label>
                            <textarea name="summary" id="summary" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Breve descripción del artículo"><?php echo e(old('summary', $article->summary)); ?></textarea>
                        </div>

                        
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Contenido *
                            </label>
                            <textarea name="content" id="content" rows="16" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 font-mono text-sm"
                                placeholder="Escribe el contenido del artículo aquí..."><?php echo e(old('content', $article->content)); ?></textarea>
                            <p class="mt-2 text-sm text-gray-500">Puedes usar Markdown para dar formato al texto</p>
                        </div>

                        
                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                                Etiquetas
                            </label>
                            <input type="text" name="tags" id="tags"
                                value="<?php echo e(old('tags', $article->tags)); ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="contraseña, login, seguridad (separadas por comas)">
                        </div>

                        
                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" 
                                <?php echo e(old('is_published', $article->is_published) ? 'checked' : ''); ?>

                                class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 block text-sm text-gray-700">
                                Artículo publicado
                            </label>
                        </div>

                        
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Información del artículo</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Creado por:</span>
                                    <span class="font-medium text-gray-900 ml-2"><?php echo e($article->creator->name); ?></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Fecha de creación:</span>
                                    <span class="font-medium text-gray-900 ml-2"><?php echo e($article->created_at->format('d/m/Y H:i')); ?></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Vistas totales:</span>
                                    <span class="font-medium text-gray-900 ml-2"><?php echo e($article->views); ?></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Última actualización:</span>
                                    <span class="font-medium text-gray-900 ml-2"><?php echo e($article->updated_at->diffForHumans()); ?></span>
                                </div>
                            </div>
                        </div>

                        
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                                
                                <button type="button" 
                                    onclick="if(confirm('¿Estás seguro de que deseas eliminar este artículo? Esta acción no se puede deshacer.')) { document.getElementById('delete-form').submit(); }"
                                    style="padding: 10px 16px; font-size: 14px; font-weight: 500; color: #b91c1c; background-color: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px;"
                                    onmouseover="this.style.backgroundColor='#fecaca'" 
                                    onmouseout="this.style.backgroundColor='#fee2e2'">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Eliminar Artículo
                                </button>

                                
                                <a href="<?php echo e(route('admin.knowledge-base.show', $article->id)); ?>"
                                    style="padding: 10px 16px; font-size: 14px; font-weight: 500; color: #374151; background-color: white; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;"
                                    onmouseover="this.style.backgroundColor='#f9fafb'" 
                                    onmouseout="this.style.backgroundColor='white'">
                                    Cancelar
                                </a>

                                
                                <button type="submit"
                                    style="padding: 10px 16px; font-size: 14px; font-weight: 600; color: white; background-color: #ca8a04; border: none; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                                    onmouseover="this.style.backgroundColor='#a16207'" 
                                    onmouseout="this.style.backgroundColor='#ca8a04'">
                                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                
                <form id="delete-form" action="<?php echo e(route('admin.knowledge-base.destroy', $article->id)); ?>" method="POST" class="hidden">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                </form>
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/admin/knowledge-base/edit.blade.php ENDPATH**/ ?>