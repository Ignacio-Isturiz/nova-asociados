<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cita;

class CitaPolicy
{
    public function before(User $user, string $ability)
    {
        if ($user->role === 'admin') return true; // admin todo
    }

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Cita $cita): bool { return $user->id === $cita->user_id; }
    public function create(User $user): bool { return true; } // ← NECESARIO
    public function update(User $user, Cita $cita): bool { return $user->id === $cita->user_id; }
    public function delete(User $user, Cita $cita): bool { return $user->id === $cita->user_id; }
}
