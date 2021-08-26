<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function retrievePlans()
    {
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        $plansraw = $stripe->plans->all();
        $plans = $plansraw->data;

        foreach ($plans as $plan) {
            $prod = $stripe->products->retrieve(
                $plan->product, []
            );

            $plan->product = $prod;
        }
        return $plans;
    }

    public function showSubscription()
    {
        $plans = $this->retrievePlans();
        $user = auth()->user();

        return view('subscriptions.subscribe', [
            'user' => $user,
            'intent' => $user->createSetupIntent(),
            'plans' => $plans
        ]);
    }


}
