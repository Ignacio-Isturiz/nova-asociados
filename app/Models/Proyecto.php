<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'ubicacion',
        'area',
        'precio',
        'imagen',
    ];  

    // 🔹 Relación: un proyecto puede tener muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
