<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Editar Usuario</h1>
                <p class="mt-2 text-gray-600">Modifica la información de: {{ $user->name }}</p>
            </div>

            <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('administrador.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Nombre -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre *
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Correo Electrónico *
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña <span class="text-sm text-gray-500">(dejar en blanco para mantener la actual)</span>
                                </label>
                                <input type="password" name="password" id="password"
                                    placeholder="Nueva contraseña (opcional)"
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rol -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                    Rol *
                                </label>
                                <select name="role" id="role" required
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0 @error('role') border-red-500 @enderror">
                                    <option value="usuario" {{ old('role', $user->role) === 'usuario' ? 'selected' : '' }}>Usuario</option>
                                    <option value="tecnico" {{ old('role', $user->role) === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                    <option value="administrador" {{ old('role', $user->role) === 'administrador' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Departamento -->
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                                    Departamento
                                </label>
                                <input type="text" name="department" id="department" value="{{ old('department', $user->department) }}"
                                    placeholder="Ej: IT, Ventas, Soporte, etc."
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0 @error('department') border-red-500 @enderror">
                                @error('department')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Estado -->
                            @if(auth()->id() !== $user->id)
                                <div>
                                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                                        Estado
                                    </label>
                                    <select name="is_active" id="is_active" 
                                        class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-0">
                                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            @endif
                        </div>

                        <!-- Botones -->
                        <div class="mt-8 flex items-center justify-end gap-3">
                            <a href="{{ route('administrador.users.index') }}"
                                class="px-5 py-2.5 bg-white border-2 border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>