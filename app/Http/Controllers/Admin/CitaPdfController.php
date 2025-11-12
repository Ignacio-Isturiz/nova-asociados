<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;   // 👈 ESTE use

class CitaPdfController extends Controller
{
    public function export(Request $request)
    {
        $q    = trim((string)$request->get('q',''));
        $sort = in_array($request->get('sort'), ['fecha','hora','titulo','estado','created_at'], true)
              ? $request->get('sort') : 'fecha';
        $dir  = $request->get('dir') === 'asc' ? 'asc' : 'desc';

        $citas = Cita::with(['usuario','proyecto'])
            ->when($q !== '', function ($query) use ($q) {
                $like = "%{$q}%";
                $query->where(fn($w)=>$w
                    ->where('titulo','like',$like)
                    ->orWhere('estado','like',$like)
                    ->orWhere('notas','like',$like)
                    ->orWhere('nombre_usuario','like',$like)
                    ->orWhereHas('usuario', fn($u)=>$u->where('name','like',$like))
                    ->orWhereHas('proyecto', fn($p)=>$p->where('nombre','like',$like))
                );
            })
            ->orderBy($sort, $dir)
            ->get();

        return Pdf::loadView('admin.citas.pdf', [
                'citas'=>$citas, 'q'=>$q, 'sort'=>$sort, 'dir'=>$dir, 'now'=>now(),
            ])
            ->setPaper('a4','portrait')
            ->download('citas-'.now()->format('Ymd_His').'.pdf');
    }
}
