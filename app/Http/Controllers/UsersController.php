<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Loan;
use App\Models\Movie;
use App\Models\Movies;
use DateTime;
use Exception;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class UsersController extends Controller
{
    public function showProfile()
    {
        $user_id = Auth::id();
        $loans = Loan::with('movies')->where('user_id', $user_id)->get();
        return view('user.profile', compact('loans'));
    }    

    public function showMovie($movie_id)
    {
        $user_id = Auth::id();
        $movie = Movie::with(['loans' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }])->findOrFail($movie_id);
    
        // Check if there is an active loan that is not returned
        $userHasAccess = $movie->loans->contains(function ($loan) {
            return $loan->status !== 'zwrócone';
        });
    
        if ($userHasAccess) {
            return view('loans.show', compact('movie'));
        } else {
            return back()->with('error', 'Nie masz dostępu do tego filmu lub status wypożyczenia to "zwrócone".');
        }
    }
    

    // public function showProfile()
    // {
    //     $user_id = Auth::id();
    //     $loans = Loan::with('movies')->where('user_id', $user_id)->get();
    
    //     foreach ($loans as $loan) {
    //         if (new DateTime($loan->end) < new DateTime() && $loan->status !== 'zwrócone') {
    //             $loan->status = 'zwrócone';
    //             $loan->save(); 
    //         }
    //     }
    
    //     return view('user.profile', compact('loans'));
    // }

    public function showCart()
    {
        return view('user.cart');
    }

    public function showSettings()
    {
        return view('user.settings');
    }

    public function update(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->address = $request->address;
            $user->city = $request->city;
            $user->save();
            return back()->with('success', 'Dane zostały zaktualizowane.');
        }

        return back()->with('error', 'Nie udało się zaktualizować danych.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required', 
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Obecne hasło jest nieprawidłowe'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('success', 'Hasło zostało zmienione.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = 'storage/' . $avatarPath;
        $user->save();
        return back()->with('success', 'Awatar został zaktualizowany.');
    }
    
    public function addToCart(Request $request, $movie_id)
    {
        $movie = Movie::findOrFail($movie_id);
        $cart = session()->get('cart', []);
    
        if (!isset($cart[$movie_id])) {
            $cart[$movie_id] = [
                "name" => $movie->title,
                "price" => $movie->price_day,
                "image" => asset('storage/' . $movie->img_path),
                "quantity" => 1,
                "totalCost" => $movie->price_day
            ];
        } else {
            $cart[$movie_id]['quantity'] += 1;
            $cart[$movie_id]['totalCost'] = $cart[$movie_id]['quantity'] * $movie->price_day;
        }
    
        session()->put('cart', $cart);
        return redirect()->route('cart.show')->with('success', 'Film dodany do koszyka.');
    }    

    public function removeFromCart($movie_id)
    {
        $cart = session('cart', []);
        if (isset($cart[$movie_id])) {
            unset($cart[$movie_id]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Product removed from cart.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Zakup udany. Produkty zostały dodane do Twojej historii wypożyczeń.');
        }
    
        foreach ($cart as $id => $details) {
            if (empty($details['start']) || empty($details['end'])) {
                return back()->with('error', 'Niepoprawne daty wypożyczenia dla jednego z filmów.');
            }
    
            $startDate = new DateTime($details['start']);
            $endDate = new DateTime($details['end']);
            if ($endDate < $startDate) {
                return back()->with('error', 'Data zakończenia nie może być wcześniejsza niż data rozpoczęcia.');
            }
    
            $loan = new Loan();
            $loan->user_id = Auth::id();
            $loan->start = $startDate->format('Y-m-d'); 
            $loan->end = $endDate->format('Y-m-d');
            $diff = $endDate->diff($startDate)->days + 1;
            $loan->price = $details['price'] * $diff;
            $loan->status = 'wynajem';
            $loan->save();
    
            $loan->movies()->attach($id);
        }
    
        session()->forget('cart');
        return redirect()->route('user.profile')->with('success', 'Zakup udany. Produkty zostały dodane do Twojej historii wypożyczeń.');
    }    
    public function updateCart(Request $request, $movie_id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$movie_id])) {
            $cart[$movie_id]['start'] = $request->input('start');
            $cart[$movie_id]['end'] = $request->input('end');

            $startDate = new DateTime($cart[$movie_id]['start']);
            $endDate = new DateTime($cart[$movie_id]['end']);
            if ($endDate < $startDate) {
                return back()->with('error', 'Data zakończenia nie może być wcześniejsza niż data rozpoczęcia.');
            }

            session()->put('cart', $cart);
            return back()->with('success', 'Daty wypożyczenia zaktualizowane.');
        }

        return back()->with('error', 'Film nie znaleziony w koszyku.');
    }

}
