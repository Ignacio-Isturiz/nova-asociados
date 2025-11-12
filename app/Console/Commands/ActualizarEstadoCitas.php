<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActualizarEstadoCitas extends Command
{
    protected $signature = 'citas:actualizar';
    protected $description = 'Marca como REALIZADA toda cita PENDIENTE cuya fecha y hora ya pasaron';

    public function handle()
    {
        $now = Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s');

        $affected = DB::table('citas')
            ->where('estado', 'pendiente')
            ->whereRaw("TIMESTAMP(CONCAT(fecha,' ',hora)) <= ?", [$now])
            ->update([
                'estado'     => 'realizada',
                'updated_at' => Carbon::now(),
            ]);

        $this->info("[".now()."] Citas actualizadas: {$affected}");
        return self::SUCCESS;
    }
}
