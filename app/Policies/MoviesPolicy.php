<?php

namespace App\Policies;

use App\Models\Movies;
use App\Models\User;
use Illuminate\Auth\Access\Response;

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
