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
            return redirect()->route('home'); 
        }
        return view('auth.login');
    }


    public function authenticate(Request $request) 
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
        ]);

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
    
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:100|alpha',
            'last_name' => 'required|string|max:100|alpha',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/', 
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/' 
            ],
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100'
        ], [
            'first_name.required' => 'Imię jest wymagane.',
            'last_name.required' => 'Nazwisko jest wymagane.',
            'email.required' => 'Adres email jest wymagany.',
            'email.email' => 'Proszę podać prawidłowy adres email.',
            'email.unique' => 'Podany adres email jest już używany.',
            'password.required' => 'Hasło jest wymagane.',
            'password.confirmed' => 'Hasła nie są identyczne.',
            'password.min' => 'Hasło musi zawierać co najmniej 8 znaków.',
            'password.regex' => 'Hasło musi zawierać małe i duże litery, cyfry oraz znak specjalny.',
            'address.required' => 'Adres jest wymagany.',
            'city.required' => 'Miasto jest wymagane.'
        ]);
    
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'role_id' => 2 // Przypisuje nowym użytkownikom rolę klienta, ponieważ rola nr.1 to admin.
        ]);
    
        Auth::login($user);
        return redirect()->route('home');
    }
}
