<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecommendMovieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'friend_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'friend_id.required' => 'Pole friend_id jest wymagane.',
            'friend_id.exists' => 'Podany friend_id nie istnieje w bazie użytkowników.',
        ];
    }
}
