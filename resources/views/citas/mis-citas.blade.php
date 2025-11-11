@extends('layouts.proyecto')

@section('content')
  @include('partials.navbar-nova')

  <div class="container py-4" style="margin-top:6rem; min-height: calc(100vh - 6rem);">
    <h2 class="text-center mb-4">Mi Calendario de Citas</h2>

    <div id="calendar" class="card p-3" style="box-shadow:0 10px 25px rgba(15,23,42,.08); border-radius:16px;"></div>

    {{-- ⬇️ Modal de edición --}}
    @include('partials.cita-edit-modal')
  </div>
@endsection

@push('scripts')
  @vite('resources/js/mis-citas-calendar.js')
@endpush
