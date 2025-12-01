<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Tickets de Soporte</h1>
                <p class="mt-2 text-gray-600">Registro, asignación, escalado y seguimiento de incidentes</p>
            </div>

            <!-- Dashboard de tickets --}}
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-4">
                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Total de tickets</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $counts['total'] }}</div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Tickets abiertos</div>
                    <div class="mt-1 text-3xl font-semibold text-blue-600">{{ $counts['abiertos'] }}</div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Pendientes de respuesta</div>
                    <div class="mt-1 text-3xl font-semibold text-yellow-500">{{ $counts['pendientes'] }}</div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="text-sm font-medium text-gray-500">Tickets resueltos</div>
                    <div class="mt-1 text-3xl font-semibold text-green-600">{{ $counts['resueltos'] }}</div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="p-4 mb-8 bg-white rounded-lg shadow">
                <form action="{{ route('tickets.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="status" id="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="nuevo" {{ request('status') == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                            <option value="asignado" {{ request('status') == 'asignado' ? 'selected' : '' }}>Asignado</option>
                            <option value="en_proceso" {{ request('status') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="pendiente_usuario" {{ request('status') == 'pendiente_usuario' ? 'selected' : '' }}>Pendiente de Usuario</option>
                            <option value="resuelto" {{ request('status') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                            <option value="cerrado" {{ request('status') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select name="category" id="category" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todas</option>
                            <option value="incidente" {{ request('category') == 'incidente' ? 'selected' : '' }}>Incidente</option>
                            <option value="solicitud_servicio" {{ request('category') == 'solicitud_servicio' ? 'selected' : '' }}>Solicitud de Servicio</option>
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
                            placeholder="Folio o título..."
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div class="flex items-end gap-2 md:col-span-5">
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Filtrar
                        </button>
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Limpiar
                        </a>
                        <button type="button" onclick="openCreateModal()" class="px-4 py-2 ml-auto text-white bg-green-600 rounded-md hover:bg-green-700">
                            Nuevo Ticket
                        </button>
                    </div>
                </form>
            </div>

            <!-- Lista de tickets -->
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse ($tickets as $ticket)
                        <li>
                            <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $ticket->title }}
                                            </p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @switch($ticket->priority)
                                                    @case('baja') bg-green-100 text-green-800 @break
                                                    @case('media') bg-yellow-100 text-yellow-800 @break
                                                    @case('alta') bg-red-100 text-red-800 @break
                                                    @case('critica') bg-red-200 text-red-900 @break
                                                @endswitch">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @switch($ticket->status)
                                                    @case('nuevo') bg-blue-100 text-blue-800 @break
                                                    @case('asignado') bg-purple-100 text-purple-800 @break
                                                    @case('en_proceso') bg-cyan-100 text-cyan-800 @break
                                                    @case('pendiente_usuario') bg-orange-100 text-orange-800 @break
                                                    @case('resuelto') bg-green-100 text-green-800 @break
                                                    @case('cerrado') bg-gray-100 text-gray-800 @break
                                                @endswitch">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                            <p class="text-sm text-gray-500">
                                                <span class="font-medium">Folio:</span> {{ $ticket->folio }}
                                            </p>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex sm:space-x-6">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Solicitante: {{ $ticket->creator->name ?? 'N/A' }}
                                                </p>
                                                @if($ticket->assignedTo)
                                                    <p class="flex items-center text-sm text-gray-500">
                                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                                        </svg>
                                                        Asignado a: {{ $ticket->assignedTo->name }}
                                                    </p>
                                                @else
                                                    <p class="flex items-center text-sm text-gray-500">
                                                        Asignado a: <span class="text-gray-400 ml-1">Sin asignar</span>
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                                <svg class="flex-shrink-0 w-4 h-4 mr-1.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                Creado: {{ $ticket->created_at->format('Y-m-d H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Iconos de acción --}}
                                    <div class="flex items-center ml-4 space-x-2">
                                        {{-- Ver Ticket --}}
                                        <a href="{{ route('tickets.show', $ticket) }}" 
                                           class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                           title="Ver ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        {{-- Asignar/Editar Ticket --}}
                                        @if(auth()->user()->role === 'administrador' || auth()->user()->role === 'tecnico')
                                        <button onclick="openAssignModal({{ $ticket->id }}, '{{ $ticket->folio }}', '{{ $ticket->title }}', {{ $ticket->assigned_to ?? 'null' }})" 
                                                class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors"
                                                title="Asignar técnico">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </button>
                                        @endif

                                        {{-- Editar Ticket --}}
                                        @if(auth()->user()->role === 'administrador' || $ticket->created_by === auth()->id())
                                        <button onclick="openEditModal({{ $ticket->id }}, '{{ $ticket->folio }}', '{{ addslashes($ticket->title) }}', '{{ addslashes($ticket->description) }}', '{{ $ticket->priority }}', '{{ $ticket->status }}')" 
                                                class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors"
                                                title="Editar ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        @endif

                                        {{-- Eliminar Ticket (solo admin) --}}
                                        @if(auth()->user()->role === 'administrador')
                                        <button onclick="openDeleteModal({{ $ticket->id }}, '{{ $ticket->folio }}', '{{ addslashes($ticket->title) }}')" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Eliminar ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-6 text-center text-gray-500 sm:px-6">
                            No hay tickets que mostrar
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

    {{-- Modal Editar Ticket --}}
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-6 border w-full max-w-lg shadow-2xl rounded-xl bg-white mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Editar Ticket <span id="editTicketFolio"></span></h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-500 mb-6">Actualiza la información del ticket</p>
            
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                    <input type="text" id="edit_title" name="title" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea id="edit_description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="edit_priority" class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                        <select id="edit_priority" name="priority"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                            <option value="critica">Crítica</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select id="edit_status" name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="nuevo">Nuevo</option>
                            <option value="asignado">Asignado</option>
                            <option value="en_proceso">En Proceso</option>
                            <option value="pendiente_usuario">Pendiente Usuario</option>
                            <option value="resuelto">Resuelto</option>
                            <option value="cerrado">Cerrado</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Asignar Técnico --}}
    <div id="assignModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-6 border w-full max-w-lg shadow-2xl rounded-xl bg-white mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Asignar Ticket</h3>
                <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-500 mb-6">Asigna el ticket <span id="assignTicketFolio" class="font-semibold"></span> a un técnico de soporte</p>
            
            <form id="assignForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ticket</label>
                    <p id="assignTicketTitle" class="text-gray-900"></p>
                </div>

                <div class="mb-6">
                    <label for="assign_technician" class="block text-sm font-medium text-gray-700 mb-2">Asignar a</label>
                    <select id="assign_technician" name="assigned_to"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Sin asignar</option>
                        @foreach(\App\Models\User::where('role', 'tecnico')->get() as $tech)
                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAssignModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        Asignar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Eliminar Ticket --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative p-6 border w-full max-w-lg shadow-2xl rounded-xl bg-white mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">¿Estás seguro?</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-500 mb-2">Esta acción no se puede deshacer. Se eliminará permanentemente el ticket:</p>
            <p class="font-semibold text-gray-900 mb-6"><span id="deleteTicketFolio"></span>: <span id="deleteTicketTitle"></span></p>
            
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Crear Nuevo Ticket --}}
    <div id="createModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative p-6 border w-full max-w-2xl shadow-2xl rounded-xl bg-white max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Crear Nuevo Ticket</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-500 mb-6">Completa la información del nuevo ticket de soporte</p>
            
            <form id="createTicketForm" action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="create_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="create_title" name="title" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Breve descripción del problema">
                </div>

                <div class="mb-4">
                    <label for="create_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción <span class="text-red-500">*</span>
                    </label>
                    <textarea id="create_description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Describe detalladamente el problema o solicitud"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="create_category" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select id="create_category" name="category" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecciona una categoría</option>
                            <option value="incidente">Incidente</option>
                            <option value="solicitud_servicio">Solicitud de Servicio</option>
                        </select>
                    </div>

                    <div>
                        <label for="create_subcategory" class="block text-sm font-medium text-gray-700 mb-2">
                            Subcategoría <span class="text-red-500">*</span>
                        </label>
                        <select id="create_subcategory" name="subcategory" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecciona una subcategoría</option>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="red">Red</option>
                            <option value="seguridad">Seguridad</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="create_priority" class="block text-sm font-medium text-gray-700 mb-2">
                            Prioridad <span class="text-red-500">*</span>
                        </label>
                        <select id="create_priority" name="priority" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="baja">Baja</option>
                            <option value="media" selected>Media</option>
                            <option value="alta">Alta</option>
                            <option value="critica">Crítica</option>
                        </select>
                    </div>

                    @if(auth()->user()->role === 'administrador' || auth()->user()->role === 'tecnico')
                    <div>
                        <label for="create_assigned_to" class="block text-sm font-medium text-gray-700 mb-2">
                            Asignar a
                        </label>
                        <select id="create_assigned_to" name="assigned_to"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Sin asignar</option>
                            @foreach(\App\Models\User::where('role', 'tecnico')->get() as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <div class="mb-6">
                    <label for="create_attachments" class="block text-sm font-medium text-gray-700 mb-2">
                        Archivos adjuntos (opcional)
                    </label>
                    <input type="file" id="create_attachments" name="attachments[]" multiple
                           accept="image/*,.pdf,.doc,.docx,.xls,.xlsx"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Máximo 3 archivos, 5MB cada uno. Formatos: imágenes, PDF, documentos de Office.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCreateModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                        Crear Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Modal Editar
        function openEditModal(ticketId, folio, title, description, priority, status) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editTicketFolio').textContent = folio;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_priority').value = priority;
            document.getElementById('edit_status').value = status;
            document.getElementById('editForm').action = `/tickets/${ticketId}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Modal Asignar
        function openAssignModal(ticketId, folio, title, assignedTo) {
            document.getElementById('assignModal').classList.remove('hidden');
            document.getElementById('assignTicketFolio').textContent = folio;
            document.getElementById('assignTicketTitle').textContent = title;
            document.getElementById('assign_technician').value = assignedTo || '';
            document.getElementById('assignForm').action = `/tickets/${ticketId}`;
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.add('hidden');
        }

        // Modal Eliminar
        function openDeleteModal(ticketId, folio, title) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteTicketFolio').textContent = folio;
            document.getElementById('deleteTicketTitle').textContent = title;
            document.getElementById('deleteForm').action = `/tickets/${ticketId}`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Modal Crear
        function openCreateModal() {
            // Limpiar todos los campos del formulario
            document.getElementById('create_title').value = '';
            document.getElementById('create_description').value = '';
            document.getElementById('create_category').value = '';
            document.getElementById('create_subcategory').value = '';
            document.getElementById('create_priority').value = 'media';
            @if(auth()->user()->role === 'administrador' || auth()->user()->role === 'tecnico')
            document.getElementById('create_assigned_to').value = '';
            @endif
            document.getElementById('create_attachments').value = '';
            
            // Mostrar el modal
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            // Limpiar errores
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            
            // Limpiar formulario
            document.getElementById('createTicketForm').reset();
            
            // Ocultar modal
            document.getElementById('createModal').classList.add('hidden');
        }

        // Manejar envío del formulario de crear ticket con AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const createForm = document.getElementById('createTicketForm');
            
            createForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Limpiar errores previos
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                document.querySelectorAll('.border-red-500').forEach(el => {
                    el.classList.remove('border-red-500');
                });
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.textContent;
                
                // Deshabilitar botón y mostrar loading
                submitBtn.disabled = true;
                submitBtn.textContent = 'Creando...';
                
                try {
                    const response = await fetch('{{ route("tickets.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        // Cerrar modal
                        closeCreateModal();
                        
                        // Limpiar formulario
                        createForm.reset();
                        
                        // Mostrar mensaje de éxito
                        alert(`✅ Ticket creado exitosamente\n\nFolio: ${data.folio}\n\nEl ticket ha sido registrado correctamente.`);
                        
                        // Recargar la página para ver el nuevo ticket
                        window.location.reload();
                    } else if (response.status === 422) {
                        // Errores de validación
                        const errors = data.errors || {};
                        let errorMessage = '❌ Por favor corrige los siguientes errores:\n\n';
                        
                        Object.keys(errors).forEach(field => {
                            const inputField = document.getElementById(`create_${field}`);
                            if (inputField) {
                                inputField.classList.add('border-red-500');
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'error-message text-red-500 text-sm mt-1';
                                errorDiv.textContent = errors[field][0];
                                inputField.parentNode.appendChild(errorDiv);
                            }
                            errorMessage += `• ${errors[field][0]}\n`;
                        });
                        
                        alert(errorMessage);
                    } else {
                        alert('❌ ' + (data.message || 'Error al crear el ticket. Por favor intenta nuevamente.'));
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('❌ Error de conexión. Por favor verifica tu conexión e intenta nuevamente.');
                } finally {
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                }
            });
        });

        // Cerrar modales al hacer clic fuera
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const assignModal = document.getElementById('assignModal');
            const deleteModal = document.getElementById('deleteModal');
            const createModal = document.getElementById('createModal');
            
            if (event.target == editModal) {
                closeEditModal();
            }
            if (event.target == assignModal) {
                closeAssignModal();
            }
            if (event.target == deleteModal) {
                closeDeleteModal();
            }
            if (event.target == createModal) {
                closeCreateModal();
            }
        }
    </script>
    @endpush
</x-app-layout>