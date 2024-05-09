<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $model)
    {
        return $user->role_id == 1;
    }

    public function delete(User $user, User $model)
    {
        return $user->role_id == 1;
    }

    public function viewAny(User $user)
    {
        return $user->role_id == 1;
    }

    public function view(User $user, User $model)
    {
        return $user->id === $model->id || $user->role_id == 1;
    }
}
