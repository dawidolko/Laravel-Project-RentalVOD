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
        $this->movieService->updatePrices(); // Wywołanie metody aktualizacji cen

        $movies = Movie::where('available', 'dostępny')
                       ->inRandomOrder()
                       ->limit(6)
                       ->with('category')
                       ->get();

        foreach ($movies as $movie) {
            // $movie->current_price = $this->movieService->getPriceWithSuperPromotion($movie);
            $promoPrice = $this->movieService->calculatePromoPrice($movie->price_day);
        }

        $topMovies = Movie::select('movies.id', 'movies.title', 'movies.img_path', 'movies.available', 'movies.description', 'movies.category_id', 'movies.director', 'movies.release_year', 'movies.duration', 'movies.rate', 'movies.video_path', 'movies.price_day', \DB::raw('count(loan_movie.id) as loans_count'))
            ->join('loan_movie', 'loan_movie.movie_id', '=', 'movies.id')
            ->groupBy('movies.id', 'movies.title', 'movies.img_path', 'movies.available', 'movies.description', 'movies.category_id', 'movies.director', 'movies.release_year', 'movies.duration', 'movies.rate', 'movies.video_path', 'movies.price_day')
            ->orderByDesc('loans_count')
            ->limit(10)
            ->get();

        foreach ($topMovies as $movie) {
            // $movie->current_price = $this->movieService->getPriceWithSuperPromotion($movie);
            $promoPrice = $this->movieService->calculatePromoPrice($movie->price_day);
        }

        return view('home', compact('movies', 'topMovies', 'promoPrice'));  
    }

    public function regulamin()
    {
        return view('regulamin'); 
    }
}
