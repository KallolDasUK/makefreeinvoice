<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function receivePaymentCustomerInvoice(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        $invoices = Invoice::query()->where('customer_id', $customer->id)->get();
        return view('partials.receive-payment-customers-invoice', compact('invoices'));


    }
}
