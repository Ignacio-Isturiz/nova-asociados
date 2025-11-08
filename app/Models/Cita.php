<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_usuario',
        'proyecto_id',
        'fecha',
        'hora',
        'telefono_contacto',
        'estado',
        'notas',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
