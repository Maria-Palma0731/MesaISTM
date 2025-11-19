<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Ticket #{{ $ticket->folio }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Acciones rápidas -->
            <div class="mb-6 sm:flex sm:items-center sm:justify-between">
                <div class="flex space-x-3">
                    <a href="{{ route('tecnico.tickets.asignados') }}" class="text-indigo-600 hover:text-indigo-900">
                        ← Volver a mis tickets
                    </a>
                </div>
                <div class="mt-3 flex sm:mt-0 sm:ml-4">
                    <button type="button" 
                        onclick="document.getElementById('modalEscalar').classList.remove('hidden')"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Escalar ticket
                    </button>
                    @if($ticket->status === 'en_proceso')
                        <button type="button"
                            onclick="document.getElementById('modalResolver').classList.remove('hidden')"
                            class="ml-3 inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700">
                            Resolver ticket
                        </button>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Columna izquierda -->
                <div class="space-y-6">
                    <!-- Card de información -->
                    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium">
                                    {{ $ticket->title }}
                                </h3>
                                <div class="flex space-x-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $ticket->getPriorityColorClass() }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $ticket->getStatusColorClass() }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 space-y-3 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Usuario:</span>
                                    {{ $ticket->user->name }}
                                </div>
                                <div>
                                    <span class="font-medium">Categoría:</span>
                                    {{ ucfirst($ticket->category) }}
                                    @if($ticket->subcategory)
                                        - {{ ucfirst($ticket->subcategory) }}
                                    @endif
                                </div>
                                <div>
                                    <span class="font-medium">Creado:</span>
                                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium">Tiempo invertido:</span>
                                    {{ $ticket->getTotalTimeLogged() }} minutos
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-900">Descripción</h4>
                                <div class="mt-2 whitespace-pre-wrap text-sm text-gray-600">
                                    {{ $ticket->description }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Archivos adjuntos -->
                    @if($ticket->attachments->isNotEmpty())
                        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium">Archivos adjuntos</h3>
                                <ul class="mt-4 divide-y divide-gray-200">
                                    @foreach($ticket->attachments as $attachment)
                                        <li class="flex items-center justify-between py-3">
                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 truncate text-sm">
                                                    {{ $attachment->filename }}
                                                    <span class="text-gray-500">
                                                        ({{ number_format($attachment->file_size / 1024, 1) }} KB)
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a href="{{ route('tickets.attachment.download', $attachment) }}" 
                                                    class="font-medium text-indigo-600 hover:text-indigo-500">
                                                    Descargar
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Formulario de actualización -->
                    @if(in_array($ticket->status, ['asignado', 'en_proceso', 'pendiente_usuario']))
                        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="mb-4 text-lg font-medium">Actualizar estado</h3>
                                
                                <form action="{{ route('tecnico.tickets.update-status', $ticket) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <!-- Estado -->
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">
                                                Estado
                                            </label>
                                            <select name="status" id="status" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Seleccionar estado</option>
                                                @if($ticket->status === 'asignado')
                                                    <option value="en_proceso">En proceso</option>
                                                @endif
                                                @if($ticket->status === 'en_proceso')
                                                    <option value="pendiente_usuario">Pendiente de usuario</option>
                                                    <option value="resuelto">Resuelto</option>
                                                @endif
                                                @if($ticket->status === 'pendiente_usuario')
                                                    <option value="en_proceso">En proceso</option>
                                                @endif
                                            </select>
                                            @error('status')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Prioridad -->
                                        <div>
                                            <label for="priority" class="block text-sm font-medium text-gray-700">
                                                Prioridad
                                            </label>
                                            <select name="priority" id="priority"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">No cambiar</option>
                                                <option value="baja" {{ $ticket->priority === 'baja' ? 'selected' : '' }}>Baja</option>
                                                <option value="media" {{ $ticket->priority === 'media' ? 'selected' : '' }}>Media</option>
                                                <option value="alta" {{ $ticket->priority === 'alta' ? 'selected' : '' }}>Alta</option>
                                                <option value="critica" {{ $ticket->priority === 'critica' ? 'selected' : '' }}>Crítica</option>
                                            </select>
                                            @error('priority')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Tiempo -->
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label for="time_minutes" class="block text-sm font-medium text-gray-700">
                                                Tiempo invertido (minutos)
                                            </label>
                                            <input type="number" name="time_minutes" id="time_minutes" required
                                                min="1" max="480"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('time_minutes')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="time_description" class="block text-sm font-medium text-gray-700">
                                                Descripción del tiempo
                                            </label>
                                            <input type="text" name="time_description" id="time_description" required
                                                placeholder="Ej: Análisis del problema"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('time_description')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Comentario -->
                                    <div>
                                        <label for="comment" class="block text-sm font-medium text-gray-700">
                                            Comentario
                                        </label>
                                        <div class="mt-1">
                                            <textarea name="comment" id="comment" rows="3" required
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                        </div>
                                        @error('comment')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Comentario interno -->
                                    <div class="relative flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input type="checkbox" name="is_internal" id="is_internal"
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_internal" class="font-medium text-gray-700">
                                                Comentario interno
                                            </label>
                                            <p class="text-gray-500">Solo visible para técnicos y administradores</p>
                                        </div>
                                    </div>

                                    <div class="pt-3">
                                        <button type="submit" 
                                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Actualizar ticket
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Columna derecha -->
                <div class="space-y-6">
                    <!-- Comentarios -->
                    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="mb-4 text-lg font-medium">Comentarios</h3>
                            <x-ticket-comments :comments="$ticket->comments" />

                            <!-- Formulario de comentario -->
                            <div class="mt-6 border-t pt-6">
                                <form action="{{ route('tecnico.tickets.comment', $ticket) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="space-y-4">
                                        <div>
                                            <label for="new_comment" class="block text-sm font-medium text-gray-700">
                                                Agregar comentario
                                            </label>
                                            <div class="mt-1">
                                                <textarea name="comment" id="new_comment" rows="3" required
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                            </div>
                                            @error('comment')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="relative flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input type="checkbox" name="is_internal" id="new_is_internal"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="new_is_internal" class="font-medium text-gray-700">
                                                    Comentario interno
                                                </label>
                                                <p class="text-gray-500">Solo visible para técnicos y administradores</p>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="attachments" class="block text-sm font-medium text-gray-700">
                                                Archivos adjuntos
                                            </label>
                                            <input type="file" name="attachments[]" id="attachments" multiple
                                                class="mt-1 block w-full text-sm text-gray-500
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-md file:border-0
                                                    file:text-sm file:font-medium
                                                    file:bg-indigo-50 file:text-indigo-700
                                                    hover:file:bg-indigo-100">
                                            <p class="mt-1 text-xs text-gray-500">
                                                Máximo 10MB por archivo. Formatos permitidos: jpg, png, pdf, doc, docx, xls, xlsx
                                            </p>
                                            @error('attachments.*')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <button type="submit" 
                                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                Agregar comentario
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Escalar -->
    <div id="modalEscalar" class="fixed inset-0 z-10 hidden overflow-y-auto">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6 sm:align-middle">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                    <button type="button" onclick="document.getElementById('modalEscalar').classList.add('hidden')"
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Escalar ticket
                        </h3>

                        <form action="{{ route('tecnico.tickets.escalate', $ticket) }}" method="POST" class="mt-4">
                            @csrf

                            <div class="space-y-4">
                                <div>
                                    <label for="assigned_to" class="block text-sm font-medium text-gray-700">
                                        Asignar a
                                    </label>
                                    <select name="assigned_to" id="assigned_to" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Seleccionar técnico</option>
                                        @foreach($tecnicos as $tecnico)
                                            <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="escalate_comment" class="block text-sm font-medium text-gray-700">
                                        Motivo de escalación
                                    </label>
                                    <div class="mt-1">
                                        <textarea name="comment" id="escalate_comment" rows="3" required
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    @error('comment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                    Escalar ticket
                                </button>
                                <button type="button"
                                    onclick="document.getElementById('modalEscalar').classList.add('hidden')"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Resolver -->
    <div id="modalResolver" class="fixed inset-0 z-10 hidden overflow-y-auto">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6 sm:align-middle">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                    <button type="button" onclick="document.getElementById('modalResolver').classList.add('hidden')"
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Resolver ticket
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Por favor describe la solución implementada. Este comentario será visible para el usuario.
                        </p>

                        <form action="{{ route('tecnico.tickets.resolve', $ticket) }}" method="POST" class="mt-4">
                            @csrf

                            <div>
                                <label for="resolve_comment" class="block text-sm font-medium text-gray-700">
                                    Solución implementada
                                </label>
                                <div class="mt-1">
                                    <textarea name="comment" id="resolve_comment" rows="4" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                    Resolver ticket
                                </button>
                                <button type="button"
                                    onclick="document.getElementById('modalResolver').classList.add('hidden')"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>