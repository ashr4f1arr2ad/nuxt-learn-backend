<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stripe;

class StripeController extends Controller
{
    public function stripes(Request $request) {
        // echo "Works!";
        // dd('fadsf');
        $stripe_token = new Stripe;
        // $stripe = Stripe::create([
        //      'stripe_token' => $request->stripe_token
        // ]);
        
        // $stripe->stripe_token = [$request->stripe_token];
        // $stripe->stripe_token = $request->stripe_token;
        // $stripe->save();

        $token = $request->stripe_token;

        //Method 1

        // \Stripe\Stripe::setApiKey('sk_test_51LeAnVKnSQfFyC3hmA4mawYXzOjFIOFuX2ulLXzZdxOCcP1z2eNcpptcSLRUlMpUIuPmGwQPLUDduQ88Y1h1dxNn00XUMfHRjO');
        
        // $customer = \Stripe\Customer::create([
        //     'source' => $token,
        //     'email' => 'paying.user@example.com',
        // ]);
        
        // $customerId = $customer->id;
        
        // $charge = \Stripe\Charge::create([
        //     'amount' => 999,
        //     'currency' => 'USD',
        //     // 'customer' => 'Alex',
        //     'description' => 'Payment',
        //     'source' => $customerId,
        // ]);

        //Method 2

        $stripe = new \Stripe\StripeClient('sk_test_51LeAnVKnSQfFyC3hmA4mawYXzOjFIOFuX2ulLXzZdxOCcP1z2eNcpptcSLRUlMpUIuPmGwQPLUDduQ88Y1h1dxNn00XUMfHRjO');
        
        $customer = $stripe->customers->create([
            'source' => $token,
            'email' => 'paying.user@example.com',
        ]);

        $customerId = $customer->id;

        $charge = $stripe->charges->create([
            'amount' => 200000,
            'currency' => 'USD',
            'description' => 'Payment',
            'customer' => $customerId,
        ]);

        $stripe_token->stripe_token = $charge;
        $stripe_token->save();
        
        return response()->json($stripe_token);
    }

    public function getCard() {
        $cards = Stripe::all();

        return response()->json($cards);
    }
}
