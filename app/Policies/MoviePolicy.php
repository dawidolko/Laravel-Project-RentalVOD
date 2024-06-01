<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;

class MoviePolicy
{
    public function update(User $user, Movie $movie)
    {
        return $user->role_id === 1;
    }

    public function delete(User $user, Movie $movie)
    {
        return $user->role_id === 1;
    }

    public function create(User $user)
    {
        return $user->role_id === 1;
    }

    public function view(User $user, Movie $movie)
    {
        return $user->role_id === 1;
    }
}
