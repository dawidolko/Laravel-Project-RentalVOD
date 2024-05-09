<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Movie' => 'App\Policies\MoviePolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Loan' => 'App\Policies\LoanPolicy',
    ];
    

    /**
     * Register any authentication and authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin', function ($user) {
            return $user->role_id == 1;
        });
    }
}
