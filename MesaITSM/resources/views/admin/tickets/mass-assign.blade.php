<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Asignación Masiva de Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.tickets.mass-assign') }}" method="POST" id="massAssignForm">
                        @csrf

                        {{-- Selector de Técnico --}}
                        <div class="mb-6">
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700">
                                Asignar tickets al técnico:
                            </label>
                            <div class="mt-1">
                                <select name="assigned_to" id="assigned_to" required
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Selecciona un técnico</option>
                                    @foreach($tecnicos as $tecnico)
                                        <option value="{{ $tecnico->id }}">
                                            {{ $tecnico->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Controles de Selección --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <button type="button" id="selectAll"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Seleccionar Todos
                                </button>
                                <button type="button" id="deselectAll"
                                    class="text-sm font-medium text-gray-600 hover:text-gray-500">
                                    Deseleccionar Todos
                                </button>
                            </div>

                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Asignar Tickets Seleccionados
                            </button>
                        </div>

                        {{-- Lista de Tickets --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-12 px-6 py-3">
                                            <span class="sr-only">Seleccionar</span>
                                        </th>
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
                                            Categoría
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Prioridad
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Creado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($tickets as $ticket)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="tickets[]" value="{{ $ticket->id }}"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            </td>
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
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                {{ $ticket->category }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-nowrap">
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                                    {{ $ticket->priority === 'baja' ? 'bg-gray-100 text-gray-800' : '' }}
                                                    {{ $ticket->priority === 'media' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $ticket->priority === 'alta' ? 'bg-orange-100 text-orange-800' : '' }}
                                                    {{ $ticket->priority === 'critica' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($ticket->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-sm text-center text-gray-500">
                                                No hay tickets pendientes de asignación.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Seleccionar todos los tickets
        document.getElementById('selectAll').addEventListener('click', function() {
            document.querySelectorAll('input[name="tickets[]"]').forEach(checkbox => {
                checkbox.checked = true;
            });
        });

        // Deseleccionar todos los tickets
        document.getElementById('deselectAll').addEventListener('click', function() {
            document.querySelectorAll('input[name="tickets[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
        });

        // Validar que se haya seleccionado al menos un ticket
        document.getElementById('massAssignForm').addEventListener('submit', function(e) {
            const checkedTickets = document.querySelectorAll('input[name="tickets[]"]:checked');
            if (checkedTickets.length === 0) {
                e.preventDefault();
                alert('Por favor selecciona al menos un ticket para asignar.');
            }
        });
    </script>
    @endpush
</x-app-layout>