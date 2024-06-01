<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\AddMovieRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\UpdateRuleRequest;
use App\Http\Requests\SetSuperPromoPriceRequest;
use App\Models\User;
use App\Models\Movie;
use App\Models\Loan;
use App\Models\Category;
use App\Services\MovieService;
use App\Services\RecommendationService;
use Gate;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    protected $recommendationService;
    protected $movieService;

    public function __construct(RecommendationService $recommendationService, MovieService $movieService)
    {
        $this->recommendationService = $recommendationService;
        $this->movieService = $movieService;
    }

    public function settings()
    {
        $currentRule = $this->recommendationService->getRule();
        list($currentRate, $currentRecommendationsCount) = $this->recommendationService->parseRule($currentRule);
        $promotionsEnabled = $this->movieService->arePromotionsEnabled();

        return view('admin.settings', compact('currentRate', 'currentRecommendationsCount', 'promotionsEnabled'));
    }

    public function updateRule(UpdateRuleRequest $request)
    {
        $rate = $request->input('rate');
        $recommendationsCount = $request->input('recommendations_count');
        $this->recommendationService->setRule($rate, $recommendationsCount);

        return back()->with('success', 'Zasada rekomendacji została zaktualizowana.');
    }

    public function togglePromotions()
    {
        $this->movieService->togglePromotions();

        return back()->with('success', 'Promocje zostały zaktualizowane.');
    }

    public function index() {
        return view('admin.index');
    }

    public function users() {
        $users = User::paginate(10);
        return view('admin.editUsers', compact('users'));
    }

    public function movies()
    {
        $movies = Movie::paginate(10);

        return view('admin.editMovies', compact('movies'));
    }

    public function showUsers()
    {
        $users = User::with('loans')->paginate(10);

        return view('admin.users', compact('users'));
    }
    
    public function updateMovie(UpdateMovieRequest $request, $id, Movie $movie)
    {
        Gate::authorize('update', $movie);

        $movie = Movie::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('img_path')) {
            Storage::delete($movie->img_path);
            $imagePath = $request->file('img_path')->store('public/img'); 
            $imagePath = $request->file('img_path')->store('img'); 
            $data['img_path'] = 'img/' . basename($imagePath);
        }

        $movie->update($data);

        return redirect()->route('admin.movies')->with('success', 'Film został zaktualizowany.');
    }    
    
    public function addMovie(AddMovieRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('public/img'); 
            $imagePath = $request->file('img_path')->store('img'); 
            $data['img_path'] = 'img/' . basename($imagePath);
        } else {
            $data['img_path'] = 'default.jpg';
        }

        Movie::create($data);

        return redirect()->route('admin.movies')->with('success', 'Film został dodany pomyślnie.');
    }

    public function deleteMovie($id, Movie $movie)
    {
        Gate::authorize('delete', $movie);

        Movie::destroy($id);
        return redirect()->route('admin.movies')->with('success', 'Film został usunięty.');
    }

    public function editUser($id) {
        $user = User::findOrFail($id);
        return view('admin.editUser', compact('user'));
    }

    public function updateUser(UpdateUserRequest $request, $id, User $user) {
        Gate::authorize('update', $user);
        $validatedData = $request->validated();
        $user = User::findOrFail($id);
        $user->update($validatedData);

        $user->role_id = $request->has('admin') ? 1 : 2;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }

    public function deleteUser($id, User $user) {
        Gate::authorize('delete', $user);

        try {
            User::destroy($id);
            return redirect()->route('admin.users')->with('success', 'Użytkownik został usunięty.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('error', 'Nie udało się usunąć użytkownika.');
        }
    }
    
    public function userOrders($id) {
        $user = User::with('loans.movies')->findOrFail($id);
        return view('admin.userOrders', compact('user'));
    }

    public function orders() {
        $loans = Loan::with(['user', 'movies'])->paginate(10);
        return view('admin.orders', compact('loans'));
    }

    public function addCategory(AddCategoryRequest $request) {
        $category = new Category();
        $category->species = $request->genre;
        $category->save();

        return redirect()->route('admin.movies')->with('success', 'Kategoria została dodana pomyślnie.');
    }

    public function setSuperPromoPrice(SetSuperPromoPriceRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $movie->old_price = $movie->price_day;
        $movie->price_day = $request->super_promo_price;
        $movie->super_promo_price = $request->super_promo_price;
        $movie->last_promo_update = now();
        $movie->save();

        return redirect()->route('admin.movies')->with('success', 'Super promocja została ustawiona.');
    }
}
