<?php

namespace App\Providers;

use App\Models\Movie;
use App\Models\User;
use App\Policies\CartPolicy;
use App\Policies\MoviePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Movie::class => MoviePolicy::class,
        User::class => UserPolicy::class,
        User::class => CartPolicy::class,
    ];
    
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin', function ($user) {
            return $user->role_id == 1;
        });

        Gate::define('access-cart', [CartPolicy::class, 'access']);
    }
}
