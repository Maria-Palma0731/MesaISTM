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
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Usuarios</h1>
                    <p class="mt-2 text-gray-600">Administra usuarios y permisos del sistema</p>
                </div>
                <a href="<?php echo e(route('administrador.users.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Usuario
                </a>
            </div>

            
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Total Usuarios</div>
                    <div class="text-4xl font-bold text-gray-900"><?php echo e($users->total()); ?></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Administradores</div>
                    <div class="text-4xl font-bold text-purple-600"><?php echo e(\App\Models\User::where('role', 'administrador')->count()); ?></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Técnicos</div>
                    <div class="text-4xl font-bold text-blue-600"><?php echo e(\App\Models\User::where('role', 'tecnico')->count()); ?></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Usuarios Finales</div>
                    <div class="text-4xl font-bold text-green-600"><?php echo e(\App\Models\User::where('role', 'usuario')->count()); ?></div>
                </div>
            </div>

            <!-- Filtros compactos -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
                <form action="<?php echo e(route('administrador.users.index')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div>
                        <label for="role" class="block text-xs font-medium text-gray-700 mb-1">Rol</label>
                        <select name="role" id="role" class="block w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-0">
                            <option value="">Todos</option>
                            <option value="usuario" <?php echo e(request('role') === 'usuario' ? 'selected' : ''); ?>>Usuario</option>
                            <option value="tecnico" <?php echo e(request('role') === 'tecnico' ? 'selected' : ''); ?>>Técnico</option>
                            <option value="administrador" <?php echo e(request('role') === 'administrador' ? 'selected' : ''); ?>>Administrador</option>
                        </select>
                    </div>

                    <div>
                        <label for="is_active" class="block text-xs font-medium text-gray-700 mb-1">Estado</label>
                        <select name="is_active" id="is_active" class="block w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-0">
                            <option value="">Todos</option>
                            <option value="1" <?php echo e(request('is_active') === '1' ? 'selected' : ''); ?>>Activo</option>
                            <option value="0" <?php echo e(request('is_active') === '0' ? 'selected' : ''); ?>>Inactivo</option>
                        </select>
                    </div>

                    <div>
                        <label for="department" class="block text-xs font-medium text-gray-700 mb-1">Departamento</label>
                        <select name="department" id="department" class="block w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-0">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dept); ?>" <?php echo e(request('department') === $dept ? 'selected' : ''); ?>>
                                    <?php echo e($dept); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Filtrar
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="<?php echo e(route('administrador.users.index')); ?>" class="w-full px-4 py-2 text-sm text-center text-gray-700 bg-white border-2 border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Mensajes de éxito -->
            <?php if(session('success')): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-medium"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>

            <!-- Mensajes de error -->
            <?php if(session('error')): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-medium"><?php echo e(session('error')); ?></p>
                </div>
            <?php endif; ?>

            <!-- Tabla de usuarios -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Lista de Usuarios</h2>
                    
                    <div class="space-y-4">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-colors">
                                
                                <div class="flex items-center space-x-4 flex-1">
                                    
                                    <div class="flex-shrink-0">
                                        <?php if($user->role === 'administrador'): ?>
                                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            </div>
                                        <?php elseif($user->role === 'tecnico'): ?>
                                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                        <?php else: ?>
                                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h3 class="text-base font-semibold text-gray-900"><?php echo e($user->name); ?></h3>
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-md
                                                <?php if($user->role === 'administrador'): ?> bg-red-100 text-red-700
                                                <?php elseif($user->role === 'tecnico'): ?> bg-cyan-100 text-cyan-700
                                                <?php else: ?> bg-blue-100 text-blue-700
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($user->role)); ?>

                                            </span>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm text-gray-500">
                                            <span><?php echo e($user->email); ?></span>
                                            <?php if($user->department): ?>
                                                <span>•</span>
                                                <span><?php echo e($user->department); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="flex items-center gap-3 ml-4">
                                    
                                    <span class="px-3 py-1 text-sm font-medium rounded-md <?php echo e($user->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'); ?>">
                                        <?php echo e($user->is_active ? 'Activo' : 'Inactivo'); ?>

                                    </span>

                                    
                                    <a href="<?php echo e(route('administrador.users.edit', $user)); ?>" 
                                       class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Editar usuario">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    
                                    <?php if(auth()->id() !== $user->id): ?>
                                        <button onclick="confirmDelete(<?php echo e($user->id); ?>, '<?php echo e($user->name); ?>')" 
                                                class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Eliminar usuario">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>

                                        <form id="delete-form-<?php echo e($user->id); ?>" action="<?php echo e(route('administrador.users.destroy', $user)); ?>" method="POST" class="hidden">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <?php echo e($users->links()); ?>

                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function confirmDelete(userId, userName) {
            if (confirm('¿Estás seguro de que deseas eliminar al usuario "' + userName + '"?\n\nEsta acción no se puede deshacer.')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
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
<?php endif; ?><?php /**PATH C:\laragon\www\MesaISTM\MesaITSM\resources\views/admin/users/index.blade.php ENDPATH**/ ?>