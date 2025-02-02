<?php

namespace App\Http\Controllers;

use Session;
use Stripe\Charge;
use Stripe\Customer;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $customer = Customer::create([
                "name" => $request->name,
                "email" => $request->email,
                "source" => $request->stripeToken,
                "address" => [
                    "line1" => $request->line,
                    "city" => $request->city,
                    "country" => $request->country
                ],
            ]);

            $amount = ($request->quantity * $request->rate);

            Charge::create([
                "amount" => intval($amount * 100),
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => $request->description,
                "shipping" => [
                    "name" => $request->name,
                    "address" => [
                        "line1" => $request->line,
                        "city" => $request->city,
                        "country" => $request->country
                    ]
                ]
            ]);

            Session::flash('success', 'Stripe Payment Successful!');

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
