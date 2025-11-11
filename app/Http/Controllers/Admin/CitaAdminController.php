<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;

class CitaAdminController extends Controller
{
    public function index()
    {
        // si la petición es AJAX o trae ?fragment=1, devuelve solo el fragmento (sin layout)
        if (request()->ajax() || request()->boolean('fragment')) {
            return view('admin.citas._table');
        }
    
        // navegación normal: página completa (si alguna vez la quieres usar)
        return view('admin.citas.index'); // opcional; puedes no usar esta vista
    }

    public function data()
    {
        $citas = Cita::with(['usuario:id,name,email', 'proyecto:id,nombre,slug'])
            ->orderByDesc('fecha')->orderByDesc('hora')->get();

        $data = $citas->map(function ($cita) {
            return [
                'id' => $cita->id,
                'fecha' => (string) $cita->fecha,
                'hora' => substr((string) $cita->hora, 0, 5),
                'cliente' => $cita->usuario?->name ?? '—',
                'email' => $cita->usuario?->email ?? '—',
                'proyecto' => $cita->proyecto?->nombre ?? '—',
                'telefono' => $cita->telefono_contacto ?? '—',
                'estado' => $cita->estado,
                'notas' => $cita->notas ? mb_strimwidth($cita->notas, 0, 60, '…') : '—',
                'created' => $cita->created_at?->format('Y-m-d H:i'),
            ];
        });

        return response()->json(['data' => $data]);
    }
}
