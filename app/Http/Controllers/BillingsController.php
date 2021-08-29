<?php

namespace App\Http\Controllers;

use App\Models\MetaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use Stripe\Product;

class BillingsController extends Controller
{

    public function index()
    {
        View::share('title', 'Billing & Subscriptions');

        $user = auth()->user();

        $invoices = auth()->user()->invoices();
        $upcoming_invoice = auth()->user()->upcomingInvoice();
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        $currentPlan = null;
        $price = null;
        if ($user->subscribed('default')) {
            $subscription = $user->subscriptions->first();
            $sub_stripe_id = $subscription->stripe_id;
            $sub = $stripe->subscriptions->retrieve($sub_stripe_id);
            $sub->product = $stripe->products->retrieve(
                $sub->plan->product, []
            );
            $currentPlan = $sub;
        }


        return view('subscriptions.index', ['intent' => auth()->user()->createSetupIntent(), 'invoices' => $invoices,
            'upcoming_invoice' => $upcoming_invoice, 'currentPlan' => $currentPlan]);
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
                $key = \config('services.stripe.secret');
                $stripe = new \Stripe\StripeClient($key);
                $currentPlan = null;
                $price = null;
                if ($user->subscribed('default')) {
                    $subscription = $user->subscriptions->first();
                    $sub_stripe_id = $subscription->stripe_id;
                    $sub = $stripe->subscriptions->retrieve($sub_stripe_id);
                    $sub->product = $stripe->products->retrieve(
                        $sub->plan->product, []
                    );
                    $currentPlan = $sub;
                    MetaSetting::query()->updateOrCreate(['key' => 'plan_name'], ['value' => $currentPlan->product->name]);
                    MetaSetting::query()->updateOrCreate(['key' => 'plan_price'], ['value' => ($currentPlan->plan->amount / 100)]);
                    MetaSetting::query()->updateOrCreate(['key' => 'plan_interval'], ['value' => $currentPlan->plan->interval]);
                }

                return [$request->all(), auth()->user()];
            } catch (\Exception $e) {
                return $e->getTrace();
            }

        }


        return redirect('dashboard');
    }

    public function downloadInvoice(Request $request, $invoiceId)
    {
//        dd($request->all(),$invoiceId);
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor' => 'Invoice Pedia',
            'product' => 'Subscription',
        ]);
    }


    public function cancelSubscription(Request $request)
    {
        $user = auth()->user();
        if (auth()->user()->subscribed('default')) {
            MetaSetting::query()->updateOrCreate(['key' => 'plan_name'], ['value' => null]);
            MetaSetting::query()->updateOrCreate(['key' => 'plan_price'], ['value' => null]);
            MetaSetting::query()->updateOrCreate(['key' => 'plan_interval'], ['value' => null]);

            $user->subscription('default')->cancelNow();
        }
        return back();
    }


    public function subscriptionModal()
    {
        $user = auth()->user();

        $invoices = auth()->user()->invoices();
        $upcoming_invoice = auth()->user()->upcomingInvoice();
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        $currentPlan = null;
        $price = null;
        if ($user->subscribed('default')) {
            $subscription = $user->subscriptions->first();
            $sub_stripe_id = $subscription->stripe_id;
            $sub = $stripe->subscriptions->retrieve($sub_stripe_id);
            $sub->product = $stripe->products->retrieve(
                $sub->plan->product, []
            );
            $currentPlan = $sub;
        }


        return view('partials.subscribe', ['intent' => auth()->user()->createSetupIntent(), 'invoices' => $invoices,
            'upcoming_invoice' => $upcoming_invoice, 'currentPlan' => $currentPlan]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
