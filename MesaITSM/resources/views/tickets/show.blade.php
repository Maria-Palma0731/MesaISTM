<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Ticket #{{ $ticket->folio }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Card principal del ticket -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4 text-gray-900">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium">
                            {{ $ticket->title }}
                        </h3>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($ticket->status)
                                    @case('nuevo') bg-blue-100 text-blue-800 @break
                                    @case('asignado') bg-purple-100 text-purple-800 @break
                                    @case('en_proceso') bg-yellow-100 text-yellow-800 @break
                                    @case('pendiente_usuario') bg-orange-100 text-orange-800 @break
                                    @case('resuelto') bg-green-100 text-green-800 @break
                                    @case('cerrado') bg-gray-100 text-gray-800 @break
                                @endswitch">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($ticket->priority)
                                    @case('baja') bg-green-100 text-green-800 @break
                                    @case('media') bg-yellow-100 text-yellow-800 @break
                                    @case('alta') bg-red-100 text-red-800 @break
                                @endswitch">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>

                    <!-- Detalles del ticket -->
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Categoría:</span>
                            {{ ucfirst($ticket->category) }}
                            @if($ticket->subcategory)
                                - {{ ucfirst($ticket->subcategory) }}
                            @endif
                        </div>
                        <div>
                            <span class="font-medium">Creado por:</span>
                            {{ $ticket->user->name }}
                        </div>
                        <div>
                            <span class="font-medium">Creado el:</span>
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </div>
                        @if($ticket->assignedTo)
                            <div>
                                <span class="font-medium">Asignado a:</span>
                                {{ $ticket->assignedTo->name }}
                            </div>
                        @endif
                    </div>

                    <!-- Descripción -->
                    <div class="pt-4 border-t">
                        <h4 class="mb-2 font-medium">Descripción</h4>
                        <div class="max-w-none prose">
                            {!! nl2br(e($ticket->description)) !!}
                        </div>
                    </div>

                    <!-- Archivos adjuntos -->
                    @if($ticket->attachments->count() > 0)
                        <div class="pt-4 border-t">
                            <h4 class="mb-2 font-medium">Archivos Adjuntos</h4>
                            <ul class="space-y-2">
                                @foreach($ticket->attachments as $attachment)
                                    <li>
                                        <a href="{{ route('tickets.attachment.download', $attachment) }}" 
                                            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                            </svg>
                                            {{ $attachment->filename }}
                                            <span class="ml-1 text-gray-500">
                                                ({{ number_format($attachment->file_size / 1024, 1) }} KB)
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario de calificación -->
                    @if($ticket->status === 'resuelto' && $ticket->user_id === auth()->id())
                        <div class="pt-4 border-t">
                            <form action="{{ route('tickets.close', $ticket) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <h4 class="mb-2 font-medium">Calificar y cerrar ticket</h4>
                                
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        ¿Qué tan satisfecho estás con la atención recibida?
                                    </label>
                                    <div class="flex gap-4">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label class="flex items-center">
                                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                                                <div class="w-8 h-8 text-center text-gray-500 border rounded-full cursor-pointer peer-checked:bg-yellow-400 peer-checked:border-yellow-400 peer-checked:text-white hover:bg-yellow-50">
                                                    {{ $i }}
                                                </div>
                                            </label>
                                        @endfor
                                    </div>
                                    @error('rating')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="rating_comment" class="block text-sm font-medium text-gray-700">
                                        Comentarios adicionales (opcional)
                                    </label>
                                    <textarea name="rating_comment" id="rating_comment" rows="3"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                    @error('rating_comment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Calificar y cerrar ticket
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Historial del ticket -->
            @if($ticket->history->isNotEmpty())
                <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="mb-4 text-lg font-medium">Historial del ticket</h4>

                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($ticket->history as $history)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="flex items-center justify-center w-8 h-8 rounded-full {{ $history->getIconClass() }}">
                                                        {!! $history->getIcon() !!}
                                                    </span>
                                                </div>
                                                <div class="flex justify-between flex-1 min-w-0 space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            {!! $history->getDescription() !!}
                                                        </p>
                                                    </div>
                                                    <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                                        <time datetime="{{ $history->created_at->format('Y-m-d H:i:s') }}">
                                                            {{ $history->created_at->format('d/m/Y H:i') }}
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>