<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MovieService;

class HomeController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $movies = Movie::where('available', 'dostępny')
                       ->inRandomOrder()
                       ->limit(6)
                       ->with('category')
                       ->get();

        foreach ($movies as $movie) {
            $promoPrice = $this->movieService->calculateDynamicPrice($movie);
            $movie->old_price = $promoPrice;
            $movie->save();
        }

        return view('home', compact('movies'));  
    }

    public function regulamin()
    {
        return view('regulamin'); 
    }
}
