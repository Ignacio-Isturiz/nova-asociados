<?php

namespace App\Livewire\Admin\Citas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Cita;
use App\Models\User;
use App\Models\Proyecto;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?int $citaId = null;
    public ?Cita $cita = null;
    public bool $isEdit = false;

    public $users = [];
    public $proyectos = [];

    public $user_id, $proyecto_id, $fecha, $hora, $estado = 'pendiente', $notas;

    // Recibe el parámetro de ruta {citaId}
    public function mount($citaId = null)
    {
        $this->citaId = $citaId;

        $this->users = User::select('id','name')->orderBy('name')->get();
        $this->proyectos = Proyecto::select('id','nombre')->orderBy('nombre')->get();

        if ($this->citaId) {
            $this->cita   = Cita::findOrFail($this->citaId);
            $this->isEdit = true;

            $this->user_id     = $this->cita->user_id;
            $this->proyecto_id = $this->cita->proyecto_id;
            $this->fecha       = optional($this->cita->fecha)->format('Y-m-d');
            $this->hora        = $this->cita->hora;
            $this->estado      = $this->cita->estado;
            $this->notas       = $this->cita->notas;
        } else {
            $this->isEdit = false;
            $this->estado = 'pendiente';
        }
    }

    protected function rules()
    {
        return [
            'user_id'     => ['required','exists:users,id'],
            'proyecto_id' => ['required','exists:proyectos,id'],
            'fecha'       => ['required','date','after_or_equal:today'],
            'hora'        => ['required','date_format:H:i'],
            'estado'      => ['required','in:pendiente,confirmada,cancelada'],
            'notas'       => ['nullable','string','max:2000'],
        ];
    }

    public function save()
    {
        $data = $this->validate();

        // Evitar choque proyecto-fecha-hora
        $exists = Cita::where('proyecto_id',$data['proyecto_id'])
            ->whereDate('fecha',$data['fecha'])
            ->where('hora',$data['hora'])
            ->when($this->isEdit && $this->cita, fn($q)=>$q->where('id','!=',$this->cita->id))
            ->exists();

        if ($exists) {
            session()->flash('error','Ya existe una cita en ese proyecto, fecha y hora.');
            return;
        }

        if ($this->isEdit && $this->cita) {
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
