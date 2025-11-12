@section('title', $isEdit ? 'Editar Cita' : 'Nueva Cita')

<div style="max-width:820px;margin:0 auto;padding:24px 16px;">
  <h1 style="font-size:2rem;font-weight:800;margin-bottom:16px;">
    {{ $isEdit ? 'Editar cita' : 'Nueva cita' }}
  </h1>

  @if (session('error'))
    <div style="margin-bottom:12px;padding:10px 12px;border-radius:10px;background:#fee2e2;color:#991b1b;">
      {{ session('error') }}
    </div>
  @endif

  @if (session('success'))
    <div style="margin-bottom:12px;padding:10px 12px;border-radius:10px;background:#dcfce7;color:#166534;">
      {{ session('success') }}
    </div>
  @endif

  <form wire:submit.prevent="save" class="card" style="padding:16px;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
      <div>
        <label>Usuario</label>
        <select wire:model.defer="user_id" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:.5rem .75rem;">
          <option value="">Seleccione...</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
        @error('user_id')<div style="color:#be123c;font-size:.85rem;margin-top:.25rem;">{{ $message }}</div>@enderror
      </div>

      <div>
        <label>Proyecto</label>
        <select wire:model.defer="proyecto_id" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:.5rem .75rem;">
          <option value="">Seleccione...</option>
          @foreach($proyectos as $p)
            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
          @endforeach
        </select>
        @error('proyecto_id')<div style="color:#be123c;font-size:.85rem;margin-top:.25rem;">{{ $message }}</div>@enderror
      </div>

      <div>
        <label>Fecha</label>
        <input type="date" wire:model.defer="fecha" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:.5rem .75rem;">
        @error('fecha')<div style="color:#be123c;font-size:.85rem;margin-top:.25rem;">{{ $message }}</div>@enderror
      </div>

      <div>
        <label>Hora</label>
        <input type="time" wire:model.defer="hora" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:.5rem .75rem;">
        @error('hora')<div style="color:#be123c;font-size:.85rem;margin-top:.25rem;">{{ $message }}</div>@enderror
      </div>

      <div>
        <label>Estado</label>
        <select wire:model.defer="estado" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:.5rem .75rem;">
          <option value="pendiente">Pendiente</option>
          <option value="confirmada">Confirmada</option>
          <option value="cancelada">Cancelada</option>
        </select>
        @error('estado')<div style="color:#be123c;font-size:.85rem;margin-top:.25rem;">{{ $message }}</div>@enderror
      </div>

      <div style="grid-column:1/-1;">
        <label>Notas</label>
        <textarea wire:model.defer="notas" rows="4" style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:.5rem .75rem;"></textarea>
        @error('notas')<div style="color:#be123c;font-size:.85rem;margin-top:.25rem;">{{ $message }}</div>@enderror
      </div>
    </div>

    <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end;">
      <a href="{{ route('admin.citas.index') }}" class="btn btn--ghost">Cancelar</a>
      <button class="btn btn--primary" type="submit">Guardar</button>
    </div>
  </form>
</div>
