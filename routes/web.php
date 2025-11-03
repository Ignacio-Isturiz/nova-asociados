<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/proyectos/nizza', function () {
    return view('proyectos.nizza');
})->name('proyectos.nizza');

Route::get('/proyectos/mediterraneo', function () {
    return view('proyectos.mediterraneo');
})->name('proyectos.mediterraneo');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
