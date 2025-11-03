@extends('layouts.app')

@section('content')
<style>
  :root{
    --bg-grad-1:#FFFAF0; --bg-grad-2:#FFFDF8;
    --brand:#8B2E00; --brand-hover:#A53C00; --accent:#f5b301;
    --text:#1f2937; --muted:#6b7280; --border:#e5e7eb;
  }
  .auth-wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;
    background:linear-gradient(135deg,var(--bg-grad-1),var(--bg-grad-2))}
  .auth-card{width:100%;max-width:560px;background:#fff;border-radius:16px;overflow:hidden;
    box-shadow:0 30px 60px rgba(0,0,0,.08)}
  .auth-head{background:var(--brand);color:#fff;text-align:center;padding:48px 24px}
  .auth-title{font-weight:800;font-size:40px;letter-spacing:.2px;margin:0 0 8px}
  .auth-underline{width:56px;height:6px;background:var(--accent);border-radius:999px;margin:0 auto 10px}
  .auth-sub{opacity:.9;font-size:14px}
  .auth-body{padding:40px 48px}
  .field{margin-bottom:18px}
  .label{display:block;color:#374151;font-size:.9rem;font-weight:600;margin-bottom:8px}
  .control{display:flex;align-items:center;border:1px solid var(--border);border-radius:10px;
    padding:12px 14px;transition:.2s;gap:10px}
  .control:focus-within{outline:3px solid rgba(245,179,1,.25);border-color:#f1c65a}
  .icon{width:20px;height:20px;color:#c15a17;flex:0 0 auto}
  .input{border:0;outline:0;width:100%;font-size:15px;color:var(--text)}
  .hint{display:block;color:#dc2626;font-size:.85rem;margin-top:6px}
  .link{color:#9a3a04;text-decoration:none}
  .link:hover{text-decoration:underline}
  .btn{width:100%;display:inline-flex;justify-content:center;align-items:center;gap:8px;
    background:var(--brand);color:#fff;border:0;border-radius:10px;padding:14px 16px;
    font-weight:700;cursor:pointer;transition:.2s}
  .btn:hover{background:var(--brand-hover)}
  .dotSep{display:flex;justify-content:center;margin:18px 0}
  .dotSep i{width:6px;height:2px;background:#D1D5DB;border-radius:4px;display:block}
  .auth-foot{margin-top:18px;text-align:center;color:var(--muted);font-size:.95rem}
  @media (max-width:620px){.auth-body{padding:28px}}
</style>

<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-head">
      <h1 class="auth-title">Acceso</h1>
      <div class="auth-underline"></div>
      <p class="auth-sub">Ingresa a tu cuenta inmobiliaria</p>
    </div>

    <div class="auth-body">
      <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="field">
          <label for="email" class="label">Correo Electrónico</label>
          <div class="control">
            {{-- mail icon --}}
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z"/><path d="m22 8-10 6L2 8"/></svg>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="tu@correo.com" class="input">
          </div>
          @error('email') <span class="hint">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div class="field" style="margin-bottom:8px">
          <label for="password" class="label">Contraseña</label>
          <div class="control">
            {{-- lock icon --}}
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="input">
            {{-- eye icon (decorativo) --}}
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3"/></svg>
          </div>
          @if (isset($errors) && $errors->has('email'))
    <span class="hint">{{ $errors->first('email') }}</span>
@endif
        </div>

        @if (Route::has('password.request'))
          <div style="text-align:right;margin-bottom:22px">
            <a class="link" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
          </div>
        @endif

        <button type="submit" class="btn">
          Ingresar
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>

        <div class="dotSep"><i></i></div>

        <div class="auth-foot">
          ¿No tienes cuenta?
          <a class="link" href="{{ route('register') }}">Regístrate</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
