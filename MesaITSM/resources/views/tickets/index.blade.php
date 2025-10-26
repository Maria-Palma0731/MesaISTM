
@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
    <div class="tickets-header">
        <h2>Listado de Tickets</h2>
        <a class="btn" href="{{ route('tickets.create') }}">Nuevo Ticket</a>
    </div>

    @if(session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td><a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->title }}</a></td>
                        <td><span class="badge badge-{{ $ticket->status }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span></td>
                        <td><span class="badge badge-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span></td>
                        <td>
                            <a class="btn-sm" href="{{ route('tickets.edit', $ticket) }}">Editar</a>
                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn-sm btn-danger" type="submit" onclick="return confirm('¿Eliminar este ticket?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No hay tickets registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $tickets->links() }}
    </div>
@endsection
