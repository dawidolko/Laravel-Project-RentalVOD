<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Movies;
use Illuminate\Http\Request;


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
        $categories = Category::all();  
        $movies = Movie::where('available', 'dostępny')
                       ->inRandomOrder()
                       ->limit(6)
                       ->with('category')
                       ->get();
        return view('home', compact('categories', 'movies'));  
    }
    public function regulamin()
    {
        $categories = Category::all(); 
        return view('regulamin', compact('categories')); 
    }
}
