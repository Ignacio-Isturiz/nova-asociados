@extends('layouts.proyecto') {{-- tu layout admin --}}

@section('title', 'Citas | NOVA Admin')

@section('content')
  <div class="card-like">
    <div class="card-header">
      <h2 class="mb-0">Citas</h2>
      <small class="text-muted">Listado general de citas agendadas</small>
    </div>

    <div class="card-body">
      <table id="citasTable"
             class="display nowrap"
             style="width:100%"
             data-endpoint="{{ route('admin.citas.data') }}">
        <thead>
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Cliente</th>
          <th>Email</th>
          <th>Proyecto</th>
          <th>Teléfono</th>
          <th>Estado</th>
          <th>Notas</th>
          <th>Creado</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .card-like{background:#fff;border-radius:14px;box-shadow:0 10px 25px rgba(15,23,42,.08);padding:1rem}
    .card-header{display:flex;flex-direction:column;gap:.25rem;margin-bottom:1rem}
    /* badges simples para estado */
    .badge{display:inline-block;padding:.25rem .5rem;border-radius:999px;font-size:.75rem}
    .badge.pendiente{background:#fff3cd;color:#856404}
    .badge.confirmada{background:#d1e7dd;color:#0f5132}
    .badge.cancelada{background:#f8d7da;color:#842029}
    .dt-layout-row{gap: .75rem}
  </style>
@endpush

@push('scripts')
  @vite('resources/js/admin-citas.js')
@endpush
