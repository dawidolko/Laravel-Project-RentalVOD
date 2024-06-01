<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendFriendRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Pole email jest wymagane.',
            'email.email' => 'Pole email musi być prawidłowym adresem email.',
            'email.exists' => 'Podany email nie istnieje w bazie użytkowników.',
        ];
    }
}
