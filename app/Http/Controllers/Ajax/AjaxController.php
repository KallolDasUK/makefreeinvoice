<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function receivePaymentCustomerInvoice(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        $invoices = Invoice::query()->where('customer_id', $customer->id)->get();
        return view('partials.receive-payment-customers-invoice', compact('invoices'));


    }

    public function recordPayment(Request $request)
    {
//        sleep(5);
//        return $request->all();

        $request->validate(['payment_date' => 'required', 'invoice_id' => 'required']);
        $paymentSerial = 'PM' . str_pad(ReceivePayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $invoice = Invoice::find($request->invoice_id);
        $receivePayment = ReceivePayment::create([
            'payment_date' => $request->payment_date,
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'payment_method_id' => $request->payment_method_id,
            'deposit_to' => $request->deposit_to,
            'payment_sl' => $paymentSerial,
            'note' => $request->notes
        ]);

        ReceivePaymentItem::create(['receive_payment_id' => $receivePayment->id, 'invoice_id' => $invoice->id, 'amount' => $request->amount]);
        session()->flash('success_message', 'Payment Recorded Successfully for Invoice ' . $invoice->invoice_number);
        return ['success_message' => 'Payment Recorded Successfully for Invoice ' . $invoice->invoice_number];
    }
}
