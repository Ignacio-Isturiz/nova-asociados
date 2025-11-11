<?php

namespace App\Policies;

use App\Models\User as ModelUser;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(ModelUser $user): bool    { return $user->isAdmin(); }
    public function view(ModelUser $user, ModelUser $model): bool { return $user->isAdmin(); }
    public function create(ModelUser $user): bool     { return $user->isAdmin(); }
    public function update(ModelUser $user, ModelUser $model): bool { return $user->isAdmin(); }
    public function delete(ModelUser $user, ModelUser $model): bool
    {
        return $user->isAdmin() && $user->id !== $model->id;
    }
}
