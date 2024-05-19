<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMovieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'director' => 'required|string|max:255',
            'release_year' => 'required|integer|min:0',
            'duration' => 'required|string|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'rate' => 'required|numeric|min:0',
            'video_path' => 'required|string',
            'price_day' => 'required|numeric|min:0',
            'available' => 'required|in:dostępny,niedostępny',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
