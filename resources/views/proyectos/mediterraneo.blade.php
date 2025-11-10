{{-- resources/views/proyectos/mediterraneo.blade.php --}}
@extends('layouts.proyecto')

{{-- Hero personalizado --}}
@section('hero-image', 'images/proyectos/mediterraneo.jpg')

{{-- Contenido principal --}}
@section('project-content')
    <h2 class="project-title">Características principales</h2>

    <div class="project-actions">
        <a href="https://waze.com/ul?ll=6.140,-75.380&navigate=yes" target="_blank" class="btn-outline">
            📍 Llega con Waze
        </a>
        <a href="https://maps.google.com/?q=Mediterraneo" target="_blank" class="btn-outline">
            🗺️ Llega con Maps
        </a>
    </div>

    <ul class="project-features">
        <li>2 parqueaderos por apartamento</li>
        <li>Balcones amplios e integrados</li>
        <li>Cocinas abiertas e iluminadas</li>
        <li>Estudios cómodos y funcionales</li>
        <li>Vista natural y zonas verdes</li>
    </ul>

    <p><strong>Áreas desde:</strong> {{ $proyecto->area ?? '180 m²' }}</p>
    <p><strong>Precio desde:</strong> {{ $proyecto->precio ?? '$ 1.890 millones' }}</p>

    <button type="button" class="btn-primary"
            onclick="document.getElementById('modal-cita-{{ $proyecto->id }}').style.display='flex'">
        AGENDAR VISITA
    </button>

    {{-- Modal de cita --}}
    @include('partials.cita-modal', ['proyecto' => $proyecto])
@endsection
