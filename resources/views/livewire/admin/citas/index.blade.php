@section('title','Citas (Admin)')

<div style="max-width:1200px;margin:0 auto;padding:24px 16px;">
  <h1 style="font-size:2rem;font-weight:800;margin-bottom:16px;">Citas</h1>

  @if (session('success'))
    <div style="margin-bottom:12px;padding:10px 12px;border-radius:10px;background:#dcfce7;color:#166534;">
      {{ session('success') }}
    </div>
  @endif

  @php
  // preserva filtros actuales en el link de export
  $qs = request()->only(['q','sort','dir']);
@endphp

<div style="display:flex;gap:12px;align-items:center;justify-content:space-between;margin-bottom:14px;">
  <input
    type="text"
    wire:model.live.debounce.300ms="search"
    placeholder="Buscar título, estado, usuario, proyecto"
    style="flex:1;max-width:420px;border:1px solid #d1d5db;border-radius:10px;padding:.55rem .75rem;"
  >
  <div style="display:flex;gap:8px;">
    <button type="button" onclick="window.location.href='{{ route('admin.citas.export.pdf', $qs) }}'">
  Descargar PDF
</button>

    <button type="button" onclick="window.location.href='{{ route('admin.citas.create') }}'">
  Nueva cita
</button>


  </div>
</div>


  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th style="cursor:pointer" wire:click="sortBy('fecha')">
            Fecha @if($sortField==='fecha') <small>({{ $sortDirection }})</small>@endif
          </th>
          <th style="cursor:pointer" wire:click="sortBy('hora')">
            Hora @if($sortField==='hora') <small>({{ $sortDirection }})</small>@endif
          </th>
          <th style="cursor:pointer" wire:click="sortBy('estado')">
            Estado @if($sortField==='estado') <small>({{ $sortDirection }})</small>@endif
          </th>
          <th>Usuario</th>
          <th>Proyecto</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($citas as $c)
          <tr>
            <td>{{ \Illuminate\Support\Carbon::parse($c->fecha)->format('Y-m-d') }}</td>
            <td>{{ $c->hora }}</td>
            <td><span class="badge">{{ $c->estado }}</span></td>
            <td>{{ $c->usuario?->name ?? $c->nombre_usuario ?? '—' }}</td>
            <td>{{ $c->proyecto?->nombre ?? '—' }}</td>
            <td style="white-space:nowrap;display:flex;gap:.5rem;">
              <a href="{{ route('admin.citas.edit', ['citaId' => $c->id]) }}" class="btn btn-secondary">
                Editar
              </a>

              <button class="btn btn--danger" wire:click="confirmDelete({{ $c->id }})">Eliminar</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Sin resultados</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:12px;">{{ $citas->links() }}</div>

  {{-- Modal confirmar eliminación --}}
  @if ($confirmingDelete)
    <div class="admin-modal-backdrop" role="dialog" aria-modal="true" wire:keydown.escape.window="cancelDelete">
      <div class="admin-modal admin-modal--confirm">
        <div class="admin-modal__header">
          <div class="admin-modal__title">Eliminar cita</div>
          <button class="admin-modal__close" wire:click="cancelDelete">✕</button>
        </div>

        <p style="color:#374151; margin-bottom:16px;">
          ¿Seguro que deseas eliminar esta cita? Esta acción no se puede deshacer.
        </p>

        <div style="display:flex; gap:8px; justify-content:flex-end;">
          <button class="btn btn--ghost"  wire:click="cancelDelete">Cancelar</button>
          <button class="btn btn--danger" wire:click="deleteConfirmed">Sí, eliminar</button>
        </div>
      </div>
    </div>
  @endif
</div>
