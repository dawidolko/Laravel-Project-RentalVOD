<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ];
    }

    public function messages()
    {
        return [
            'start.required' => 'Data rozpoczęcia jest wymagana.',
            'start.date' => 'Data rozpoczęcia musi być prawidłową datą.',
            'end.required' => 'Data zakończenia jest wymagana.',
            'end.date' => 'Data zakończenia musi być prawidłową datą.',
            'end.after_or_equal' => 'Data zakończenia nie może być wcześniejsza niż data rozpoczęcia.',
        ];
    }
}
