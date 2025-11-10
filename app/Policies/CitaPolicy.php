<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cita;

class CitaPolicy
{
    // Solo el dueño puede modificar
    public function update(User $user, Cita $cita)
    {
        return $user->id === $cita->user_id;
    }

    // El dueño o el admin pueden cancelar
    public function cancel(User $user, Cita $cita)
    {
        return $user->id === $cita->user_id || $user->role === 'admin';
    }
}
