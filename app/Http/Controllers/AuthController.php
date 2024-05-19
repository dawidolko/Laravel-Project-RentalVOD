<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

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
    
        Auth::login($user);
        return redirect()->route('home');
    }
}
