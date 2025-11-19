<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tickets Disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Barra superior -->
            <div class="flex items-center justify-end mb-4">
                <a href="{{ route('tecnico.tickets.asignados') }}" class="text-indigo-600 hover:text-indigo-900">
                    ← Volver a mis tickets asignados
                </a>
            </div>

            <!-- Lista de tickets -->
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse ($tickets as $ticket)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-medium text-indigo-600 truncate">
                                            {{ $ticket->title }}
                                        </p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($ticket->priority)
                                                @case('baja') bg-green-100 text-green-800 @break
                                                @case('media') bg-yellow-100 text-yellow-800 @break
                                                @case('alta') bg-red-100 text-red-800 @break
                                            @endswitch">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </div>
                                    <div class="flex flex-shrink-0 ml-2">
                                        <form action="{{ route('tecnico.tickets.tomar', $ticket) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                class="px-3 py-1 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                                Tomar ticket
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex gap-6">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <span class="truncate">Folio: {{ $ticket->folio }}</span>
                                        </p>
                                        <p class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                            De: {{ $ticket->user->name }}
                                        </p>
                                    </div>
                                    <div class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-1">
                                            Creado el {{ $ticket->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-6 text-center text-gray-500 sm:px-6">
                            No hay tickets disponibles
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-app-layout>