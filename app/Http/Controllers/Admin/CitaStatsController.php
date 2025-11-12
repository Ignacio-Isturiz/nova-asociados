<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaStatsController extends Controller
{
    public function index()
    {
        return view('admin.citas.stats');
    }

    public function data(Request $request)
    {
        $from = $request->input('from');
        $to   = $request->input('to');

        $q = Cita::query();

        if ($from) {
            $q->whereDate('fecha', '>=', $from);
        }
        if ($to) {
            $q->whereDate('fecha', '<=', $to);
        }

        // Agrupar por mes y estado
        $rows = $q->selectRaw("DATE_FORMAT(fecha, '%Y-%m') as ym, estado, COUNT(*) as total")
            ->groupBy('ym', 'estado')
            ->orderBy('ym')
            ->get();

        // Labels (meses)
        $labels = array_values(array_unique($rows->pluck('ym')->toArray()));

        // Estados detectados dinámicamente
        $estados = array_values(array_unique($rows->pluck('estado')->toArray()));
        if (empty($estados)) {
            $estados = ['pendiente', 'confirmada', 'cancelada']; // fallback
        }

        // Inicializar matrices
        $series = [];
        foreach ($estados as $e) {
            $series[$e] = array_fill(0, count($labels), 0);
        }

        foreach ($rows as $r) {
            $i = array_search($r->ym, $labels, true);
            if ($i !== false) {
                if (!isset($series[$r->estado])) {
                    $series[$r->estado] = array_fill(0, count($labels), 0);
                }
                $series[$r->estado][$i] = (int) $r->total;
            }
        }

        // Totales por mes
        $total = [];
        for ($i = 0; $i < count($labels); $i++) {
            $sum = 0;
            foreach ($series as $vals) {
                $sum += $vals[$i] ?? 0;
            }
            $total[$i] = $sum;
        }

        return response()->json([
            'by_month' => [
                'labels' => $labels,
                'total'  => $total,
                'series' => $series, // {estado: [..]}
            ],
            'meta' => [
                'from' => $from,
                'to'   => $to,
                'generated_at' => now()->toIso8601String(),
            ],
        ]);
    }
}
