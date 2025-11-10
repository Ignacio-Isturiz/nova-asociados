@extends('layouts.proyecto')

@section('hero-image', 'images/proyectos/nizza.jpg')

@section('project-content')
    <h2 class="project-title">Características principales</h2>

    {{-- Mostrar el mensaje de éxito o error --}}
    @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div id="error-message" class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="project-actions">
        <a href="https://waze.com/ul?ll=6.140,-75.380&navigate=yes" target="_blank" class="btn-outline">
            📍 Llega con Waze
        </a>
        <a href="https://maps.google.com/?q=Nizza" target="_blank" class="btn-outline">
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

    <p><strong>Áreas desde:</strong> {{ $proyecto->area ?? '140 m²' }}</p>
    @if(!empty($proyecto->precio))
        <p><strong>Precio desde:</strong> {{ $proyecto->precio }}</p>
    @endif

    <button type="button" class="btn-primary"
            onclick="document.getElementById('modal-cita-{{ $proyecto->id }}').style.display='flex'">
        AGENDAR VISITA
    </button>

    {{-- Botón para ver mis citas --}}
@auth
    <button type="button" class="btn-primary"
            onclick="window.location.href='{{ route('citas.mis') }}'">
        MIS CITAS
    </button>
@endauth


    {{-- Modal de cita --}}
    @include('partials.cita-modal', ['proyecto' => $proyecto])

@endsection

{{-- Script para que los mensajes desaparezcan después de 5 segundos --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mensaje de éxito
        @if(session('success'))
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 5000);
        @endif

        // Mensaje de error
        @if(session('error'))
            setTimeout(function() {
                document.getElementById('error-message').style.display = 'none';
            }, 5000);
        @endif
    });
</script>

<style>
    .alert {
        padding: 15px;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 15px;
    }

    .alert-success {
        background-color: #28a745;
        color: white;
    }

    .alert-error {
        background-color: #dc3545;
        color: white;
    }

    .alert {
        animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
</style>
