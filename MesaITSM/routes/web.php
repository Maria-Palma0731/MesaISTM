<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioDashboardController;
use App\Http\Controllers\TecnicoDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminServiceController;
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
    Route::put('/tecnico/tickets/{ticket}/escalate', [TecnicoTicketController::class, 'escalate'])->name('tecnico.tickets.escalate');
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
    
    // Catálogo de Servicios - Categorías
    Route::get('/administrador/catalog/categories', [AdminServiceController::class, 'categories'])->name('admin.catalog.categories');
    Route::get('/administrador/catalog/categories/create', [AdminServiceController::class, 'createCategory'])->name('admin.catalog.categories.create');
    Route::post('/administrador/catalog/categories', [AdminServiceController::class, 'storeCategory'])->name('admin.catalog.categories.store');
    Route::get('/administrador/catalog/categories/{category}/edit', [AdminServiceController::class, 'editCategory'])->name('admin.catalog.categories.edit');
    Route::put('/administrador/catalog/categories/{category}', [AdminServiceController::class, 'updateCategory'])->name('admin.catalog.categories.update');
    Route::delete('/administrador/catalog/categories/{category}', [AdminServiceController::class, 'destroyCategory'])->name('admin.catalog.categories.destroy');
    Route::post('/administrador/catalog/categories/reorder', [AdminServiceController::class, 'reorderCategories'])->name('admin.catalog.categories.reorder');
    
    // Catálogo de Servicios - Servicios
    Route::get('/administrador/catalog/services', [AdminServiceController::class, 'services'])->name('admin.catalog.services');
    Route::get('/administrador/catalog/services/create', [AdminServiceController::class, 'createService'])->name('admin.catalog.services.create');
    Route::post('/administrador/catalog/services', [AdminServiceController::class, 'storeService'])->name('admin.catalog.services.store');
    Route::get('/administrador/catalog/services/{service}/edit', [AdminServiceController::class, 'editService'])->name('admin.catalog.services.edit');
    Route::put('/administrador/catalog/services/{service}', [AdminServiceController::class, 'updateService'])->name('admin.catalog.services.update');
    Route::delete('/administrador/catalog/services/{service}', [AdminServiceController::class, 'destroyService'])->name('admin.catalog.services.destroy');
    Route::post('/administrador/catalog/services/reorder', [AdminServiceController::class, 'reorderServices'])->name('admin.catalog.services.reorder');
    
    // Gestión de usuarios
    Route::resource('administrador/users', UserController::class)->names('administrador.users');
});

require __DIR__.'/auth.php';
