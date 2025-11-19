<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tickets Asignados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="p-4 mb-8 bg-white rounded-lg shadow">
                <form action="{{ route('tecnico.tickets.asignados') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="status" id="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="asignado" {{ request('status') == 'asignado' ? 'selected' : '' }}>Asignado</option>
                            <option value="en_proceso" {{ request('status') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="pendiente_usuario" {{ request('status') == 'pendiente_usuario' ? 'selected' : '' }}>Pendiente de Usuario</option>
                            <option value="resuelto" {{ request('status') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Prioridad</label>
                        <select name="priority" id="priority" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todas</option>
                            <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                            <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Media</option>
                            <option value="baja" {{ request('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700">Desde</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700">Hasta</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                            placeholder="Folio, título o usuario..."
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div class="flex items-end gap-2 md:col-span-5">
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Filtrar
                        </button>
                        <a href="{{ route('tecnico.tickets.asignados') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Limpiar
                        </a>
                        <a href="{{ route('tecnico.tickets.disponibles') }}" class="px-4 py-2 ml-auto text-white bg-green-600 rounded-md hover:bg-green-700">
                            Ver tickets disponibles
                        </a>
                    </div>
                </form>
            </div>

            <!-- Lista de tickets -->
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse ($tickets as $ticket)
                        <li>
                            <a href="{{ route('tecnico.tickets.atender', $ticket) }}" class="block hover:bg-gray-50">
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
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @switch($ticket->status)
                                                    @case('asignado') bg-purple-100 text-purple-800 @break
                                                    @case('en_proceso') bg-yellow-100 text-yellow-800 @break
                                                    @case('pendiente_usuario') bg-orange-100 text-orange-800 @break
                                                    @case('resuelto') bg-green-100 text-green-800 @break
                                                @endswitch">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
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
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-6 text-center text-gray-500 sm:px-6">
                            No hay tickets asignados
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