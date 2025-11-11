<div class="card-like">
  <div class="card-header">
    <h2 class="mb-0">Citas</h2>
    <small class="text-muted">Listado general de citas agendadas</small>
  </div>

  {{-- altura fija + scroll interno --}}
  <div class="card-body citas-scroll">
    <table id="citasTable"
           class="display compact nowrap"   {{-- 👈 compacto y sin cortes de línea --}}
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

@push('styles')
<style>
  .card-like{background:#fff;border-radius:14px;box-shadow:0 10px 25px rgba(15,23,42,.08);padding:1rem}
  .card-header{display:flex;flex-direction:column;gap:.25rem;margin-bottom:1rem}
  .citas-scroll{max-height:55vh; overflow:auto;}              /* 👈 altura contenida */
  .display.compact tbody td{padding:6px 10px;}                /* 👈 menos padding */
  .display.compact thead th{padding:8px 10px;}
  .display.compact{font-size:.875rem;}                        /* 👈 font-size menor */
  .badge{display:inline-block;padding:.2rem .5rem;border-radius:999px;font-size:.7rem}
  .badge.pendiente{background:#fff3cd;color:#856404}
  .badge.confirmada{background:#d1e7dd;color:#0f5132}
  .badge.cancelada{background:#f8d7da;color:#842029}
  /* Acomoda el search a la derecha */
  .dt-layout-row:first-of-type{display:flex;justify-content:space-between;gap:.5rem}
  .dt-search{margin-left:auto;}
</style>
@endpush
