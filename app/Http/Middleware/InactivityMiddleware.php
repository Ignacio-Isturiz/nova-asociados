<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InactivityMiddleware
{
    protected int $timeout;

    public function __construct()
    {
        // Lee de .env y si no, default 300s
        $this->timeout = (int) env('INACTIVITY_TIMEOUT_SECONDS', 300);
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $last = Session::get('last_activity_time'); // timestamp (int)
            $now  = time();

            if (!is_null($last) && ($now - $last) > $this->timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['session' => 'Tu sesión expiró por inactividad.']);
            }
        }

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        // Actualiza el timestamp al finalizar la petición
        if (Auth::check()) {
            Session::put('last_activity_time', time());
        }

        return $response;
    }
}
