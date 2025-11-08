{{-- resources/views/proyectos/mediterraneo.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mediterráneo | NOVA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- iconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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

        /* HERO */
        .hero{
            margin-top:70px;
            position:relative;
            height:340px;
            overflow:hidden;
        }
        .hero img{
            width:100%;
            height:100%;
            object-fit:cover;
            filter:brightness(.55);
        }
        .hero-overlay{
            position:absolute;
            inset:0;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            color:#fff;
            text-align:center;
        }
        .hero-overlay h1{
            font-size:3rem;
            font-weight:700;
            text-shadow:0 2px 6px rgba(0,0,0,.4);
        }
        .hero-overlay p{
            margin-top:.4rem;
            font-size:1.1rem;
        }

        /* DETALLE */
        .detalle{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:2.5rem;
            max-width:1180px;
            margin:3.5rem auto 4.5rem auto;
            align-items:stretch;
            padding:0 1.5rem;
        }
        .detalle-texto{
            background:#fff;
            padding:2rem;
            border-radius:20px;
            box-shadow:0 20px 40px rgba(0,0,0,.08);
        }
        .detalle-texto h2{
            font-family:"Source Serif Pro",serif;
            font-size:2.1rem;
            color:var(--brand);
            margin-bottom:1.4rem;
        }
        .detalle-botones{
            display:flex;
            flex-wrap:wrap;
            gap:1rem;
            margin-bottom:1.4rem;
        }
        .btn-pill{
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            background:#fff;
            border:2px solid var(--brand);
            color:var(--brand);
            padding:.6rem 1.2rem;
            border-radius:14px;
            font-weight:600;
            text-decoration:none;
        }
        .detalle-texto ul{
            list-style:none;
            margin:1rem 0 1.4rem 0;
        }
        .detalle-texto ul li{
            margin-bottom:.55rem;
        }
        .btn-agendar{
            display:inline-block;
            background:var(--brand);
            color:#fff;
            padding:.7rem 1.35rem;
            border-radius:12px;
            font-weight:600;
            text-decoration:none;
        }

        .detalle-imagen{
            background:#f3f3f3;
            border:2px dashed #d2d2d2;
            border-radius:20px;
            display:grid;
            place-items:center;
            color:#999;
            font-size:1rem;
        }

        /* MODAL */
        .modal-backdrop{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.45);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:200;
        }
        .modal-card{
            background:#fff;
            width:90%;
            max-width:460px;
            border-radius:18px;
            padding:1.3rem 1.4rem 1.5rem 1.4rem;
            box-shadow:0 10px 40px rgba(0,0,0,.15);
        }
        .modal-card h3{
            margin-bottom:1rem;
            font-size:1.15rem;
        }
        .modal-close{
            border:none;
            background:transparent;
            font-size:1.2rem;
            cursor:pointer;
        }
        .form-control{
            width:100%;
            padding:.55rem .6rem;
            border:1px solid #ddd;
            border-radius:10px;
        }
        .btn-primary{
            background:var(--brand);
            color:#fff;
            border:none;
            padding:.6rem 1rem;
            border-radius:10px;
            font-weight:600;
            cursor:pointer;
            width:100%;
        }

        /* alertas */
        .alert-success{
            background:#d1fae5;
            color:#065f46;
            padding:.6rem 1rem;
            text-align:center;
        }
        .alert-error{
            background:#fee2e2;
            color:#b91c1c;
            padding:.6rem 1rem;
            text-align:center;
        }

        footer{
            background:#171413;
            color:#fff;
            text-align:center;
            padding:2.6rem 1rem;
        }

        @media(max-width:900px){
            .detalle{grid-template-columns:1fr;}
            .hero{height:280px;}
            .hero-overlay h1{font-size:2.4rem;}
        }
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
                <span style="color:#fff; margin-left:1.5rem;">
                    <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                </span>
                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form-proyecto').submit();"
                   style="margin-left:1.5rem;">
                    Cerrar sesión
                </a>
                <form id="logout-form-proyecto" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            @endguest
        </div>
    </nav>
</header>

{{-- alertas --}}
@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

{{-- HERO --}}
<section class="hero">
    <img src="{{ asset($proyecto->imagen ?? 'images/proyectos/mediterraneo.jpg') }}" alt="{{ $proyecto->nombre }}">
    <div class="hero-overlay">
        <h1>{{ $proyecto->nombre ?? 'Mediterráneo' }}</h1>
        <p>{{ $proyecto->descripcion ?? 'Proyecto inmobiliario exclusivo.' }}</p>
    </div>
</section>

{{-- CONTENIDO --}}
<section class="detalle">
    <div class="detalle-texto">
        <h2>Características principales</h2>

        <div class="detalle-botones">
            <a class="btn-pill" href="https://waze.com/ul?ll=6.140,-75.380&navigate=yes" target="_blank">📍 Llega con Waze</a>
            <a class="btn-pill" href="https://maps.google.com/?q=Medellin" target="_blank">🗺️ Llega con Maps</a>
        </div>

        <ul>
            <li>✓ 2 parqueaderos por apartamento</li>
            <li>✓ Balcones amplios e integrados</li>
            <li>✓ Cocinas abiertas e iluminadas</li>
            <li>✓ Estudios cómodos y funcionales</li>
            <li>✓ Vista natural y zonas verdes</li>
        </ul>

        <p><strong>Áreas desde:</strong> {{ $proyecto->area ?? '180 m²' }}</p>
        <p><strong>Precio desde:</strong> {{ $proyecto->precio ?? '$ 1.890 millones' }}</p>

        <a href="javascript:void(0);" class="btn btn-brand"
           onclick="document.getElementById('modal-cita-{{ $proyecto->id }}').style.display='flex'">
            AGENDAR VISITA
        </a>
    </div>

    <div class="detalle-imagen">
        📷 Espacio reservado para galería dinámica
    </div>
</section>


<footer>
    <p>© {{ date('Y') }} NOVA — Todos los derechos reservados.</p>
</footer>

@include('proyectos.partials.cita-modal', ['proyecto' => $proyecto])
</body>
</html>
