<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class PaymentController extends Controller
{
    // public function payment()
    // {
    //     $cart = session('cart', []);
    //     if (count($cart) == 0) {
    //         return redirect()->route('cart.show')->with('error', 'Twój koszyk jest pusty.');  // Corrected route name here
    //     }

    //     return view('payment.index', compact('cart'));
    // }

    // public function processPayment(Request $request)
    // {
    //     $request->validate([
    //         'cardNumber' => 'required|digits:16',
    //         'cvv' => 'required|digits:3',
    //         'expiryDate' => 'required|date_format:Y-m',
    //     ]);

    //     session()->flash('success', 'Płatność zakończona sukcesem!');
    //     return redirect()->route('loans.show'); 
    // }
}
