<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetSuperPromoPriceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'super_promo_price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'super_promo_price.required' => 'Pole super_promo_price jest wymagane.',
            'super_promo_price.numeric' => 'Pole super_promo_price musi być liczbą.',
            'super_promo_price.min' => 'Pole super_promo_price musi być co najmniej 0.',
        ];
    }
}
