
@extends('layouts.app')

@section('title', 'Crear Ticket')

@section('content')
    <div class="form-card">
        <h2>Nuevo Ticket</h2>

        @if($errors->any())
            <div class="errors"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="priority">Prioridad</label>
                <select name="priority" id="priority">
                    <option value="low">Baja</option>
                    <option value="normal" selected>Normal</option>
                    <option value="high">Alta</option>
                </select>
            </div>

            <button class="btn" type="submit">Crear Ticket</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
