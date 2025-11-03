<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioDashboardController;
use App\Http\Controllers\TecnicoDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TecnicoTicketController;
use App\Http\Controllers\AdminTicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return redirect()->route("$role.dashboard");
    }
    return redirect()->route('login');
});

// Rutas de autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Ruta de respaldo para dashboard - redirige según el rol
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return redirect()->route("$role.dashboard");
    })->name('dashboard');
    
    // Tickets - TODOS los roles pueden crear y gestionar sus propios tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::put('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::get('/tickets/attachment/{attachment}', [TicketController::class, 'downloadAttachment'])->name('tickets.attachment.download');
});

// Rutas protegidas para usuarios
Route::middleware(['auth', 'role:usuario'])->group(function () {
    Route::get('/usuario/dashboard', [UsuarioDashboardController::class, 'index'])->name('usuario.dashboard');
});

// Rutas protegidas para técnicos
Route::middleware(['auth', 'role:tecnico'])->group(function () {
    Route::get('/tecnico/dashboard', [TecnicoDashboardController::class, 'index'])->name('tecnico.dashboard');
    
    // Tickets asignados
    Route::get('/tecnico/tickets', [TecnicoTicketController::class, 'index'])->name('tecnico.tickets.index');
    Route::get('/tecnico/tickets/{ticket}', [TecnicoTicketController::class, 'show'])->name('tecnico.tickets.show');
    Route::put('/tecnico/tickets/{ticket}/update', [TecnicoTicketController::class, 'update'])->name('tecnico.tickets.update');
    Route::post('/tecnico/tickets/{ticket}/comment', [TecnicoTicketController::class, 'addComment'])->name('tecnico.tickets.comment');
    Route::post('/tecnico/tickets/{ticket}/time', [TecnicoTicketController::class, 'logTime'])->name('tecnico.tickets.time');
});

// Rutas protegidas para administradores
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/administrador/dashboard', [AdminDashboardController::class, 'index'])->name('administrador.dashboard');
    
    // Gestión de tickets
    Route::get('/administrador/tickets', [AdminTicketController::class, 'index'])->name('administrador.tickets.index');
    Route::get('/administrador/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('administrador.tickets.show');
    Route::put('/administrador/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])->name('administrador.tickets.assign');
    Route::put('/administrador/tickets/{ticket}/update', [AdminTicketController::class, 'update'])->name('administrador.tickets.update');
    
    // Gestión de usuarios
    Route::resource('administrador/users', UserController::class)->names('administrador.users');
});

require __DIR__.'/auth.php';
