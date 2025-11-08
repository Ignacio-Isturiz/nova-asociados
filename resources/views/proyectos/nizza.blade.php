{{-- resources/views/proyectos/nizza.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nizza | NOVA</title>
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

        /* HERO */
        .hero{
            position:relative;
            margin-top:78px; /* para que no lo tape el navbar */
            height:360px;
            background:url('{{ asset($proyecto->imagen ?? "images/proyectos/nizza.jpg") }}') center/cover no-repeat;
        }
        .hero::after{
            content:"";position:absolute;inset:0;
            background:linear-gradient(to bottom,rgba(0,0,0,.15),rgba(0,0,0,.5));
        }
        .hero-content{
            position:relative;
            z-index:2;
            height:100%;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            color:#fff;
            text-align:center;
            text-shadow:0 3px 10px rgba(0,0,0,.3);
        }
        .hero-content h1{
            font-family:"Source Serif Pro",serif;
            font-size:3.4rem;
            margin-bottom:.5rem;
        }
        .hero-content p{
            font-size:1.05rem;
        }

        /* CONTENIDO */
        .detalle{
            display:grid;
            grid-template-columns:1.1fr .9fr;
            gap:3rem;
            max-width:1180px;
            margin:3rem auto 4rem;
            align-items:stretch;
            padding:0 1.5rem;
        }
        .detalle-texto{
            background:#fff;
            padding:2rem;
            border-radius:20px;
            box-shadow:0 20px 40px rgba(0,0,0,.05);
        }
        .detalle-texto h2{
            font-family:"Source Serif Pro",serif;
            font-size:2rem;
            color:var(--brand);
            margin-bottom:1rem;
        }
        .detalle-botones{
            display:flex;
            flex-wrap:wrap;
            gap:1rem;
            margin-bottom:1.5rem;
        }
        .btn{
            border:2px solid var(--brand);
            border-radius:12px;
            padding:.7rem 1.4rem;
            font-weight:600;
            text-decoration:none;
            color:var(--brand);
            background:#fff;
            transition:all .2s;
            display:inline-flex;
            align-items:center;
            gap:.4rem;
        }
        .btn:hover{
            background:var(--brand);
            color:#fff;
        }
        .detalle-texto ul{
            list-style:none;
            margin:1rem 0 1.4rem;
        }
        .detalle-texto ul li{
            margin-bottom:.55rem;
        }
        .btn-brand{
            background:var(--brand);
            color:#fff;
            display:inline-block;
        }
        .detalle-imagen{
            background:#f5f5f5;
            border-radius:20px;
            min-height:320px;
            display:grid;
            place-items:center;
            color:#999;
            border:2px dashed #ddd;
            text-align:center;
            padding:1.5rem;
        }

        footer{
            background:#171413;
            color:#fff;
            padding:3rem 1.5rem;
            text-align:center;
        }
        footer p{color:rgba(255,255,255,.6);}

        @media(max-width:900px){
            .detalle{grid-template-columns:1fr;}
            .hero{height:280px;}
            .hero-content h1{font-size:2.6rem;}
        }

        .btn{
            border:2px solid var(--brand);
            border-radius:12px;
            padding:.7rem 1.4rem;
            font-weight:600;
            text-decoration:none;
            color:var(--brand);
            background:#fff;
            transition:all .2s;
            display:inline-flex;
            align-items:center;
            gap:.4rem;
        }
        .btn:hover{
            background:var(--brand);
            color:#fff;
        }
        .btn-brand{
            border:2px solid var(--brand);
            background:var(--brand);
            color:#fff;
            border-radius:12px;
            padding:.7rem 1.4rem;
            font-weight:600;
            text-decoration:none;
            display:inline-block;
            margin-top:1rem;
            transition:all .2s;
        }
        .btn-brand:hover{
            background:#8a3a00;
        }
    </style>
</head>
<body>

@if(session('success'))
    <div style="background:#d1fae5; color:#065f46; padding:.7rem 1rem; text-align:center;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#fee2e2; color:#b91c1c; padding:.7rem 1rem; text-align:center;">
        {{ session('error') }}
    </div>
@endif

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

<section class="hero">
    <div class="hero-content">
        <h1>{{ $proyecto->nombre ?? 'Nizza' }}</h1>
        <p>{{ $proyecto->descripcion ?? 'Proyecto inmobiliario exclusivo.' }}</p>
    </div>
</section>

<section class="detalle">
    <div class="detalle-texto">
        <h2>Características principales</h2>
        <div class="detalle-botones">
            <a href="#" class="btn"><span>📍</span> Llega con Waze</a>
            <a href="#" class="btn"><span>🗺️</span> Llega con Maps</a>
        </div>

        <ul>
            <li>✓ 2 parqueaderos por apartamento</li>
            <li>✓ Balcones amplios e integrados</li>
            <li>✓ Cocinas abiertas e iluminadas</li>
            <li>✓ Estudios cómodos y funcionales</li>
            <li>✓ Vista natural y zonas verdes</li>
        </ul>

        <p><strong>Áreas desde:</strong> {{ $proyecto->area ?? '140 m²' }}</p>
        @if(!empty($proyecto->precio))
            <p><strong>Precio desde:</strong> {{ $proyecto->precio }}</p>
        @endif

        <a href="javascript:void(0);" class="btn btn-brand"
           onclick="document.getElementById('modal-cita-{{ $proyecto->id }}').style.display='flex'">
            AGENDAR VISITA
        </a>
    </div>

    <div class="detalle-imagen">
        <p>📷 Espacio reservado para galería dinámica</p>
    </div>
</section>

<script>
    // abrir/cerrar
    const modal = document.getElementById('modal-cita');
    const btnAbrir = document.getElementById('btn-abrir-modal');
    const btnCerrar = document.getElementById('cerrar-modal');

    btnAbrir.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    btnCerrar.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // cerrar si hace click fuera
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // fecha mínima = hoy
    const inputFecha = document.getElementById('input-fecha');
    if (inputFecha) {
        const hoy = new Date();
        const yyyy = hoy.getFullYear();
        const mm = String(hoy.getMonth() + 1).padStart(2, '0');
        const dd = String(hoy.getDate()).padStart(2, '0');
        const hoyStr = `${yyyy}-${mm}-${dd}`;
        inputFecha.min = hoyStr;
    }
</script>

<footer>
    <p>© {{ date('Y') }} NOVA — Todos los derechos reservados.</p>
</footer>

@include('proyectos.partials.cita-modal', ['proyecto' => $proyecto])
</body>
</html>
