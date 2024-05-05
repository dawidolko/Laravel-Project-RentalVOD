<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Loan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Główna strona panelu admina
    public function index() {
        return view('admin.index'); // Dashboard dla admina
    }

    // Wyświetla listę wszystkich użytkowników
    public function users() {
        $users = User::all();
        return view('admin.editUsers', compact('users'));
    }

    // Wyświetla listę wszystkich filmów
    public function movies() {
        $movies = Movie::all();
        return view('admin.editMovies', compact('movies'));
    }

    // Wyświetla formularz edycji konkretnego filmu
    public function editMovie($id) {
        $movie = Movie::findOrFail($id);
        return view('admin.editMovie', compact('movie')); // Upewnij się, że istnieje widok `editMovie`
    }

    // Aktualizuje dane filmu po edycji
    public function updateMovie(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price_day' => 'required|numeric',
        ]);

        $movie = Movie::findOrFail($id);
        $movie->update($request->all());
        return redirect()->route('admin.editMovies')->with('success', 'Film został zaktualizowany.');
    }

    // Usuwa film
    public function deleteMovie($id) {
        Movie::destroy($id);
        return redirect()->route('admin.editMovies')->with('success', 'Film został usunięty.');
    }

    // Wyświetla formularz edycji konkretnego użytkownika
    public function editUser($id) {
        $user = User::findOrFail($id);
        return view('admin.editUser', compact('user')); // Upewnij się, że istnieje widok `editUser`
    }

    // Aktualizuje dane użytkownika po edycji
    public function updateUser(Request $request, $id) {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.editUsers')->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }

    // Usuwa użytkownika
    public function deleteUser($id) {
        User::destroy($id);
        return redirect()->route('admin.editUsers')->with('success', 'Użytkownik został usunięty.');
    }

    // Wyświetla listę wszystkich zamówień
    public function orders() {
        $orders = Loan::with('user', 'movies')->get(); // Usuwam 'movies.movie', ponieważ movies już zwróci kolekcję filmów
        return view('admin.orders', compact('orders'));
    }
}

