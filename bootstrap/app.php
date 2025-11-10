<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Tus middleware
use App\Http\Middleware\InactivityMiddleware;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    // CRON / Scheduler
    ->withSchedule(function (Schedule $schedule) {
        // Ejecuta tu comando cada minuto
        $schedule->command('citas:actualizar')->everyMinute();
    })

    // Rutas
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // Middleware
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'          => RoleMiddleware::class,
            'inactivity'    => InactivityMiddleware::class,
            'prevent-back'  => PreventBackHistory::class,
        ]);

        $middleware->appendToGroup('web', [
            PreventBackHistory::class,
            InactivityMiddleware::class,
        ]);
    })

    // Manejo de excepciones (opcional)
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
