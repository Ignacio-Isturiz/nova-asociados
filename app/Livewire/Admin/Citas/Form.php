<?php

namespace App\Livewire\Admin\Citas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Cita;
use App\Models\User;
use App\Models\Proyecto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

#[Layout('layouts.admin')]
class Form extends Component
{
    use AuthorizesRequests;

    public ?Cita $cita = null;
    public bool $isEdit = false;

    public ?int $user_id = null;
    public ?int $proyecto_id = null;
    public string $fecha = '';
    public string $hora = '';
    public string $estado = 'pendiente';
    public ?string $telefono_contacto = null;
    public ?string $notas = null;

    public $users = [];
    public $proyectos = [];

    public function mount(?Cita $cita = null)
    {
        if ($cita && $cita->exists) {
            $this->authorize('update', $cita);
            $this->cita = $cita;
            $this->isEdit = true;
            $this->fill($cita->only([
                'user_id','proyecto_id','titulo','fecha','hora','estado','telefono_contacto','notas'
            ]));
        } else {
            $this->authorize('create', Cita::class);
        }

        $this->users = User::select('id','name')->orderBy('name')->get();
        $this->proyectos = Proyecto::select('id','nombre')->orderBy('nombre')->get();
    }

    public function save()
    {
        $data = $this->validate([
            'user_id' => ['required','exists:users,id'],
            'proyecto_id' => ['nullable','exists:proyectos,id'],
            'fecha'  => ['required','date'],
            'hora'   => ['required'],
            'estado' => ['required', Rule::in(['pendiente','confirmada','cancelada'])],
            'telefono_contacto' => ['nullable','string','max:50'],
            'notas'  => ['nullable','string','max:500'],
        ]);

        $data['nombre_usuario'] = $data['nombre_usuario'] ?? optional(User::find($data['user_id']))->name;

        if ($this->cita) {
            $this->cita->update($data);
            session()->flash('success','Cita actualizada.');
        } else {
            $this->cita = Cita::create($data);
            session()->flash('success','Cita creada.');
        }

        return redirect()->route('admin.citas.index');
    }

    public function render()
    {
        return view('livewire.admin.citas.form');
    }
}
