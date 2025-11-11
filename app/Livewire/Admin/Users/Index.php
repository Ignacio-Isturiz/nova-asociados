<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    // Filtros / orden
    #[Url(as: 'q')]   public string $search = '';
    #[Url(as: 'sort')] public string $sortField = 'created_at';
    #[Url(as: 'dir')]  public string $sortDirection = 'desc';

    // Modal crear/editar
    public bool $showForm = false;
    public ?int $editingId = null;

    // Modal eliminar
    public bool $confirmingDelete = false;
    public ?int $deleteId = null;

    // Cerrar modal al guardar desde el form
    #[On('user-saved')]
    public function handleUserSaved(): void
    {
        $this->closeForm();
    }

    public function updatingSearch() { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function create(): void
    {
        $this->authorize('create', User::class);
        $this->editingId = null;
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $this->editingId = $id;
        $this->showForm = true;
    }

    // Abrir modal de confirmación
    public function confirmDelete(int $id): void
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    // Confirmar eliminación
    public function deleteConfirmed(): void
    {
        if (!$this->deleteId) return;

        $user = User::findOrFail($this->deleteId);
        $this->authorize('delete', $user);
        $user->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Usuario eliminado.');
        $this->resetPage();
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->editingId = null;
    }

    public function render()
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()
            ->when($this->search, fn ($q) =>
                $q->where(function ($w) {
                    $w->where('name', 'like', "%{$this->search}%")
                     ->orWhere('email','like', "%{$this->search}%")
                     ->orWhere('role', 'like', "%{$this->search}%");
                })
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.users.index', compact('users'));
    }
}
