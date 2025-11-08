<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\InactivityMiddleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        // ejecutar nuestro comando cada minuto
        $schedule->command('citas:actualizar')->everyMinute();
    })
    
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // alias que ya tenías
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'inactivity' => \App\Http\Middleware\InactivityMiddleware::class,
            'prevent-back' => \App\Http\Middleware\PreventBackHistory::class,
        ]);

        // meterlo al grupo web
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\PreventBackHistory::class,
            \App\Http\Middleware\InactivityMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
