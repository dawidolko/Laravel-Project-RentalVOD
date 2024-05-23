<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasLoyaltyPoints
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->loyaltyPoints) {
            Auth::user()->loyaltyPoints()->create(['points' => 0]);
        }

        return $next($request);
    }
}
