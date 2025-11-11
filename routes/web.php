<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CitaCalendarController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;

use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Http\Controllers\Admin\CitaPdfController;

/* Landing */
Route::get('/', fn () => view('landing'))->name('landing');

/* Auth */
Auth::routes();

/* Usuario autenticado (no admin) */
Route::middleware(['auth'])->group(function () {
    Route::get('/proyectos/{slug}', [ProyectoController::class, 'show'])->name('proyectos.show');

    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('citas.mis');
    Route::delete('/citas/{cita}/cancelar', [CitaController::class, 'cancelar'])->name('citas.cancelar');
    Route::get('/citas/{cita}/editar', [CitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{cita}', [CitaController::class, 'update'])->name('citas.update');

    Route::get('/citas/events', [CitaCalendarController::class, 'events'])->name('citas.events');
});

/* Home (rol usuario final) */
Route::middleware(['auth', 'role:usuario'])
    ->get('/home', [HomeController::class, 'index'])
    ->name('home');

/* Admin (Livewire) */
Route::middleware(['auth','verified','role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

        Route::get('/users', UsersIndex::class)->name('users');

        Route::get('/citas', \App\Livewire\Admin\Citas\Index::class)->name('citas.index');
        Route::get('/citas/create', \App\Livewire\Admin\Citas\Form::class)->name('citas.create');
        Route::get('/citas/{cita}/edit', \App\Livewire\Admin\Citas\Form::class)
            ->whereNumber('cita')
            ->name('citas.edit');
        Route::get('/citas/export/pdf', [CitaPdfController::class, 'export'])
            ->name('citas.export.pdf');


    });



