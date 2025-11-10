<header class="topbar">
    <nav class="nav">
        <div class="brand">
            <div class="brand-logo">N</div>
            <div class="brand-title">NOVA</div>
        </div>

        <div class="nav-links">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="{{ url('/#proyectos') }}">Proyectos</a>
            <a href="{{ url('/#servicios') }}">Servicios</a>
            <a href="{{ url('/#porque') }}">Por qué nosotros</a>

            @guest
                <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
            @else
                <span class="nav-user">
                    <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                </span>
                <a href="#"
                   class="btn-login"
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
