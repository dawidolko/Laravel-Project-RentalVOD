<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRuleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rate' => 'required|numeric|min:0|max:10',
            'recommendations_count' => 'required|numeric|min:0|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'rate.required' => 'Pole rate jest wymagane.',
            'rate.numeric' => 'Pole rate musi być liczbą.',
            'rate.min' => 'Pole rate musi być co najmniej 0.',
            'rate.max' => 'Pole rate nie może być większe niż 10.',
            'recommendations_count.required' => 'Pole recommendations_count jest wymagane.',
            'recommendations_count.numeric' => 'Pole recommendations_count musi być liczbą.',
            'recommendations_count.min' => 'Pole recommendations_count musi być co najmniej 0.',
            'recommendations_count.max' => 'Pole recommendations_count nie może być większe niż 1000.',
        ];
    }
}
