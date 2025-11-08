{{-- resources/views/layouts/proyecto.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Proyecto | NOVA')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- iconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    {{-- fuentes --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-serif-pro:400,600,700|inter:400,500,600" rel="stylesheet" />

    <style>
        :root{
            --bg:#fff7e6;
            --brand:#a34700;
            --ink:#131313;
            --muted:#4b5563;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{
            font-family:"Inter",system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,sans-serif;
            color:var(--ink);
            background:var(--bg);
        }

        /* NAVBAR */
        .topbar{
            position:fixed;
            top:0;left:0;right:0;
            z-index:100;
            background:rgba(34,34,34,.95);
            backdrop-filter:blur(6px);
        }
        .nav{
            max-width:1180px;
            margin:0 auto;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:1rem 1.5rem;
        }
        .brand{display:flex;align-items:center;gap:.65rem;}
        .brand-logo{
            width:46px;height:46px;border-radius:999px;
            background:#fff;display:grid;place-items:center;
            font-weight:700;color:var(--brand);font-size:1.4rem;
        }
        .brand-title{font-family:"Source Serif Pro",serif;color:#fff;font-size:1.4rem;}
        .nav-links a{
            text-decoration:none;color:#fff;margin-left:1.5rem;font-weight:500;
        }

        footer{
            background:#171413;
            color:#fff;
            padding:3rem 1.5rem;
            text-align:center;
            margin-top:4rem;
        }
        footer p{color:rgba(255,255,255,.6);}
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
