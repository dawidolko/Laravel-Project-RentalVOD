<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
            'director' => 'required|string|max:255',
            'release_year' => 'required|integer|min:1800|max:2155',
            'duration' => 'required|integer|min:0|max:500',
            'rate' => 'required|numeric|min:0|max:10',
            'video_path' => 'required|string|max:255',
            'price_day' => 'required|numeric|min:0',
            'available' => 'required|in:dostępny,niedostępny',
            'category_id' => 'required|integer|exists:categories,id',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
