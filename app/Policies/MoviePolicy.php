<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Movie $movie)
    {
        return $user->role_id == 1;
    }

    public function delete(User $user, Movie $movie)
    {
        return $user->role_id == 1;
    }
}
