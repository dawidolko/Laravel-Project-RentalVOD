<?php

namespace App\Policies;

use App\Models\Movies;
use App\Models\User;

class CountryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Movies $movies): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }
}
