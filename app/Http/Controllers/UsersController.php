<?php

namespace App\Http\Controllers;

use App\Enums\FriendshipStatus;
use App\Models\Loan;
use App\Models\Movie;
use App\Models\PremiumMovie;
use DateTime;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Enums\StatusLoan;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Friendship;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function showProfile()
    {
        $user_id = Auth::id();
        $loans = Loan::with('movies')->where('user_id', $user_id)->paginate(3);
        $referralCode = Auth::user()->referralCode->code ?? 'Brak';
    
        $expensesData = Loan::where('user_id', $user_id)
            ->where('start', '>=', now()->subMonth())
            ->selectRaw('DATE(start) as date, SUM(price) as amount')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'amount' => $item->amount
                ];
            });
    
        $friendRequests = Friendship::where('friend_id', $user_id)->where('status', FriendshipStatus::Pending)->get();
        
        $friends = Friendship::where(function($query) use ($user_id) {
            $query->where('user_id', $user_id)
                  ->orWhere('friend_id', $user_id);
        })->where('status', FriendshipStatus::Accepted)->get()->map(function ($friendship) use ($user_id) {
            return $friendship->user_id == $user_id ? $friendship->friend : $friendship->user;
        })->unique('id');
    
        $pendingRequests = Friendship::where('user_id', $user_id)->where('status', FriendshipStatus::Pending)->get();
        $recommendations = Recommendation::where('friend_id', $user_id)->get();
    
        return view('user.profile', compact('loans', 'referralCode', 'expensesData', 'friendRequests', 'friends', 'pendingRequests', 'recommendations'));
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

    public function showPremiumMovie($movie_id)
    {
        $user_id = Auth::id();
        $premiumMovie = PremiumMovie::where('movie_id', $movie_id)
                                    ->where('user_id', $user_id)
                                    ->first();

        if ($premiumMovie) {
            $movie = Movie::findOrFail($movie_id);
            return view('loans.premium', compact('movie'));
        } else {
            return back()->with('error', 'Nie masz dostępu do wersji premium tego filmu.');
        }
    }

    public function showCart()
    {
        if (Auth::user()->role_id == 1) {
            return redirect('/')->withErrors(['error' => 'Administratorzy nie mają dostępu do koszyka.']);
        }
    
        return view('user.cart');
    }     

    public function showSettings()
    {
        return view('user.settings');
    }

    public function update(UpdateAddressRequest $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->address = $request->validated()['address'];
            $user->save();
            return back()->with('success', 'Dane zostały zaktualizowane.');
        }

        return back()->with('error', 'Nie udało się zaktualizować danych.');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Obecne hasło jest nieprawidłowe']);
        }

        $user->password = Hash::make($request->validated()['new_password']);
        $user->save();
        return back()->with('success', 'Hasło zostało zmienione.');
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $user = Auth::user();
        $avatarPath = $request->file('avatar')->store('avatars', 'public'); 
        $user->avatar = 'storage/' . $avatarPath;
        $user->save();

        return back()->with('success', 'Awatar został zaktualizowany.');
    }

    public function addToCart(Request $request, $movie_id)
    {
        $user = Auth::user();
        if ($user->role_id == 1) {
            return redirect('/')->withErrors(['error' => 'Administratorzy nie mogą dodawać rzeczy do koszyka.']);
        }
    
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

        return back()->with('success', 'Produkt został usunięty z koszyka.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Koszyk jest pusty.');
        }
    
        $user = Auth::user();
        $loyaltyPoints = $user->loyaltyPoints->points ?? 0;
    
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
            $loan->user_id = $user->id;
            $loan->start = $startDate->format('Y-m-d');
            $loan->end = $endDate->format('Y-m-d');
            $diff = $endDate->diff($startDate)->days + 1;
            
            $moviePrice = $details['price'];
            if ($loyaltyPoints >= 50) {
                $moviePrice = 0;
                $loyaltyPoints -= 50; 
                $user->loyaltyPoints->points = $loyaltyPoints;
                $user->loyaltyPoints->save();
            }
    
            $loan->price = $moviePrice * $diff;
            $loan->status = StatusLoan::WYNAJEM;
            $loan->save();
    
            $loan->movies()->attach($id);
    
            if ($moviePrice > 0) {
                $pointsEarned = 10; 
                $userLoyaltyPoints = $user->loyaltyPoints()->firstOrCreate(['user_id' => $user->id]);
                $userLoyaltyPoints->points += $pointsEarned;
                $userLoyaltyPoints->save();
    
                session()->flash('points_message', "Zdobyłeś $pointsEarned punktów lojalnościowych!");
            }
        }
    
        session()->forget('cart');
        return redirect()->route('user.profile')->with('success', 'Zakup udany. Produkty zostały dodane do Twojej historii wypożyczeń.');
    }    

    public function updateCart(UpdateCartRequest $request, $movie_id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$movie_id])) {
            $validatedData = $request->validated();
            $cart[$movie_id]['start'] = $validatedData['start'];
            $cart[$movie_id]['end'] = $validatedData['end'];

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

    public function upgradeToPremium(Request $request, Movie $movie)
    {
        $user = Auth::user();
        $premiumPrice = 10;
        $loyaltyPoints = $user->loyaltyPoints->points ?? 0;

        if ($loyaltyPoints >= 50) {
            $user->loyaltyPoints->points -= 50;
            $user->loyaltyPoints->save();

            PremiumMovie::create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);

            return back()->with('success', 'Jakość premium została odblokowana za punkty.');
        } elseif ($request->has('cardNumber') && $request->has('expiryDate') && $request->has('cvv')) {

            PremiumMovie::create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);

            return back()->with('success', 'Jakość premium została odblokowana.');
        } else {
            return back()->with('error', 'Nie masz wystarczających punktów ani nie podałeś danych karty kredytowej.');
        }
    }
}
