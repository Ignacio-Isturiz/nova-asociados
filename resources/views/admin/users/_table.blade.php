<div class="card-like">
  <div class="card-header">
    <h2 class="mb-0">Usuarios</h2>
    <small class="text-muted">Listado general de usuarios</small>
  </div>

  <div class="card-body">
    <table id="usersTable"
           class="display compact nowrap"
           style="width:100%"
           data-endpoint="{{ route('admin.users.data') }}">
      <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Creado</th>
        <th>Actualizado</th>
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
  .display.compact{font-size:.875rem;}
  .display.compact thead th{padding:8px 10px;}
  .display.compact tbody td{padding:6px 10px;}
  .dt-layout-row:first-of-type{display:flex;justify-content:space-between;gap:.5rem}
  .dt-search{margin-left:auto;}

  /* Badge de rol en negro (legible) */
  .role-badge{
    display:inline-block;padding:.2rem .6rem;border-radius:999px;
    background:#e5e7eb;color:#111827;border:1px solid #d1d5db;
    font-weight:600;text-transform:capitalize;font-size:.78rem;
  }

  /* Oculta columnas poco críticas en pantallas más pequeñas para evitar scroll de página */
  @media (max-width: 1366px){
    #usersTable th:nth-child(6), #usersTable td:nth-child(6){ display:none } /* Actualizado */
  }
  @media (max-width: 1200px){
    #usersTable th:nth-child(5), #usersTable td:nth-child(5){ display:none } /* Creado */
  }
</style>
@endpush
