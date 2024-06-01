<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id');

        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $userId,
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'address' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Pole imię jest wymagane.',
            'first_name.string' => 'Pole imię musi być ciągiem znaków.',
            'first_name.max' => 'Pole imię nie może przekraczać 100 znaków.',
            'last_name.required' => 'Pole nazwisko jest wymagane.',
            'last_name.string' => 'Pole nazwisko musi być ciągiem znaków.',
            'last_name.max' => 'Pole nazwisko nie może przekraczać 100 znaków.',
            'email.required' => 'Pole email jest wymagane.',
            'email.string' => 'Pole email musi być ciągiem znaków.',
            'email.email' => 'Pole email musi być poprawnym adresem email.',
            'email.max' => 'Pole email nie może przekraczać 255 znaków.',
            'email.unique' => 'Podany email jest już zajęty.',
            'email.regex' => 'Pole email musi być poprawnym adresem email.',
            'address.required' => 'Pole adres jest wymagane.',
            'address.string' => 'Pole adres musi być ciągiem znaków.',
            'address.max' => 'Pole adres nie może przekraczać 255 znaków.',
        ];
    }
}
