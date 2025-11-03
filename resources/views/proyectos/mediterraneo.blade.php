<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mediterráneo - Proyecto | NOVA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            height:100vh;
            background:url('https://images.pexels.com/photos/7031605/pexels-photo-7031605.jpeg?auto=compress&cs=tinysrgb&w=1600') center/cover no-repeat;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
        }
        .hero::after{
            content:"";position:absolute;inset:0;
            background:linear-gradient(to bottom,rgba(0,0,0,.3),rgba(0,0,0,.7));
        }
        .hero-content{
            position:relative;z-index:2;text-align:center;max-width:600px;padding:0 1rem;
            text-shadow:0 4px 15px rgba(0,0,0,0.6);
        }
        .hero h1{
            font-family:"Source Serif Pro",serif;
            font-size:5rem;letter-spacing:2px;margin-bottom:1rem;
        }
        .hero p{
            font-size:1.2rem;line-height:1.6;
        }

        /* SECCIÓN DETALLE */
        .detalle{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:3rem;
            max-width:1180px;
            margin:5rem auto;
            align-items:center;
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
            font-size:2rem;
            color:var(--brand);
            margin-bottom:1rem;
        }
        .detalle-texto ul{
            list-style:none;
            margin:1rem 0;
            padding:0;
        }
        .detalle-texto ul li{
            margin-bottom:.6rem;
            color:var(--ink);
        }
        .detalle-texto strong{
            color:var(--brand);
        }
        .detalle-botones{
            display:flex;
            flex-wrap:wrap;
            gap:1rem;
            margin-top:1.5rem;
        }
        .btn{
            border:2px solid var(--brand);
            border-radius:12px;
            padding:.7rem 1.4rem;
            font-weight:600;
            text-decoration:none;
            color:var(--brand);
            transition:all .2s;
        }
        .btn:hover{
            background:var(--brand);
            color:#fff;
        }
        .btn-brand{
            background:var(--brand);
            color:#fff;
        }
        .detalle-imagen{
            background:#f8f8f8;
            border-radius:20px;
            height:400px;
            display:grid;
            place-items:center;
            color:#bbb;
            font-size:1rem;
            border:2px dashed #ccc;
        }

        /* FOOTER */
        footer{
            background:#171413;
            color:#fff;
            padding:3rem 1.5rem;
            text-align:center;
            margin-top:4rem;
        }
        footer p{color:rgba(255,255,255,.6);}
        @media(max-width:900px){
            .detalle{grid-template-columns:1fr;}
            .hero h1{font-size:3.5rem;}
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
            <a href="{{ route('login') }}">Ingresar</a>
        </div>
    </nav>
</header>

<section class="hero">
    <div class="hero-content">
        <h1>MEDITERRÁNEO</h1>
        <p>Vive la elegancia y tranquilidad en El Retiro, rodeado de naturaleza con diseño contemporáneo.</p>
    </div>
</section>

<section class="detalle">
    <div class="detalle-texto">
        <h2>Características principales</h2>
        <div class="detalle-botones">
            <a href="#" class="btn">📍 Llega con Waze</a>
            <a href="#" class="btn">🗺️ Llega con Maps</a>
        </div>

        <ul>
            <li>✓ 2 parqueaderos por apartamento</li>
            <li>✓ Balcones amplios e integrados</li>
            <li>✓ Cocinas abiertas e iluminadas</li>
            <li>✓ Estudios cómodos y funcionales</li>
            <li>✓ Vista natural y zonas verdes</li>
        </ul>

        <p><strong>Áreas desde:</strong> 140 m²</p>
        <p><strong>Precio desde:</strong> $1.890 millones</p>

        <a href="#" class="btn btn-brand">AGENDAR VISITA</a>
    </div>

    <div class="detalle-imagen">
        <p>📷 Espacio reservado para galería dinámica</p>
    </div>
</section>

<footer>
    <p>© 2025 NOVA — Todos los derechos reservados.</p>
</footer>

</body>
</html>
