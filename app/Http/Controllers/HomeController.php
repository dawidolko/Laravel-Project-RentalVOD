<?php

namespace App\Http\Controllers;

use App\Models\Movie;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Movie::where('available', 'dostępny')
                       ->inRandomOrder()
                       ->limit(6)
                       ->with('category')
                       ->get();
        return view('home', compact('movies'));  
    }
    public function regulamin()
    {
        return view('regulamin'); 
    }
}
