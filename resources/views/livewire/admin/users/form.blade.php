<form wire:submit.prevent="save">
  <div class="admin-modal__title" style="margin-bottom:.75rem;">
    {{ $userId ? 'Editar usuario' : 'Nuevo usuario' }}
  </div>

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
    <div>
      <label style="display:block; font-size:.9rem; margin-bottom:.25rem;">Nombre</label>
      <input type="text" wire:model.defer="name" class="form-control" style="width:100%; border:1px solid #d1d5db; border-radius:10px; padding:.5rem .75rem;">
      @error('name') <p style="color:#be123c; font-size:.85rem; margin-top:.25rem;">{{ $message }}</p> @enderror
    </div>

    <div>
      <label style="display:block; font-size:.9rem; margin-bottom:.25rem;">Email</label>
      <input type="email" wire:model.defer="email" class="form-control" style="width:100%; border:1px solid #d1d5db; border-radius:10px; padding:.5rem .75rem;">
      @error('email') <p style="color:#be123c; font-size:.85rem; margin-top:.25rem;">{{ $message }}</p> @enderror
    </div>

    <div>
      <label style="display:block; font-size:.9rem; margin-bottom:.25rem;">Rol</label>
      <select wire:model.defer="role" class="form-select" style="width:100%; border:1px solid #d1d5db; border-radius:10px; padding:.5rem .75rem;">
        <option value="admin">Admin</option>
        <option value="vendedor">Vendedor</option>
        <option value="user">Usuario</option>
      </select>
      @error('role') <p style="color:#be123c; font-size:.85rem; margin-top:.25rem;">{{ $message }}</p> @enderror
    </div>

    <div>
      <label style="display:block; font-size:.9rem; margin-bottom:.25rem;">
        {{ $userId ? 'Nueva contraseña (opcional)' : 'Contraseña' }}
      </label>
      <input type="password" wire:model.defer="password" class="form-control" style="width:100%; border:1px solid #d1d5db; border-radius:10px; padding:.5rem .75rem;">
      @error('password') <p style="color:#be123c; font-size:.85rem; margin-top:.25rem;">{{ $message }}</p> @enderror
    </div>

    <div>
      <label style="display:block; font-size:.9rem; margin-bottom:.25rem;">Confirmar contraseña</label>
      <input type="password" wire:model.defer="password_confirmation" class="form-control" style="width:100%; border:1px solid #d1d5db; border-radius:10px; padding:.5rem .75rem;">
    </div>
  </div>

  <div style="margin-top:1rem; text-align:right;">
    <button type="submit" class="btn btn--primary">Guardar</button>
  </div>
</form>
