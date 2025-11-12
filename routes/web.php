<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CitaCalendarController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CitaPdfController;

use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Citas\Index as CitasIndex;
use App\Livewire\Admin\Citas\Form  as CitasForm;

/* Landing */
Route::get('/', fn () => view('landing'))->name('landing');

/* Auth */
Auth::routes();

/* Usuario autenticado (no admin) */
Route::middleware(['auth'])->group(function () {
    Route::get('/proyectos/{slug}', [ProyectoController::class, 'show'])->name('proyectos.show');

    // Citas (usuario final)
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('citas.mis');
    Route::delete('/citas/{cita}/cancelar', [CitaController::class, 'cancelar'])->name('citas.cancelar');
    Route::get('/citas/{cita}/editar', [CitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{cita}', [CitaController::class, 'update'])->name('citas.update');

    // Calendario JSON
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

        // Citas (admin)
        Route::get('citas', CitasIndex::class)->name('citas.index');

        // ¡Estática primero! (no hace model binding)
        Route::get('citas/crear', CitasForm::class)->name('citas.create');

        // Editar con ID crudo para evitar binding automático
        Route::get('citas/{citaId}/editar', CitasForm::class)
            ->whereNumber('citaId') // o ->whereUuid('citaId') si usas UUID
            ->name('citas.edit');

        // Exportación PDF
        Route::get('/citas/export/pdf', [CitaPdfController::class, 'export'])->name('citas.export.pdf');
    });
