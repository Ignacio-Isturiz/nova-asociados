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
});

// 🔹 AUTENTICACIÓN
Auth::routes();

// 🔹 RUTAS ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('admin.profile.avatar');
    });



// 🔹 HOME (solo para usuarios)
Route::middleware(['auth', 'role:usuario'])
    ->get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
