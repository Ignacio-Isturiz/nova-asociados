<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaCalendarController extends Controller
{
    public function events(Request $request)
    {
        $user = Auth::user();

        // Opcional: rango que manda FullCalendar
        $start = $request->query('start');
        $end   = $request->query('end');

        $q = Cita::with('proyecto')->where('user_id', $user->id);
        if ($start) $q->where('fecha', '>=', $start);
        if ($end)   $q->where('fecha', '<=', $end);

        $citas = $q->get();

        $events = $citas->map(function ($c) {
            $start = "{$c->fecha} " . substr($c->hora, 0, 5);
            $end   = date('Y-m-d H:i', strtotime($start . ' +60 minutes'));

            $proyecto = $c->proyecto->nombre ?? 'Cita';
            $estado   = ucfirst($c->estado);

            $color = match (strtolower($c->estado)) {
                'cancelada'  => '#b91c1c',
                'confirmada' => '#15803d',
                default       => '#2563eb',
            };

            return [
                'id'    => (string) $c->id,
                'title' => "{$proyecto} - {$estado}",
                'start' => $start,
                'end'   => $end,
                'color' => $color,
                'extendedProps' => [
                    'proyecto' => $proyecto,
                    'estado'   => $c->estado,
                    'fecha'    => $c->fecha,
                    'hora'     => substr($c->hora, 0, 5),
                ],
            ];
        });

        return response()->json($events);
    }
}
