@extends('layouts.app')

@section('title', 'Dashboard Administrador')

@section('sidebar-menu')
<div class="px-4">
    <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }}">
        Dashboard
    </a>
    <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }}">
        Usuarios
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Técnicos
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Tickets
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Departamentos
    </a>
    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-600">
        Configuración
    </a>
</div>
@endsection

@section('header')
Dashboard de Administrador
@endsection

@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Card Total Usuarios -->
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="mx-4">
                <h4 class="text-2xl font-semibold text-gray-700">{{ $totalUsers }}</h4>
                <p class="text-gray-500">Usuarios Totales</p>
            </div>
        </div>
    </div>

    <!-- Card Total Técnicos -->
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-500 bg-opacity-20">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <div class="mx-4">
                <h4 class="text-2xl font-semibold text-gray-700">{{ $totalTecnicos }}</h4>
                <p class="text-gray-500">Técnicos Activos</p>
            </div>
        </div>
    </div>

    <!-- Card Total Tickets -->
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-20">
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="mx-4">
                <h4 class="text-2xl font-semibold text-gray-700">{{ $totalTickets }}</h4>
                <p class="text-gray-500">Tickets Totales</p>
            </div>
        </div>
    </div>

    <!-- Card Tickets Abiertos -->
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-500 bg-opacity-20">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="mx-4">
                <h4 class="text-2xl font-semibold text-gray-700">{{ $openTickets }}</h4>
                <p class="text-gray-500">Tickets Abiertos</p>
            </div>
        </div>
    </div>
</div>

<!-- Gráficas y Estadísticas -->
<div class="grid gap-6 mb-8 md:grid-cols-2">
    <div class="bg-white rounded-lg shadow-md p-4">
        <h3 class="text-lg font-semibold mb-4">Actividad Reciente</h3>
        <!-- Aquí iría un gráfico de actividad -->
        <p class="text-gray-500 text-center py-8">Gráfico de actividad (implementar con Chart.js)</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4">
        <h3 class="text-lg font-semibold mb-4">Distribución de Tickets</h3>
        <!-- Aquí iría un gráfico de distribución -->
        <p class="text-gray-500 text-center py-8">Gráfico de distribución (implementar con Chart.js)</p>
    </div>
</div>
@endsection