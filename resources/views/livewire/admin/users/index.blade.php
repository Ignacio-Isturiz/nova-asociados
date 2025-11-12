@section('title','Gestión de Usuarios')

<div class="container mx-auto px-4 py-6">
  <h1 class="text-3xl font-extrabold mb-4">Usuarios</h1>

  @if (session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
      {{ session('success') }}
    </div>
  @endif

  <div class="flex items-center justify-between gap-3 mb-4">
    <input
      type="text"
      wire:model.live.debounce.300ms="search"
      placeholder="Buscar por nombre, email"
      class="border rounded-lg px-3 py-2 w-full max-w-md focus:outline-none focus:ring focus:ring-indigo-200"
    />
    <button
      wire:click="create"
      class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition"
    >
      + Nuevo usuario
    </button>
  </div>

  <div class="overflow-x-auto bg-white rounded-2xl shadow">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50">
        <tr>
          <th class="text-left px-4 py-2 cursor-pointer" wire:click="sortBy('name')">
            Nombre @if($sortField==='name') <span>({{ $sortDirection }})</span>@endif
          </th>
          <th class="text-left px-4 py-2 cursor-pointer" wire:click="sortBy('email')">
            Email @if($sortField==='email') <span>({{ $sortDirection }})</span>@endif
          </th>
          <th class="text-left px-4 py-2 cursor-pointer" wire:click="sortBy('role')">
            Rol @if($sortField==='role') <span>({{ $sortDirection }})</span>@endif
          </th>
          <th class="text-left px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
          <tr class="border-t">
            <td class="px-4 py-3">{{ $u->name }}</td>
            <td class="px-4 py-3">{{ $u->email }}</td>
            <td class="px-4 py-3">
              <span @class([
                'px-2 py-1 rounded-full text-xs font-semibold',
                'bg-red-100 text-red-700'       => $u->role === 'admin',
                'bg-amber-100 text-amber-700'   => $u->role === 'vendedor',
                'bg-slate-100 text-slate-700'   => !in_array($u->role, ['admin','vendedor']),
              ])>
                {{ $u->role ?? 'user' }}
              </span>
            </td>
            <td class="px-4 py-3">
              <div class="flex gap-2">
                <button
                  wire:click="edit({{ $u->id }})"
                  class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow-sm transition"
                >Editar</button>

                <button
                  wire:click="confirmDelete({{ $u->id }})"
                  class="inline-flex items-center px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition"
                >Eliminar</button>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">Sin resultados</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $users->links() }}</div>

  {{-- Modal Crear/Editar --}}
  @if ($showForm)
    <div
      class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
      role="dialog" aria-modal="true"
      wire:keydown.escape.window="closeForm"
    >
      <div class="bg-white rounded-2xl w-full max-w-xl p-6 shadow-2xl">
        <div class="flex items-start justify-between mb-4">
          <h3 class="text-lg font-semibold">
            {{ $editingId ? 'Editar usuario' : 'Nuevo usuario' }}
          </h3>
          <button wire:click="closeForm" class="text-slate-500 hover:text-slate-700">✕</button>
        </div>

        <livewire:admin.users.form :userId="$editingId" wire:key="form-{{ $editingId ?? 'new' }}" />

        <div class="mt-4 text-right">
          <button wire:click="closeForm" class="px-4 py-2 rounded-lg border hover:bg-slate-50">
            Cerrar
          </button>
        </div>
      </div>
    </div>
  @endif

  {{-- Modal Confirmar Eliminación --}}
  @if ($confirmingDelete)
    <div
      class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
      role="dialog" aria-modal="true"
      wire:keydown.escape.window="cancelDelete"
    >
      <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
        <h3 class="text-lg font-semibold mb-2">Eliminar usuario</h3>
        <p class="text-slate-600">¿Seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.</p>

        <div class="mt-6 flex items-center justify-end gap-2">
          <button
            wire:click="cancelDelete"
            class="px-4 py-2 rounded-lg border hover:bg-slate-50"
          >Cancelar</button>

          <button
            wire:click="deleteConfirmed"
            class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition"
          >Sí, eliminar</button>
        </div>
      </div>
    </div>
  @endif
</div>
