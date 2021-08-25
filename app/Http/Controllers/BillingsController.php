<?php

namespace App\Http\Controllers;

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
        $invoices = auth()->user()->invoices();
        $upcoming_invoice = auth()->user()->upcomingInvoice();

//        dd($upcoming_invoice->toArray(),Subscription::first()->toArray());

        return view('subscriptions.index', ['intent' => auth()->user()->createSetupIntent(), 'invoices' => $invoices,
            'upcoming_invoice' => $upcoming_invoice]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
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
