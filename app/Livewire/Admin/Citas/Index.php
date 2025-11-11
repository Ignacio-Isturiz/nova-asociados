<?php

namespace App\Livewire\Admin\Citas;

use App\Models\Cita;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as:'q')]   public string $search = '';
    #[Url(as:'sort')] public string $sortField = 'fecha';
    #[Url(as:'dir')]  public string $sortDirection = 'desc';

    // 🔽 NUEVO: estado del modal de eliminación
    public bool $confirmingDelete = false;
    public ?int $deleteId = null;

    public function updatingSearch(){ $this->resetPage(); }

    public function sortBy(string $field): void
    {
        $allowed = ['fecha','hora','titulo','estado','created_at'];
        $field = in_array($field, $allowed, true) ? $field : 'fecha';

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // 🔽 NUEVO: abrir/cerrar modal
    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function deleteConfirmed(): void
    {
        if (!$this->deleteId) return;

        $cita = Cita::findOrFail($this->deleteId);
        $this->authorize('delete', $cita);

        $cita->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Cita eliminada.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize('viewAny', Cita::class);

        $s = trim($this->search);
        $citas = Cita::query()
            ->with(['usuario','proyecto'])
            ->when($s !== '', function ($q) use ($s) {
                $like = "%{$s}%";
                $q->where(function ($w) use ($like) {
                    $w ->orWhere('estado','like',$like)
                      ->orWhere('notas','like',$like)
                      ->orWhere('nombre_usuario','like',$like)
                      ->orWhereHas('usuario', fn($u)=>$u->where('name','like',$like))
                      ->orWhereHas('proyecto', fn($p)=>$p->where('nombre','like',$like));
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.citas.index', compact('citas'));
    }
}
