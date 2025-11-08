<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NOVA - Plataforma inmobiliaria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- fuente --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-serif-pro:400,600,700|inter:400,500,600" rel="stylesheet" />

    @vite('resources/sass/landing.scss')
</head>
<body>

{{{-- NAV --}}
<header class="topbar">
    <nav class="nav">
        <div class="brand">
            <div class="brand-logo">N</div>
            <div class="brand-title">NOVA</div>
        </div>
        <div class="nav-links">
            <a href="#proyectos">Proyectos</a>
            <a href="#servicios">Servicios</a>
            <a href="#porque">Por qué nosotros</a>

            @guest
                {{-- si NO está logueado --}}
                <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
            @else
                {{-- si SÍ está logueado --}}
                <span style="color:#fff; margin-right:1rem;">
                    <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                </span>
                <a href="#" class="btn-login"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            @endguest
        </div>
    </nav>
</header>

    {{-- HERO SLIDER --}}
    <section class="hero-slider">
        <div class="slide active" style="background-image: url('https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1600');"></div>
        <div class="slide" style="background-image: url('https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=1600');"></div>

        <div class="hero-overlay">
            <div class="hero-content-box">
                <h1 class="hero-logo">NOVA</h1>
                <p class="hero-subtitle">Apartamentos de campo · diseño contemporáneo</p>
                <p class="hero-price">
                    ¡Agenda tu visita! <br>
                    Hogares de lujo <br>
                    Áreas de 100 m² & 200 m²
                </p>
                <a href="{{ route('login') }}" class="hero-btn">
                    Hablemos
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- PROYECTOS --}}
    <section class="section" id="proyectos">
        <h2 class="section-title text-center">Nuestros <span>proyectos</span></h2>
        <p style="text-align:center;color:var(--muted);font-size:1.1rem;margin-top:-1rem;margin-bottom:2.8rem;">
            Descubre nuestros proyectos en construcción y proyectos entregados.
        </p>

        <div class="projects-grid">
            <article class="project-card" onclick="window.location='{{ route('proyectos.show', 'nizza') }}'">
                <div class="project-image">
                    <img src="https://images.pexels.com/photos/7031605/pexels-photo-7031605.jpeg?auto=compress&cs=tinysrgb&w=1600" alt="Proyecto Nizza">
                    <div class="overlay">NIZZA</div>
                </div>
                <div class="project-info">
                    <h3>Nizza</h3>
                    <p>Ubicado en El Retiro · Desde 140 m²</p>
                </div>
            </article>

            <article class="project-card" onclick="window.location='{{ route('proyectos.show', 'mediterraneo') }}'">
                <div class="project-image">
                    <img src="https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=1600" alt="Proyecto Mediterráneo">
                    <div class="overlay">MEDITERRÁNEO</div>
                </div>
                <div class="project-info">
                    <h3>Mediterráneo</h3>
                    <p>En Llanogrande · Desde 180 m²</p>
                </div>
            </article>
        </div>
    </section>

    {{-- MÉTRICAS --}}
    <section class="metrics">
        <div class="metrics-row">
            <div>
                <div class="metric">2,500+</div>
                <small>Clientes satisfechos</small>
            </div>
            <div>
                <div class="metric">15k+</div>
                <small>Propiedades verificadas</small>
            </div>
            <div>
                <div class="metric">$500M+</div>
                <small>En transacciones</small>
            </div>
        </div>
    </section>

    {{-- SERVICIOS --}}
    <section class="section" id="servicios">
        <h2 class="section-title">Nuestros <span>servicios</span></h2>
        <div class="services-grid">
            <article class="service-card">
                <div class="service-icon">📍</div>
                <h3>Búsqueda Avanzada</h3>
                <p>Encuentra propiedades con filtros inteligentes y mapas interactivos.</p>
            </article>
            <article class="service-card">
                <div class="service-icon">🛡</div>
                <h3>Transacciones Seguras</h3>
                <p>Procesos verificados y protegidos para tu tranquilidad.</p>
            </article>
            <article class="service-card">
                <div class="service-icon">👥</div>
                <h3>Asesoría Experta</h3>
                <p>Equipo profesional disponible para ayudarte 24/7.</p>
            </article>
            <article class="service-card">
                <div class="service-icon">📈</div>
                <h3>Análisis de Mercado</h3>
                <p>Reportes de valor para tomar las mejores decisiones.</p>
            </article>
            <article class="service-card">
                <div class="service-icon">🏅</div>
                <h3>Certificación Premium</h3>
                <p>Inmuebles con validación de documentos y propietarios.</p>
            </article>
            <article class="service-card">
                <div class="service-icon">🧾</div>
                <h3>Gestión Integral</h3>
                <p>Desde la visita hasta el cierre, todo desde la plataforma.</p>
            </article>
        </div>
    </section>

    {{-- POR QUÉ --}}
    <section class="section" id="porque">
        <div class="why-block">
            <div>
                <h2 class="why-title">¿Por qué elegir <span>NOVA?</span></h2>
                <ul class="why-list">
                    <li>✓ 20 años de experiencia en el mercado inmobiliario</li>
                    <li>✓ Tecnología para seguridad de transacciones</li>
                    <li>✓ Portafolio de propiedades premium verificadas</li>
                    <li>✓ Equipo multilingüe disponible</li>
                </ul>
            </div>
            <div class="why-img-wrapper">
                <img src="https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=1600" alt="Interior de lujo">
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer>
        <div class="footer-inner">
            <div>
                <div class="footer-title">NOVA</div>
                <p style="max-width:280px;line-height:1.5;">La plataforma inmobiliaria de lujo más confiable.</p>
            </div>
            <div class="footer-col">
                <div class="footer-title">Producto</div>
                <ul>
                    <li><a href="#servicios">Características</a></li>
                    <li><a href="#servicios">Precios</a></li>
                    <li><a href="#servicios">Seguridad</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <div class="footer-title">Empresa</div>
                <ul>
                    <li><a href="#porque">Nosotros</a></li>
                    <li><a href="#porque">Blog</a></li>
                    <li><a href="#porque">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <div class="footer-title">Legal</div>
                <ul>
                    <li><a href="#">Privacidad</a></li>
                    <li><a href="#">Términos</a></li>
                    <li><a href="#">Cookies</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © 2025 NOVA. Todos los derechos reservados.
        </div>
    </footer>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const slides = document.querySelectorAll(".hero-slider .slide");
        let index = 0;
        setInterval(() => {
            slides[index].classList.remove("active");
            index = (index + 1) % slides.length;
            slides[index].classList.add("active");
        }, 6000);
    });
    </script>

</body>
</html>
