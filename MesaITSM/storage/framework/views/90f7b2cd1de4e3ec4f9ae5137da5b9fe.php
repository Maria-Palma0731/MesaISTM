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
                <div class="flex items-center space-x-4 mb-4">
                    <a href="<?php echo e(route('admin.knowledge-base.index')); ?>" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Nuevo Artículo</h1>
                        <p class="mt-2 text-gray-600">Crea un nuevo artículo para la base de conocimiento</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <form action="<?php echo e(route('admin.knowledge-base.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="space-y-6">
                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Título del Artículo *
                            </label>
                            <input type="text" name="title" id="title" required
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
                                <option value="guias">Guías y Tutoriales</option>
                                <option value="faq">Preguntas Frecuentes</option>
                                <option value="tecnica">Documentación Técnica</option>
                                <option value="politicas">Políticas y Procedimientos</option>
                            </select>
                        </div>

                        
                        <div>
                            <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                                Resumen
                            </label>
                            <textarea name="summary" id="summary" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Breve descripción del artículo"></textarea>
                        </div>

                        
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Contenido *
                            </label>
                            <textarea name="content" id="content" rows="12" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 font-mono text-sm"
                                placeholder="Escribe el contenido del artículo aquí..."></textarea>
                            <p class="mt-2 text-sm text-gray-500">Puedes usar Markdown para dar formato al texto</p>
                        </div>

                        
                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                                Etiquetas
                            </label>
                            <input type="text" name="tags" id="tags"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="contraseña, login, seguridad (separadas por comas)">
                        </div>

                        
                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" checked
                                class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 block text-sm text-gray-700">
                                Publicar inmediatamente
                            </label>
                        </div>
                    </div>

                    
                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('admin.knowledge-base.index')); ?>"
                            style="padding: 10px 24px; font-size: 14px; font-weight: 500; color: #374151; background-color: white; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; display: inline-block;"
                            onmouseover="this.style.backgroundColor='#f9fafb'" 
                            onmouseout="this.style.backgroundColor='white'">
                            Cancelar
                        </a>
                        <button type="submit"
                            style="padding: 10px 24px; font-size: 14px; font-weight: 600; color: white; background-color: #ca8a04; border: none; border-radius: 8px; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#a16207'" 
                            onmouseout="this.style.backgroundColor='#ca8a04'">
                            Crear Artículo
                        </button>
                    </div>
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
<?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/admin/knowledge-base/create.blade.php ENDPATH**/ ?>