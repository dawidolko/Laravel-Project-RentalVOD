<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;

class ShareDataToViews
{
    public function handle(Request $request, Closure $next)
    {
        view()->share('categories', Category::all());
        return $next($request);
    }
}
