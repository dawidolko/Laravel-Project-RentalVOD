<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Pole email jest wymagane.',
            'email.email' => 'Pole email musi być poprawnym adresem email.',
            'email.max' => 'Pole email nie może przekraczać 255 znaków.',
            'password.required' => 'Pole hasło jest wymagane.',
            'password.string' => 'Pole hasło musi być ciągiem znaków.',
            'password.min' => 'Pole hasło musi mieć co najmniej 8 znaków.',
            'password.regex' => 'Pole hasło musi zawierać co najmniej jedną małą literę, jedną wielką literę, jedną cyfrę i jeden znak specjalny.',
        ];
    }
}
