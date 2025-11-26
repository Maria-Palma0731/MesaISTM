<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de reportes (sin autenticación para pruebas)
Route::prefix('reports')->group(function () {
    Route::get('/dashboard', [ReportController::class, 'dashboard']);
    Route::get('/tickets', [ReportController::class, 'tickets']);
    Route::get('/technicians', [ReportController::class, 'technicians']);
    Route::get('/services', [ReportController::class, 'services']);
    Route::get('/knowledge-base', [ReportController::class, 'knowledgeBase']);
    Route::get('/trends', [ReportController::class, 'trends']);
    Route::get('/export', [ReportController::class, 'export']);
});
