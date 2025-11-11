<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HomeController;

// LANDING PRINCIPAL
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware('auth')->group(function () {

    // ver proyecto
    Route::get('/proyectos/{slug}', [ProyectoController::class, 'show'])
        ->name('proyectos.show');

    // guardar cita
    Route::post('/citas', [CitaController::class, 'store'])
        ->name('citas.store');

    // ver mis citas
    Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('citas.mis');
    
    // Cancelar cita
    Route::delete('citas/{cita}/cancelar', [CitaController::class, 'cancelar'])->name('citas.cancelar');

    // Editar cita (formulario)
    Route::get('/citas/{cita}/editar', [CitaController::class, 'edit'])->name('citas.edit');

    // Actualizar cita
    Route::put('/citas/{cita}', [CitaController::class, 'update'])->name('citas.update');
    
});

// 🔹 AUTENTICACIÓN
Auth::routes();

// 🔹 RUTAS ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('admin.profile.avatar');
        //para ver todas las citas
        // Route::middleware('role:admin')->get('/admin/citas', [CitaController::class, 'todasCitas'])->name('admin.citas');
    });

Route::get('/mis-citas', [\App\Http\Controllers\CitaController::class, 'misCitas'])
    ->name('citas.mis');

// feed de eventos para FullCalendar
Route::get('/citas/events', [\App\Http\Controllers\CitaCalendarController::class, 'events'])
    ->name('citas.events');

// 🔹 HOME (solo para usuarios)
Route::middleware(['auth', 'role:usuario'])
    ->get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
