<?php

namespace App\Policies;

use App\Models\Movies;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CountryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Movies $movies): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    // public function update(User $user, Country $country): bool
    // {
    //     return $user->country_id === $country->id;
    //     // return $user->isAdmin();
    // }

    /**
     * Determine whether the user can delete the model.
     */
    // public function delete(User $user, Country $country): bool
    // {
    //     return true;
    // }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Country $country): bool
    // {
    //     return true;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Country $country): bool
    // {
    //     return true;
    // }
}
