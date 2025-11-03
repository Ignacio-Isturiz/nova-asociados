<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;

// LANDING PRINCIPAL
Route::get('/', function () {
    return view('landing');
});

// proyectos
Route::get('/proyectos/nizza', function () {
    return view('proyectos.nizza');
})->name('proyectos.nizza');

Route::get('/proyectos/mediterraneo', function () {
    return view('proyectos.mediterraneo');
})->name('proyectos.mediterraneo');

// RUTAS ADMIN 
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    });

// autenticación
Auth::routes();

//home
Route::middleware(['auth', 'role:usuario'])
    ->get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
    
// actualizar avatar de perfil
Route::middleware('auth')->post('/admin/profile/avatar', [ProfileController::class, 'updateAvatar'])
    ->name('admin.profile.avatar');
