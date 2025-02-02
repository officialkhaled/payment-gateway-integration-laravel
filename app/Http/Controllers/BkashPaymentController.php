<?php

namespace App\Http\Controllers;

use Session;
use Stripe\Charge;
use Stripe\Customer;
use Illuminate\Http\Request;

class BkashPaymentController extends Controller
{
    public function index()
    {
        return view('bkash.index');
    }

    public function store(Request $request)
    {
        try {

            Session::flash('success', 'bKash Payment Successful!');

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
