<?php

namespace App\Http\Controllers;

use Stripe;
use Session;
use Stripe\Charge;
use Stripe\Customer;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $customer = Customer::create([
                "name" => $request->name,
                "email" => $request->email,
                "source" => $request->stripeToken,
                "address" => [
                    "line1" => $request->address,
                    "city" => "Unknown",
                    "country" => "US"
                ],
            ]);

            $charge = Charge::create([
                "amount" => intval($request->rate * 100),
                "currency" => $request->currency ?? "usd",
                "customer" => $customer->id,
                "description" => $request->description,
                "shipping" => [
                    "name" => $request->name,
                    "address" => [
                        "line1" => $request->address,
                        "city" => "Unknown",
                        "country" => "US"
                    ]
                ]
            ]);

            Session::flash('success', 'Payment successful!');

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
