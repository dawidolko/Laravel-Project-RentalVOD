<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => 'Musisz wybrać plik.',
            'avatar.image' => 'Plik musi być obrazem.',
            'avatar.mimes' => 'Dopuszczalne są tylko pliki w formatach: jpeg, png, jpg, gif, svg.',
            'avatar.max' => 'Maksymalny rozmiar pliku to 2048 kB.'
        ];
    }
}
