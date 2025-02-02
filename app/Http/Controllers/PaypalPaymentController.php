<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;

class PaypalPaymentController extends Controller
{
    public function index()
    {
        return view('paypal.index');
    }

    public function store(Request $request)
    {
        try {

            Session::flash('success', 'PayPal Payment Successful!');

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
