<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'genre' => 'required|string|max:255|unique:categories,species',
        ];
    }

    public function messages()
    {
        return [
            'genre.required' => 'Pole gatunek jest wymagane.',
            'genre.string' => 'Pole gatunek musi być ciągiem znaków.',
            'genre.max' => 'Pole gatunek nie może przekraczać 255 znaków.',
            'genre.unique' => 'Taka kategoria już istnieje.',
        ];
    }
}
