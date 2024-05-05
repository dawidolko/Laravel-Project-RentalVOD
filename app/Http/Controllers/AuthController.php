<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            logger('Użytkownik jest już zalogowany.');
            return redirect()->route('home');  // Upewnij się, że trasa 'home' istnieje
        }
        logger('Zwracam widok logowania.');
        return view('auth.login');
    }


    public function authenticate(Request $request) // do poprawy zapamietywanie.
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember'); 

        if (Auth::attempt($credentials, $remember)) { 
            $request->session()->regenerate();
            return redirect()->intended('home'); 
        }

        return back()->withErrors(['email' => 'Nieprawidłowe dane logowania.'])->onlyInput('email');
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
    
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);
    
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'role_id' => 2 // Przypisuje nowym użytkownikom rolę klienta
        ]);
    
        Auth::login($user);
        return redirect()->route('home'); 
    }
    

}
