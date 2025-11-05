<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Header con acciones --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('tecnico.tickets.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                        ← Volver a mis tickets
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $ticket->folio ?? 'Sin folio' }}</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Columna principal (2/3) --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Información del ticket --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ $ticket->title }}
                            </h2>
                            <div class="flex gap-2">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded
                                    @if($ticket->priority === 'critica') bg-red-100 text-red-700
                                    @elseif($ticket->priority === 'alta') bg-orange-100 text-orange-700
                                    @elseif($ticket->priority === 'media') bg-yellow-100 text-yellow-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                                <span class="inline-flex px-3 py-1 rounded-md bg-blue-100 text-blue-700 text-xs font-medium">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm text-gray-600 mb-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium">Usuario:</span>
                                <span>{{ $ticket->user->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span class="font-medium">Categoría:</span>
                                <span>{{ ucfirst($ticket->category) }}
                                    @if($ticket->subcategory)
                                        - {{ ucfirst($ticket->subcategory) }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">Creado:</span>
                                <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($ticket->timeLogs->isNotEmpty())
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <span class="font-medium">Tiempo invertido:</span>
                                <span>{{ $ticket->timeLogs->sum('minutes') }} minutos</span>
                            </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-2">Descripción</h3>
                            <div class="text-sm text-gray-600 whitespace-pre-wrap">{{ $ticket->description }}</div>
                        </div>
                    </div>

                    {{-- Panel de Acciones (solo si el ticket está activo) --}}
                    @if(!in_array($ticket->status, ['cerrado', 'resuelto', 'cancelado']))
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                        
                        <form action="{{ route('tecnico.tickets.update', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                {{-- Estado --}}
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cambiar Estado
                                    </label>
                                    <select name="status" id="status" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Seleccionar estado</option>
                                        @if($ticket->status === 'nuevo')
                                            <option value="asignado">Asignado</option>
                                            <option value="en_proceso">En Proceso</option>
                                        @endif
                                        @if($ticket->status === 'asignado')
                                            <option value="en_proceso">En Proceso</option>
                                        @endif
                                        @if(in_array($ticket->status, ['asignado', 'en_proceso']))
                                            <option value="pendiente_usuario">Pendiente de Usuario</option>
                                            <option value="resuelto">Resuelto</option>
                                        @endif
                                        @if($ticket->status === 'pendiente_usuario')
                                            <option value="en_proceso">En Proceso</option>
                                            <option value="resuelto">Resuelto</option>
                                        @endif
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Prioridad --}}
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cambiar Prioridad
                                    </label>
                                    <select name="priority" id="priority"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">No cambiar</option>
                                        <option value="baja" {{ $ticket->priority === 'baja' ? 'selected' : '' }}>Baja</option>
                                        <option value="media" {{ $ticket->priority === 'media' ? 'selected' : '' }}>Media</option>
                                        <option value="alta" {{ $ticket->priority === 'alta' ? 'selected' : '' }}>Alta</option>
                                        <option value="critica" {{ $ticket->priority === 'critica' ? 'selected' : '' }}>Crítica</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                {{-- Tiempo invertido --}}
                                <div>
                                    <label for="time_minutes" class="block text-sm font-medium text-gray-700 mb-1">
                                        Tiempo Invertido (minutos)
                                    </label>
                                    <input type="number" name="time_minutes" id="time_minutes" 
                                        min="1" max="480" placeholder="15"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('time_minutes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Descripción del tiempo --}}
                                <div>
                                    <label for="time_description" class="block text-sm font-medium text-gray-700 mb-1">
                                        Descripción del Trabajo
                                    </label>
                                    <input type="text" name="time_description" id="time_description" 
                                        placeholder="Ej: Análisis del problema"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('time_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Comentario --}}
                            <div>
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                                    Agregar Comentario
                                </label>
                                <textarea name="comment" id="comment" rows="3" 
                                    placeholder="Describe las acciones realizadas o actualizaciones..."
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Comentario interno --}}
                            <div class="flex items-center">
                                <input type="checkbox" name="is_internal" id="is_internal" value="1"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="is_internal" class="ml-2 block text-sm text-gray-700">
                                    Marcar como comentario interno (no visible para el usuario)
                                </label>
                            </div>

                            {{-- Botones --}}
                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                                <button type="button" onclick="document.getElementById('modalEscalar').classList.remove('hidden')"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Escalar Ticket
                                </button>
                                <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                    Actualizar Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    {{-- Archivos adjuntos --}}
                    @if($ticket->attachments->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Archivos adjuntos</h3>
                        <ul class="divide-y divide-gray-200">
                            @foreach($ticket->attachments as $attachment)
                                <li class="flex items-center justify-between py-3">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $attachment->filename }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ number_format($attachment->file_size / 1024, 1) }} KB
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('tickets.attachment.download', $attachment) }}" 
                                        class="ml-4 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        Descargar
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Comentarios --}}
                    @if($ticket->comments->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Comentarios</h3>
                        <div class="space-y-4">
                            @foreach($ticket->comments as $comment)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-500 text-white font-semibold text-sm">
                                            {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                            @if($comment->is_internal)
                                                <span class="inline-flex px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded">
                                                    Interno
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-700 mt-1">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Columna lateral (1/3) --}}
                <div class="space-y-6">
                    {{-- Historial --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Historial</h3>
                        <div class="space-y-4">
                            @forelse($ticket->history as $history)
                                <div class="relative pb-4">
                                    @if(!$loop->last)
                                        <span class="absolute top-5 left-2.5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex items-start gap-3">
                                        <div>
                                            <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-100 ring-4 ring-white">
                                                <div class="h-2 w-2 rounded-full bg-gray-400"></div>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm text-gray-900">{{ $history->description }}</p>
                                                <p class="mt-0.5 text-xs text-gray-500">
                                                    {{ $history->user->name }} - {{ $history->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No hay historial disponible</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Registro de tiempo --}}
                    @if($ticket->timeLogs->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Registro de tiempo</h3>
                        <div class="space-y-3">
                            @foreach($ticket->timeLogs as $log)
                                <div class="flex justify-between items-start py-2 border-b border-gray-100 last:border-0">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $log->description }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $log->user->name }} - {{ $log->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <span class="text-sm font-semibold text-indigo-600">{{ $log->minutes }} min</span>
                                </div>
                            @endforeach
                            <div class="pt-3 border-t-2 border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-900">Total:</span>
                                    <span class="text-base font-bold text-indigo-600">
                                        {{ $ticket->timeLogs->sum('minutes') }} min
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Escalar Ticket --}}
    <div id="modalEscalar" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-2xl bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Escalar Ticket</h3>
                    <button onclick="document.getElementById('modalEscalar').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('tecnico.tickets.escalate', $ticket) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">
                            Asignar a Técnico <span class="text-red-500">*</span>
                        </label>
                        <select name="assigned_to" id="assigned_to" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Seleccionar técnico</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="escalate_comment" class="block text-sm font-medium text-gray-700 mb-1">
                            Motivo del Escalamiento <span class="text-red-500">*</span>
                        </label>
                        <textarea name="comment" id="escalate_comment" rows="3" required
                            placeholder="Explica por qué se escala este ticket..."
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        <p class="mt-1 text-xs text-gray-500">Este comentario será interno (no visible para el usuario)</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" 
                            onclick="document.getElementById('modalEscalar').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700">
                            Escalar Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Cerrar modal al hacer click fuera
        document.getElementById('modalEscalar')?.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
