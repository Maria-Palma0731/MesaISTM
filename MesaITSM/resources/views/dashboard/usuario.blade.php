@extends('layouts.app')

@section('title', 'Dashboard Usuario')

@section('sidebar-menu')
<div class="px-4">
    <a href="{{ route('usuario.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('usuario.dashboard') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }}">
        Dashboard
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Mis Tickets
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Nuevo Ticket
    </a>
</div>
@endsection

@section('header')
Dashboard de Usuario
@endsection

@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
    <!-- Card Tickets Activos -->
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="mx-4">
                <h4 class="text-2xl font-semibold text-gray-700">{{ $tickets->count() }}</h4>
                <p class="text-gray-500">Tickets Activos</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Tickets Recientes -->
<div class="bg-white shadow-md rounded-lg p-4 mt-6">
    <h3 class="text-lg font-semibold mb-4">Tickets Recientes</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ticket->subject }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status === 'abierto' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection