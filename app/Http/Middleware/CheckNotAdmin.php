<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckNotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return redirect('/')->withErrors(['error' => 'Administratorzy nie mają dostępu do koszyka.']);
        }

        return $next($request);
    }
}
