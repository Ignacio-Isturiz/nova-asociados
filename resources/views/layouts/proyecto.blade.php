{{-- resources/views/layouts/proyecto.blade.php --}}
@extends('layouts.app')

@section('title', ($proyecto->nombre ?? 'Proyecto') . ' | NOVA')

@section('content')
    @include('partials.navbar-nova')

    {{-- HERO DEL PROYECTO --}}
    <section class="project-hero"
            style="background-image: url('{{ asset(trim($__env->yieldContent('hero-image', $proyecto->imagen ?? 'images/proyectos/default.jpg'))) }}');">
        <div class="project-hero__overlay"></div>
        <div class="project-hero__content">
            <h1>{{ $proyecto->nombre ?? 'Proyecto inmobiliario' }}</h1>
            <p>{{ $proyecto->descripcion ?? 'Proyecto inmobiliario exclusivo.' }}</p>
        </div>
    </section>

    {{-- CUERPO DEL PROYECTO --}}
    <section class="project-body">
        <div class="project-body__left">
            @yield('project-content')
        </div>

        <div class="project-body__right">
            @php
                // Si existe una imagen de detalle subida desde el panel admin, úsala
                $imgDetalle = $proyecto->imagen_detalle
                    ?? $proyecto->imagen
                    ?? 'images/proyectos/default.jpg';
            @endphp
            <img src="{{ asset($imgDetalle) }}"
                 alt="Imagen del proyecto {{ $proyecto->nombre ?? '' }}"
                 class="project-image">
        </div>
    </section>

    @include('partials.footer-nova')
@endsection
