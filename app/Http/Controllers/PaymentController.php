<?php

namespace App\Http\Controllers;

use App\Services\PayPalService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function ipn(Request $request, PayPalService $payPal)
    {
        $payPal->process($request);
    }

    public function cancel()
    {
        return redirect()->route('home');
    }

    public function return()
    {
        return redirect()->route('home');
    }
}
