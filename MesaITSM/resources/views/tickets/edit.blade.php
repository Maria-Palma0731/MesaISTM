
@extends('layouts.app')

@section('title', 'Editar Ticket')

@section('content')
    <div class="form-card">
        <h2>Editar Ticket</h2>

        @if($errors->any())
            <div class="errors"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" value="{{ old('title', $ticket->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description">{{ old('description', $ticket->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="priority">Prioridad</label>
                <select name="priority" id="priority">
                    <option value="low" {{ $ticket->priority=='low'?'selected':'' }}>Baja</option>
                    <option value="normal" {{ $ticket->priority=='normal'?'selected':'' }}>Normal</option>
                    <option value="high" {{ $ticket->priority=='high'?'selected':'' }}>Alta</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Estado</label>
                <select name="status" id="status">
                    <option value="open" {{ $ticket->status=='open'?'selected':'' }}>Abierto</option>
                    <option value="in_progress" {{ $ticket->status=='in_progress'?'selected':'' }}>En Progreso</option>
                    <option value="closed" {{ $ticket->status=='closed'?'selected':'' }}>Cerrado</option>
                </select>
            </div>

            <button class="btn" type="submit">Actualizar</button>
            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
