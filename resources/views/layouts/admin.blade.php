<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ $title ?? View::getSection('title') ?? 'Panel de administración' }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite(['resources/sass/admin.scss', 'resources/js/app.js'])
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
        <a href="{{ route('admin.citas.index', ['fragment' => 1]) }}"
           data-partial
           data-target="#admin-dynamic"
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
      @yield('content')   {{-- vistas blade clásicas --}}
      {{ $slot ?? '' }}   {{-- page components de Livewire --}}
    </main>
  </div>
</div>

<script>
  const btn = document.getElementById('userMenuBtn');
  const dropdown = document.getElementById('userDropdown');
  if (btn) btn.addEventListener('click', () => dropdown.classList.toggle('show'));
  document.addEventListener('click', (e) => {
    if (!btn.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.remove('show');
  });

  const INACTIVITY_TIME = 1000000;
  let inactivityTimer;
  function logoutNow() {
    fetch("{{ route('logout') }}", {
      method: "POST",
      headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" },
    }).then(() => { window.location.href = "{{ route('login') }}"; });
  }
  function resetTimer() { clearTimeout(inactivityTimer); inactivityTimer = setTimeout(logoutNow, INACTIVITY_TIME); }
  ['mousemove','keydown','click','scroll','touchstart'].forEach(evt => document.addEventListener(evt, resetTimer, {passive:true}));
  resetTimer();
</script>

{{-- ⬇️ Zona global de modales: al final del <body> --}}
<div id="modal-root"></div>
@yield('modals')
@stack('modals')

@livewireScripts
@stack('scripts')
</body>
</html>
