<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitaCalendarController extends Controller
{
    public function events(Request $request)
    {
        $user = Auth::user();

        // FC envía ISO; las llevamos a la TZ de la app y nos quedamos con la fecha
        $startQ = $request->query('start');
        $endQ   = $request->query('end');

        $startDate = $startQ ? Carbon::parse($startQ)->timezone(config('app.timezone'))->toDateString() : null;
        $endDate   = $endQ   ? Carbon::parse($endQ)->timezone(config('app.timezone'))->toDateString()   : null;

        $q = Cita::with('proyecto')->where('user_id', $user->id);

        if ($startDate) $q->where('fecha', '>=', $startDate);
        if ($endDate)   $q->where('fecha', '<=', $endDate);

        $citas = $q->get();

        $events = $citas->map(function ($c) {
            $fecha  = Carbon::parse($c->fecha, config('app.timezone'));   // DATE o DATETIME
            $hora   = $c->hora ? substr($c->hora, 0, 5) : null;
        
            $startDT = $hora
                ? $fecha->copy()->setTimeFromTimeString($hora)  // fija solo la hora
                : $fecha;
        
            $endDT = (clone $startDT)->addMinutes($c->duracion_min ?? 60);
        
            $proyecto = $c->proyecto->nombre ?? 'Cita';
            $estado   = $c->estado ? ucfirst($c->estado) : 'Pendiente';
        
            $color = match (strtolower($c->estado ?? '')) {
                'cancelada'  => '#b91c1c',
                'confirmada' => '#15803d',
                default      => '#2563eb',
            };
        
            return [
                'id'    => (string) $c->id,
                'title' => "{$proyecto} - {$estado}",
                'start' => $startDT->format('c'),
                'end'   => $endDT->format('c'),
                'color' => $color,
                'extendedProps' => [
                    'proyecto' => $proyecto,
                    'estado'   => $c->estado ?? '',
                    'fecha'    => $startDT->toDateString(),
                    'hora'     => $startDT->format('H:i'),
                ],
            ];
        })->values();
        
        return response()->json($events);
    }
}
