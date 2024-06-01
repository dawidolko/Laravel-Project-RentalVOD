<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $user, User $model)
    {
        return $user->role_id === 1;
    }

    public function delete(User $user, User $model)
    {
        return $user->role_id === 1;
    }
}
