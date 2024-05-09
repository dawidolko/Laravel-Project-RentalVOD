<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Loan;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoanPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Loan $loan)
    {
        return $user->role_id == 1;
    }

    public function delete(User $user, Loan $loan)
    {
        return $user->role_id == 1;
    }

    public function viewAny(User $user)
    {
        return $user->role_id == 1;
    }

    public function view(User $user, Loan $loan)
    {
        return $user->id === $loan->user_id || $user->role_id == 1;
    }
}
