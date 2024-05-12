<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Movie;
use DateTime;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\StatusLoan;


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
    
        $userHasAccess = $movie->loans->contains(function ($loan) {
            return $loan->status !== StatusLoan::ZWROCONE;
        });
    
        if ($userHasAccess) {
            return view('loans.show', compact('movie'));
        } else {
            return back()->with('error', 'Nie masz dostępu do tego filmu lub status wypożyczenia to "zwrócone".');
        }
    }
    

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
            'address' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s,.-]+$/',
        ], [
            'address.required' => 'Adres jest wymagany.',
            'address.regex' => 'Adres może zawierać tylko litery, cyfry, spacje oraz znaki ,.-',
        ]);
    
        $user = Auth::user();
        if ($user) {
            $user->address = $request->address;
            $user->save();
            return back()->with('success', 'Dane zostały zaktualizowane.');
        }
    
        return back()->with('error', 'Nie udało się zaktualizować danych.');
    }
    

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        ], [
            'new_password.min' => 'Hasło musi zawierać co najmniej 8 znaków.',
            'new_password.confirmed' => 'Potwierdzenie hasła nie zgadza się.',
            'new_password.regex' => 'Hasło musi zawierać co najmniej jedną wielką literę, jedną małą literę, jedną cyfrę i jeden znak specjalny.'
        ]);
    
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Obecne hasło jest nieprawidłowe']);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('success', 'Hasło zostało zmienione.');
    }
    

    public function updateAvatar(Request $request)
    {
        $validatedData = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Limit 2MB
        ], [
            'avatar.required' => 'Musisz wybrać plik.',
            'avatar.image' => 'Plik musi być obrazem.',
            'avatar.mimes' => 'Dopuszczalne są tylko pliki w formatach: jpeg, png, jpg, gif, svg.',
            'avatar.max' => 'Maksymalny rozmiar pliku to 2048 kB.'
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
            $loan->status = StatusLoan::WYNAJEM;
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
