<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
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

        $invoices = Invoice::query()
            ->where('customer_id', $customer->id)
            ->where('payment_status', '!=', Invoice::Paid)
            ->get();
        return view('partials.receive-payment-customers-invoice', compact('invoices'));


    }

    public function invoicePaymentTransactions(Request $request, $invoice)
    {

//        dd($request->all(), $invoice);
        $invoice = Invoice::find($invoice);
        $payments = $invoice->payments()->get();

        return view('partials.invoice_payment_transactions', compact('payments'));


    }

    public function invoicePayment(Request $request)
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

    public function billPayment(Request $request)
    {

        $request->validate(['payment_date' => 'required', 'bill_id' => 'required']);
        $paymentSerial = 'BPM' . str_pad(BillPayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $bill = Bill::find($request->bill_id);
        $billPayment = BillPayment::create([
            'payment_date' => $request->payment_date,
            'bill_id' => $bill->id,
            'vendor_id' => $bill->vendor_id,
            'payment_method_id' => $request->payment_method_id,
            'ledger_id' => $request->ledger_id,
            'payment_sl' => $paymentSerial,
            'note' => $request->notes
        ]);


        BillPaymentItem::create(['bill_payment_id' => $billPayment->id, 'bill_id' => $bill->id, 'amount' => $request->amount]);

        session()->flash('success_message', 'Payment Recorded Successfully for Bill ' . $bill->bill_number);
        return ['success_message' => 'Payment Recorded Successfully for Bill ' . $bill->bill_number];
    }


    public function getInvoicePaymentList(Request $request, $invoice)
    {

    }

}
