<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado con botón --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Usuarios</h1>
                    <p class="mt-2 text-gray-600">Administra usuarios y permisos del sistema</p>
                </div>
                <a href="{{ route('administrador.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Usuario
                </a>
            </div>

            {{-- Tarjetas de estadísticas --}}
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Total Usuarios</div>
                    <div class="text-4xl font-bold text-gray-900">{{ $users->total() }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Administradores</div>
                    <div class="text-4xl font-bold text-purple-600">{{ \App\Models\User::where('role', 'administrador')->count() }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Técnicos</div>
                    <div class="text-4xl font-bold text-blue-600">{{ \App\Models\User::where('role', 'tecnico')->count() }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="text-sm font-medium text-gray-600 mb-2">Usuarios Finales</div>
                    <div class="text-4xl font-bold text-green-600">{{ \App\Models\User::where('role', 'usuario')->count() }}</div>
                </div>
            </div>

            <!-- Filtros compactos -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
                <form action="{{ route('administrador.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div>
                        <label for="role" class="block text-xs font-medium text-gray-700 mb-1">Rol</label>
                        <select name="role" id="role" class="block w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-0">
                            <option value="">Todos</option>
                            <option value="usuario" {{ request('role') === 'usuario' ? 'selected' : '' }}>Usuario</option>
                            <option value="tecnico" {{ request('role') === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                            <option value="administrador" {{ request('role') === 'administrador' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>

                    <div>
                        <label for="is_active" class="block text-xs font-medium text-gray-700 mb-1">Estado</label>
                        <select name="is_active" id="is_active" class="block w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-0">
                            <option value="">Todos</option>
                            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div>
                        <label for="department" class="block text-xs font-medium text-gray-700 mb-1">Departamento</label>
                        <select name="department" id="department" class="block w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-0">
                            <option value="">Todos</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Filtrar
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('administrador.users.index') }}" class="w-full px-4 py-2 text-sm text-center text-gray-700 bg-white border-2 border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Mensajes de éxito -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Mensajes de error -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Tabla de usuarios -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Lista de Usuarios</h2>
                    
                    <div class="space-y-4">
                        @foreach($users as $user)
                            <div class="flex items-center justify-between p-4 rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-colors">
                                {{-- Icono y información del usuario --}}
                                <div class="flex items-center space-x-4 flex-1">
                                    {{-- Icono según rol --}}
                                    <div class="flex-shrink-0">
                                        @if($user->role === 'administrador')
                                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            </div>
                                        @elseif($user->role === 'tecnico')
                                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Información del usuario --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h3 class="text-base font-semibold text-gray-900">{{ $user->name }}</h3>
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-md
                                                @if($user->role === 'administrador') bg-red-100 text-red-700
                                                @elseif($user->role === 'tecnico') bg-cyan-100 text-cyan-700
                                                @else bg-blue-100 text-blue-700
                                                @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm text-gray-500">
                                            <span>{{ $user->email }}</span>
                                            @if($user->department)
                                                <span>•</span>
                                                <span>{{ $user->department }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Acciones --}}
                                <div class="flex items-center gap-3 ml-4">
                                    {{-- Estado --}}
                                    <span class="px-3 py-1 text-sm font-medium rounded-md {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>

                                    {{-- Botón Editar --}}
                                    <a href="{{ route('administrador.users.edit', $user) }}" 
                                       class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Editar usuario">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Botón Eliminar --}}
                                    @if(auth()->id() !== $user->id)
                                        <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" 
                                                class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Eliminar usuario">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>

                                        <form id="delete-form-{{ $user->id }}" action="{{ route('administrador.users.destroy', $user) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(userId, userName) {
            if (confirm('¿Estás seguro de que deseas eliminar al usuario "' + userName + '"?\n\nEsta acción no se puede deshacer.')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
    @endpush
</x-app-layout>