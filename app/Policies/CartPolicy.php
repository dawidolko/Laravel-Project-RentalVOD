<?php
namespace App\Policies;

use App\Models\User;

class CartPolicy
{
    public function access(User $user)
    {
        return $user->role_id != 1;
    }
}
