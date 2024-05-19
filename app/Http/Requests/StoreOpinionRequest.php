<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpinionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required|min:1',
            'movie_id' => 'required|exists:movies,id',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Treść opinii jest wymagana.',
            'content.min' => 'Treść opinii musi mieć co najmniej 1 znak.',
            'movie_id.required' => 'ID filmu jest wymagane.',
            'movie_id.exists' => 'Podany film nie istnieje.',
        ];
    }
}
