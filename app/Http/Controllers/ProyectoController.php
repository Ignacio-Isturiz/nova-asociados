<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Muestra la vista de un proyecto específico por su slug.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Busca el proyecto por su slug
        $proyecto = Proyecto::where('slug', $slug)->firstOrFail();

        /**
         * Si existe una vista personalizada con el mismo nombre del slug (por ejemplo,
         * resources/views/proyectos/nizza.blade.php), la usa.
         * Si no existe, usa la vista genérica base (resources/views/proyectos/base.blade.php).
         */
        if (view()->exists("proyectos.$slug")) {
            return view("proyectos.$slug", compact('proyecto'));
        }

        // Vista por defecto (genérica)
        return view('proyectos.base', compact('proyecto'));
    }
}
