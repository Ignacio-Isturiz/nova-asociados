<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InactivityMiddleware
{
    // Tiempo máximo de inactividad (segundos)
    protected int $timeout = 30; // o 900 (15 min)

    public function handle(Request $request, Closure $next): Response
    {
        // Solo aplica si hay usuario logueado
        if (Auth::check()) {
            $lastActivity = session('last_activity_time');

            // Si ya existe un registro previo y el tiempo se excedió
            if (!is_null($lastActivity) && (time() - $lastActivity) > $this->timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['session' => 'Tu sesión expiró por inactividad.']);
            }
        }

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        // ✅ Actualiza el timestamp DESPUÉS de procesar la petición,
        // para evitar conflictos durante redirecciones o doble refresh
        if (Auth::check()) {
            session(['last_activity_time' => time()]);
        }

        return $response;
    }
}
