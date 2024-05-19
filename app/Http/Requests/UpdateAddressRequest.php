<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'address' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s,.-]+$/',
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'Adres jest wymagany.',
            'address.regex' => 'Adres może zawierać tylko litery, cyfry, spacje oraz znaki ,.-',
        ];
    }
}
