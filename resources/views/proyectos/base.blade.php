{{-- resources/views/layouts/proyecto.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Proyecto | NOVA')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- tus links --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-serif-pro:400,600,700|inter:400,500,600" rel="stylesheet" />

    <style>
        /* TODO: aquí dejas TODO tu CSS igualito al que pegaste */
        /* ... */
    </style>
</head>
<body>

<header class="topbar">
    <nav class="nav">
        <div class="brand">
            <div class="brand-logo">N</div>
            <div class="brand-title">NOVA</div>
        </div>
        <div class="nav-links">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="{{ url('/#proyectos') }}">Proyectos</a>

            @guest
                <a href="{{ route('login') }}">Ingresar</a>
            @else
                <span style="color:#fff; margin-right:1rem;">
                    <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                </span>
                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form-proyecto').submit();">
                    Cerrar sesión
                </a>
                <form id="logout-form-proyecto" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            @endguest
        </div>
    </nav>
</header>

<main style="margin-top:70px;">
    @yield('content')
</main>

<footer>
    <p>© {{ date('Y') }} NOVA — Todos los derechos reservados.</p>
</footer>

</body>
</html>
