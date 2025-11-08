<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cita;
use Carbon\Carbon;

class ActualizarEstadoCitas extends Command
{
    // este es el nombre del comando que vas a ejecutar
    protected $signature = 'citas:actualizar';

    protected $description = 'Marca como confirmadas las citas cuya fecha y hora ya pasaron';

    public function handle()
    {
        $ahora = Carbon::now();

        $citas = Cita::where('estado', 'pendiente')
            ->where(function ($q) use ($ahora) {
                $q->whereDate('fecha', '<', $ahora->toDateString())
                  ->orWhere(function ($q2) use ($ahora) {
                      $q2->whereDate('fecha', $ahora->toDateString())
                         ->whereTime('hora', '<=', $ahora->toTimeString());
                  });
            })
            ->get();

        foreach ($citas as $cita) {
            $cita->estado = 'confirmada';
            $cita->save();
        }

        $this->info('Citas actualizadas: '.$citas->count());
    }
}
