@extends('layouts.app')

@section('title', 'Dashboard Técnico')

@section('sidebar-menu')
<div class="px-4">
    <a href="{{ route('tecnico.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('tecnico.dashboard') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }}">
        Dashboard
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Tickets Asignados
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Tickets Pendientes
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Base de Conocimientos
    </a>
</div>
@endsection

@section('header')
Dashboard de Técnico
@endsection

@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Card Tickets Asignados -->
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="mx-4">
                <h4 class="text-2xl font-semibold text-gray-700">{{ $assignedTickets->count() }}</h4>
                <p class="text-gray-500">Tickets Asignados</p>
            </div>
        </div>
    </div>

    <!-- Card Tickets Pendientes -->
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-20">
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="mx-4">
                <h4 class="text-2xl font-semibold text-gray-700">{{ $pendingTickets }}</h4>
                <p class="text-gray-500">Tickets Pendientes</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Tickets Asignados -->
<div class="bg-white shadow-md rounded-lg p-4 mt-6">
    <h3 class="text-lg font-semibold mb-4">Tickets Asignados Recientes</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($assignedTickets as $ticket)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ticket->creator->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ticket->subject }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ticket->priority === 'alta' ? 'bg-red-100 text-red-800' : 
                               ($ticket->priority === 'media' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status === 'abierto' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection