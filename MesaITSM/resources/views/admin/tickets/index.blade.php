<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Administración de Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Filtros --}}
            <div class="p-6 mb-6 bg-white rounded-lg shadow-sm">
                <form action="{{ route('admin.tickets.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {{-- Técnico Asignado --}}
                        <div>
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700">
                                Técnico Asignado
                            </label>
                            <select name="assigned_to" id="assigned_to" class="block w-full mt-1 rounded-md border-gray-300">
                                <option value="">Todos los técnicos</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ request('assigned_to') == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Departamento --}}
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700">
                                Departamento
                            </label>
                            <select name="department" id="department" class="block w-full mt-1 rounded-md border-gray-300">
                                <option value="">Todos los departamentos</option>
                                @foreach($departamentos as $depto)
                                    <option value="{{ $depto }}" {{ request('department') == $depto ? 'selected' : '' }}>
                                        {{ $depto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="status" id="status" class="block w-full mt-1 rounded-md border-gray-300">
                                <option value="">Todos los estados</option>
                                @foreach(['nuevo', 'asignado', 'proceso', 'espera', 'resuelto', 'cerrado', 'rechazado'] as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Prioridad --}}
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">
                                Prioridad
                            </label>
                            <select name="priority" id="priority" class="block w-full mt-1 rounded-md border-gray-300">
                                <option value="">Todas las prioridades</option>
                                @foreach(['baja', 'media', 'alta', 'critica'] as $priority)
                                    <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">
                                Categoría
                            </label>
                            <select name="category" id="category" class="block w-full mt-1 rounded-md border-gray-300">
                                <option value="">Todas las categorías</option>
                                {{-- Aquí deberías listar las categorías de tu sistema --}}
                            </select>
                        </div>

                        {{-- Búsqueda --}}
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">
                                Buscar
                            </label>
                            <input type="text" name="search" id="search"
                                value="{{ request('search') }}"
                                placeholder="Folio, título o usuario"
                                class="block w-full mt-1 rounded-md border-gray-300">
                        </div>

                        {{-- Rango de Fechas --}}
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700">
                                Desde
                            </label>
                            <input type="date" name="date_from" id="date_from"
                                value="{{ request('date_from') }}"
                                class="block w-full mt-1 rounded-md border-gray-300">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700">
                                Hasta
                            </label>
                            <input type="date" name="date_to" id="date_to"
                                value="{{ request('date_to') }}"
                                class="block w-full mt-1 rounded-md border-gray-300">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.tickets.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            Limpiar
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabla de Tickets --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            Lista de Tickets
                        </h3>
                        <div class="flex gap-3">
                            <a href="{{ route('tickets.create') }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                + Crear Ticket
                            </a>
                            <a href="{{ route('admin.tickets.mass-assign') }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                Asignación Masiva
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Folio
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Usuario
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Título
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Prioridad
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Técnico
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Creado
                                    </th>
                                    <th class="relative px-6 py-3">
                                        <span class="sr-only">Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($tickets as $ticket)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                            {{ $ticket->folio }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                            <div>{{ $ticket->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $ticket->user->department }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $ticket->title }}
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                {{ $ticket->status === 'nuevo' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $ticket->status === 'asignado' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $ticket->status === 'proceso' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                {{ $ticket->status === 'espera' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $ticket->status === 'resuelto' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $ticket->status === 'cerrado' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $ticket->status === 'rechazado' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            <form action="{{ route('admin.tickets.priority', $ticket) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="priority" onchange="this.form.submit()"
                                                    class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500
                                                        {{ $ticket->priority === 'baja' ? 'text-gray-700' : '' }}
                                                        {{ $ticket->priority === 'media' ? 'text-yellow-600' : '' }}
                                                        {{ $ticket->priority === 'alta' ? 'text-orange-600' : '' }}
                                                        {{ $ticket->priority === 'critica' ? 'text-red-600 font-medium' : '' }}">
                                                    <option value="baja" {{ $ticket->priority === 'baja' ? 'selected' : '' }}>
                                                        Baja
                                                    </option>
                                                    <option value="media" {{ $ticket->priority === 'media' ? 'selected' : '' }}>
                                                        Media
                                                    </option>
                                                    <option value="alta" {{ $ticket->priority === 'alta' ? 'selected' : '' }}>
                                                        Alta
                                                    </option>
                                                    <option value="critica" {{ $ticket->priority === 'critica' ? 'selected' : '' }}>
                                                        Crítica
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            <form action="{{ route('admin.tickets.assign', $ticket) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="assigned_to" onchange="this.form.submit()"
                                                    class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option value="">Sin asignar</option>
                                                    @foreach($tecnicos as $tecnico)
                                                        <option value="{{ $tecnico->id }}"
                                                            {{ $ticket->assigned_to === $tecnico->id ? 'selected' : '' }}>
                                                            {{ $tecnico->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('tickets.show', $ticket) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    Ver
                                                </a>

                                                @if($ticket->status === 'resuelto')
                                                    <form action="{{ route('admin.tickets.close', $ticket) }}" method="POST"
                                                        onsubmit="return confirm('¿Estás seguro de cerrar este ticket?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-gray-600 hover:text-gray-900">
                                                            Cerrar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-sm text-center text-gray-500">
                                            No se encontraron tickets con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>