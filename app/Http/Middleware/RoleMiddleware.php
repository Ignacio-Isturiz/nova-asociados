<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  Roles permitidos (pueden ser varios, separados por coma)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Si no está autenticado, redirigir al login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // Si el rol del usuario NO está en la lista de roles permitidos, mostrar error 403
        if (!in_array($userRole, $roles, true)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        // Si pasa todas las verificaciones, continuar
        return $next($request);
    }
}
