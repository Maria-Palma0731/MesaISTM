
@extends('layouts.app')

@section('title', 'Dashboard - Mesa de Ayuda ITSM')

@section('content')

    <section class="cards-grid">
        <div class="card">
            <h3>Gestión de Tickets</h3>
            <p class="stat">{{ $tickets_count }}</p>
            <p>Registro, asignación, escalado, actualización y cierre de tickets.</p>
            <a class="btn" href="{{ route('tickets.index') }}">Ver tickets</a>
        </div>
        <div class="card">
            <h3>Catálogo de Servicios</h3>
            <p class="stat">{{ $services_count }}</p>
            <p>Listado de servicios disponibles con formularios de solicitud en línea.</p>
            <a class="btn" href="#">Ver catálogo</a>
        </div>
        <div class="card">
            <h3>Base de Conocimiento</h3>
            <p class="stat">{{ $knowledge_articles_count }}</p>
            <p>Repositorio de soluciones y artículos para incidentes frecuentes.</p>
            <a class="btn" href="#">Ver KB</a>
        </div>
    </section>
@endsection
