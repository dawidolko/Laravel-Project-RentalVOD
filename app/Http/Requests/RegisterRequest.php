<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
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
        ];
    }

    public function messages()
    {
        return [
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
        ];
    }
}
