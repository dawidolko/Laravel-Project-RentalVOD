<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\PremiumMovie;
use App\Services\MovieService;
use Auth;
use File;
use Illuminate\Http\Request;
use Response;

class MoviesController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }
    
    public function index(Request $request)
    { 
        $query = Movie::with('category');

        if ($request->has('species') && $request->species != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('species', $request->species);
            });
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        switch ($request->sort_by) {
            case 'release1':
                $query->orderBy('release_year', 'asc');
                break;
            case 'release2':
                $query->orderBy('release_year', 'desc');
                break;
            case 'rate1':
                $query->orderBy('rate', 'asc');
                break;
            case 'rate2':
                $query->orderBy('rate', 'desc');
                break;
            case 'length1':
                $query->orderBy('duration', 'desc');
                break;
            case 'length2':
                $query->orderBy('duration', 'asc');
                break;
        }

        $movies = $query->paginate(6);

        foreach ($movies as $movie) {
            $promoPrice = $this->movieService->calculateDynamicPrice($movie);
            $movie->old_price = $promoPrice;
            $movie->save();
        }

        return view('movies.index', compact('movies'));  
    }

    public function show($id)
    {
        $movie = Movie::with(['category', 'opinions.user'])->where('id', $id)->firstOrFail();
        $promoPrice = $this->movieService->calculateDynamicPrice($movie);

        $movie->old_price = $promoPrice;
        $movie->save();

        return view('movies.show', compact('movie', 'promoPrice'));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        $movies = Movie::where('available', 'dostępny')
                    ->where(function($queryBuilder) use ($query) {
                        $queryBuilder->where('title', 'LIKE', '%' . $query . '%')
                                        ->orWhere('director', 'LIKE', '%' . $query . '%')
                                        ->orWhere('description', 'LIKE', '%' . $query . '%')
                                        ->orWhereHas('category', function($queryBuilder) use ($query) {
                                            $queryBuilder->where('species', 'LIKE', '%' . $query . '%');
                                        });
                    })
                    ->paginate(10); 
        return view('movies.index', compact('movies'));
    }

    public function image($id)
    {
        $movie = Movie::findOrFail($id);
        $path = storage_path('app/public/' . $movie->img_path);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
