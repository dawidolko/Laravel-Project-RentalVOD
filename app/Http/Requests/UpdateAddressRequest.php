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
            'address' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'Pole adres jest wymagane.',
            'address.string' => 'Pole adres musi być ciągiem znaków.',
            'address.max' => 'Pole adres nie może przekraczać 255 znaków.',
        ];
    }
}
