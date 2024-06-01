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
            'category_id' => 'required|integer|exists:categories,id',
            'director' => 'required|string|max:255',
            'release_year' => 'required|integer|min:1800|max:2155',
            'duration' => 'required|integer|min:0|max:500',
            'rate' => 'required|numeric|min:0|max:10',
            'video_path' => 'required|string|max:255',
            'price_day' => 'required|numeric|min:0',
            'available' => 'required|in:dostępny,niedostępny',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Pole tytuł jest wymagane.',
            'title.string' => 'Pole tytuł musi być ciągiem znaków.',
            'title.max' => 'Pole tytuł nie może przekraczać 255 znaków.',
            'description.required' => 'Pole opis jest wymagane.',
            'description.string' => 'Pole opis musi być ciągiem znaków.',
            'category_id.required' => 'Pole kategoria jest wymagane.',
            'category_id.integer' => 'Pole kategoria musi być liczbą całkowitą.',
            'category_id.exists' => 'Wybrana kategoria nie istnieje.',
            'director.required' => 'Pole reżyser jest wymagane.',
            'director.string' => 'Pole reżyser musi być ciągiem znaków.',
            'director.max' => 'Pole reżyser nie może przekraczać 255 znaków.',
            'release_year.required' => 'Pole rok premiery jest wymagane.',
            'release_year.integer' => 'Pole rok premiery musi być liczbą całkowitą.',
            'release_year.min' => 'Pole rok premiery musi być większe lub równe 1800.',
            'release_year.max' => 'Pole rok premiery musi być mniejsze lub równe 2155.',
            'duration.required' => 'Pole czas trwania jest wymagane.',
            'duration.integer' => 'Pole czas trwania musi być liczbą całkowitą.',
            'duration.min' => 'Pole czas trwania musi być większe lub równe 0.',
            'duration.max' => 'Pole czas trwania musi być mniejsze lub równe 500.',
            'rate.required' => 'Pole ocena jest wymagane.',
            'rate.numeric' => 'Pole ocena musi być liczbą.',
            'rate.min' => 'Pole ocena musi być większe lub równe 0.',
            'rate.max' => 'Pole ocena musi być mniejsze lub równe 10.',
            'video_path.required' => 'Pole ścieżka wideo jest wymagane.',
            'video_path.string' => 'Pole ścieżka wideo musi być ciągiem znaków.',
            'video_path.max' => 'Pole ścieżka wideo nie może przekraczać 255 znaków.',
            'price_day.required' => 'Pole cena za dzień jest wymagane.',
            'price_day.numeric' => 'Pole cena za dzień musi być liczbą.',
            'price_day.min' => 'Pole cena za dzień musi być większe lub równe 0.',
            'available.required' => 'Pole dostępność jest wymagane.',
            'available.in' => 'Pole dostępność musi być jedną z wartości: dostępny, niedostępny.',
            'img_path.image' => 'Pole obraz musi być obrazem.',
            'img_path.mimes' => 'Pole obraz musi być jednym z typów: jpeg, png, jpg, gif.',
            'img_path.max' => 'Pole obraz nie może przekraczać 2048 kilobajtów.',
        ];
    }
}
