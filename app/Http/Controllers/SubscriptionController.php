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

    public function purchaseSubscription(Request $request)
    {
        $user = auth()->user();
        $paymentMethod = $request->input('paymentMethod');

        if ($request->ajax()) {
//            auth()->user()->newSubscription('cashier', $request->api_id)->create($request->paymentMethod);
            $user->createOrGetStripeCustomer();
            $user->addPaymentMethod($paymentMethod);
            try {
                $user->newSubscription('default', $request->api_id)->create($paymentMethod, [
                    'email' => $user->email
                ]);
                return [$request->all(), auth()->user()];
            } catch (\Exception $e) {
                return $e->getTrace();
            }

        }


        return redirect('dashboard');
    }
}
