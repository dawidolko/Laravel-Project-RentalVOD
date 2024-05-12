<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Loan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index() {
        return view('admin.index');
    }

    public function users() {
        $users = User::paginate(10);
        return view('admin.editUsers', compact('users'));
    }

    public function movies() {
        $movies = Movie::paginate(10); 
        return view('admin.editMovies', compact('movies'));
    }    
    
    public function updateMovie(Request $request, $id) {
        // $this->authorize('update', $movie);
        $movie = Movie::findOrFail($id);
    
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'director' => 'required|string|max:255',
            'release_year' => 'required|integer|min:0',
              'duration' => 'required|string|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'rate' => 'required|numeric|min:0',
            'video_path' => 'required|string',
            'price_day' => 'required|numeric|min:0',
            'available' => 'required|in:dostępny,niedostępny',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('img_path')) {
            Storage::delete($movie->img_path);
            $imagePath = $request->file('img_path')->store('public/img');
            $data['img_path'] = 'img/'.basename($imagePath);
        }
    
        $category = Category::where('id', $request->category_id)->first();
    
        if (!$category) {
            $category = new Category();
            $category->id = $request->category_id;
            $category->save();
        }
    
        $movie->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'category_id' => $category->id,
            'director' => $data['director'],
            'release_year' => $data['release_year'],
            'duration' => $data['duration'],
            'rate' => $data['rate'],
            'video_path' => $data['video_path'],
            'price_day' => $data['price_day'],
            'available' => $data['available'],
            'img_path' => $data['img_path'] ?? $movie->img_path,
        ]);
    
        return redirect()->route('admin.movies')->with('success', 'Film został zaktualizowany.');
    }     
    
    public function addMovie(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'director' => 'required|string|max:255',
            'release_year' => 'required|integer|min:0',
            'duration' => 'required|string|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'rate' => 'required|numeric|min:0',
            'video_path' => 'required|string',
            'price_day' => 'required|numeric|min:0',
            'available' => 'required|in:dostępny,niedostępny',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('public/img');
            $imagePath = $request->file('img_path')->store('img');
            $data['img_path'] = 'img/'.basename($imagePath);
        } else {
            $imagePath = 'default.jpg'; 
        }

        $category = Category::where('id', $request->category_id)->first();
    
        if (!$category) {
            $category = new Category();
            $category->id = $request->category_id;
            $category->save();
        }
    
        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->category_id = $category->id;
        $movie->director = $request->director;
        $movie->release_year = $request->release_year;
        $movie->duration = $request->duration;
        $movie->rate = $request->rate;
        $movie->video_path = $request->video_path;
        $movie->price_day = $request->price_day;
        $movie->available = $request->available;
        $movie->img_path = $imagePath;
    
        $movie->save();
    
        return redirect()->route('admin.movies')->with('success', 'Film został dodany pomyślnie.');
    }    

    public function deleteMovie($id) {
        Movie::destroy($id);
        return redirect()->route('admin.movies')->with('success', 'Film został usunięty.');
    }

    public function editUser($id) {
        $user = User::findOrFail($id);
        return view('admin.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id) {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $id,
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'address' => 'required|string|max:255',
        ]);
    
        $user = User::findOrFail($id);
        $user->update($validatedData);
    
        if ($request->has('admin')) {
            $user->role_id = 1; 
        } else {
            $user->role_id = 2;
        }
        $user->save();
    
        return redirect()->route('admin.users')->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }
    

    public function deleteUser($id) {
        // $this->authorize('delete', $user);
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

    public function addCategory(Request $request) {
        $request->validate([
            'genre' => 'required|string|max:255|unique:categories,species',
        ]);

        $category = new Category();
        $category->species = $request->genre;
        $category->save();

        return redirect()->route('admin.movies')->with('success', 'Kategoria została dodana pomyślnie.');
    }
}
