<?php

namespace App\Livewire\Admin\Citas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Cita;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'fecha';
    public string $sortDirection = 'asc';

    public bool $confirmingDelete = false;
    public ?int $deleteId = null;

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

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
        if ($this->deleteId) {
            Cita::whereKey($this->deleteId)->delete();
            session()->flash('success', 'Cita eliminada.');
        }
        $this->cancelDelete();
    }

    public function render()
    {
        $q = Cita::query()->with(['usuario:id,name','proyecto:id,nombre']);

        if ($this->search !== '') {
            $q->where(function ($qq) {
                $qq->where('estado', 'like', "%{$this->search}%")
                  ->orWhere('hora', 'like', "%{$this->search}%")
                  ->orWhereHas('usuario', fn($u)=>$u->where('name','like',"%{$this->search}%"))
                  ->orWhereHas('proyecto', fn($p)=>$p->where('nombre','like',"%{$this->search}%"));
            });
        }

        $citas = $q->orderBy($this->sortField, $this->sortDirection)
                   ->paginate(10);

        return view('livewire.admin.citas.index', compact('citas'));
    }
}
