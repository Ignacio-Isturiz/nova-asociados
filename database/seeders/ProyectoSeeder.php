<?php

namespace Database\Seeders;

// En database/seeders/ProyectoSeeder.php

use App\Models\Proyecto;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        Proyecto::create([
            'nombre' => 'Nizza',
            'slug' => 'nizza',
            'descripcion' => 'Ubicado en El Retiro, rodeado de naturaleza con vista al lago.',
            'ubicacion' => 'El Retiro',
            'area' => 140,
            'precio' => 1890,
            'imagen' => 'images/proyectos/nizza.jpg',
        ]);

        Proyecto::create([
            'nombre' => 'Mediterráneo',
            'slug' => 'mediterraneo',
            'descripcion' => 'Diseño moderno con amplios espacios y excelente ubicación en Llanogrande.',
            'ubicacion' => 'Llanogrande',
            'area' => 180,
            'precio' => 2450,
            'imagen' => 'images/proyectos/mediterraneo.jpg',
        ]);
    }
}
