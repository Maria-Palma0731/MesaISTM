
@extends('layouts.app')

@section('title', 'Ver Ticket')

@section('content')
    <div class="ticket-card">
        <h2>{{ $ticket->title }}</h2>
        <div class="ticket-meta">
            <span class="badge badge-{{ $ticket->status }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span>
            <span class="badge badge-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span>
        </div>
        <div class="ticket-desc">
            <p>{{ $ticket->description }}</p>
        </div>
        <div class="ticket-actions">
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn">Editar</a>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@endsection
