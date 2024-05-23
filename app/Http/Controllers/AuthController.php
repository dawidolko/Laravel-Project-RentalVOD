<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ReferralCode;
use App\Models\LoyaltyPoint;
use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            logger('Użytkownik jest już zalogowany.');
            return redirect()->route('home'); 
        }
        return view('auth.login');
    }

    public function authenticate(AuthenticateRequest $request) 
    {
        $credentials = $request->validated();

        $remember = $request->has('remember'); 

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        } else {
            return back()->withErrors(['email' => 'Nieprawidłowe dane logowania.'])->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'address' => $validatedData['address'],
            'role_id' => 2 // Przypisuje nowym użytkownikom rolę klienta, ponieważ rola nr.1 to admin.
        ]);

        ReferralCode::create([
            'user_id' => $user->id,
            'code' => substr(md5($user->id . microtime()), 0, 8) 
        ]);

        LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => 0
        ]);

        if ($request->filled('referral_code')) {
            $referrer = ReferralCode::where('code', $request->input('referral_code'))->first();
            if ($referrer) {
                $referrer->user->loyaltyPoints()->increment('points', 20);

                // Dodanie komunikatu o przyroście punktów do sesji
                Session::flash('points_message', 'Dzieki użyciu kodu osoba której jest kod polecający dostała 20 punktów!');
            }
        }

        Auth::login($user);
        return redirect()->route('home');
    }
}
