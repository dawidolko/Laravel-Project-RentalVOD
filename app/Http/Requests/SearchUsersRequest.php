<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'q' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'q.required' => 'Pole q jest wymagane.',
            'q.string' => 'Pole q musi być ciągiem znaków.',
        ];
    }
}
