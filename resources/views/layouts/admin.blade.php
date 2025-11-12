<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ $title ?? View::getSection('title') ?? 'Panel de administración' }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- CSS: Bootstrap (vía tu SCSS) + estilos del panel --}}
  @vite('resources/sass/admin.scss')

  @livewireStyles
  @stack('styles')
</head>
<body>
@php
  $avatar = auth()->user()?->avatar
      ? asset('storage/' . auth()->user()->avatar)
      : 'https://i.pravatar.cc/80';
@endphp

<div class="admin-wrapper">
  {{-- SIDEBAR --}}
  <aside class="admin-sidebar">
    <div class="sidebar-brand">NOVA Admin</div>

    <div class="sidebar-user">
      <img src="{{ $avatar }}" alt="perfil">
      <div>
        <div>{{ auth()->user()->name ?? 'Admin' }}</div>
        <small>Administrador</small>
      </div>
    </div>

    <ul class="sidebar-menu">
      <li>
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          Dashboard
        </a>
      </li>

      <li>
        {{-- Importante: enlace directo (sin data-partial) para no desmontar Livewire --}}
        <a href="{{ route('admin.citas.index') }}"
           class="{{ request()->routeIs('admin.citas.*') ? 'active' : '' }}">
          Citas
        </a>
      </li>

      <li>
        <a href="{{ route('admin.users') }}"
           class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
          Usuarios
        </a>
      </li>
    </ul>
  </aside>

  {{-- CONTENIDO --}}
  <div class="admin-content">
    <header class="admin-topbar">
      <div class="admin-user-btn" id="userMenuBtn">
        <span class="admin-user-email">{{ auth()->user()->email ?? '' }}</span>
        <img src="{{ $avatar }}" alt="perfil">
      </div>

      <div class="user-dropdown" id="userDropdown">
        <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
          @csrf
          <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none"
                 onchange="document.getElementById('avatarForm').submit();">
          <label for="avatarInput">Cambiar foto</label>
        </form>

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">Cerrar sesión</button>
        </form>
      </div>
    </header>

    <main class="admin-main">
      {{-- Blade clásico --}}
      @yield('content')
      {{-- Livewire page components --}}
      {{ $slot ?? '' }}
    </main>
  </div>
</div>

<script>
  // Dropdown usuario
  const btn = document.getElementById('userMenuBtn');
  const dropdown = document.getElementById('userDropdown');
  if (btn) btn.addEventListener('click', () => dropdown.classList.toggle('show'));
  document.addEventListener('click', (e) => {
    if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.remove('show');
    }
  });

  // Auto-logout por inactividad (ajusta INACTIVITY_TIME según necesites)
  const INACTIVITY_TIME = 1000000;
  let inactivityTimer;
  function logoutNow() {
    fetch("{{ route('logout') }}", {
      method: "POST",
      headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" },
    }).then(() => { window.location.href = "{{ route('login') }}"; });
  }
  function resetTimer() { clearTimeout(inactivityTimer); inactivityTimer = setTimeout(logoutNow, INACTIVITY_TIME); }
  ['mousemove','keydown','click','scroll','touchstart'].forEach(evt =>
    document.addEventListener(evt, resetTimer, {passive:true})
  );
  resetTimer();
</script>

{{-- Zona de modales global (si alguna vista los usa) --}}
<div id="modal-root"></div>
@yield('modals')
@stack('modals')

{{-- JS: carga al final para no interferir con Livewire --}}
@vite('resources/js/app.js')

@livewireScripts
@stack('scripts')
</body>
</html>
