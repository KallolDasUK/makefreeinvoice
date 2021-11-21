<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\Vendor;
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
        $pos_sales = PosSale::query()
            ->where('customer_id', $customer->id)
            ->get()->filter(function ($sale) {
                return $sale->due > 0;
            });
        return view('partials.receive-payment-customers-invoice', compact('invoices', 'customer', 'pos_sales'));


    }

    public function vendorUnpaidBill(Request $request)
    {
        $vendor = Vendor::find($request->vendor_id);

        $bills = Bill::query()
            ->where('vendor_id', $vendor->id)
            ->where('payment_status', '!=', Bill::Paid)
            ->get();


        return view('partials.vendor_unpaid_bills', compact('bills', 'vendor'));


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
        $request->validate(['payment_date' => 'required', 'invoice_id' => 'required']);
        $paymentSerial = 'PM' . str_pad(ReceivePayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $invoice = Invoice::find($request->invoice_id);
        $receivePayment = ReceivePayment::create([
            'payment_date' => $request->payment_date,
            'customer_id' => $invoice->customer_id,
            'payment_method_id' => $request->payment_method_id,
            'deposit_to' => $request->deposit_to,
            'payment_sl' => $paymentSerial,
            'note' => $request->notes
        ]);

        ReceivePaymentItem::create(['receive_payment_id' => $receivePayment->id, 'invoice_id' => $invoice->id, 'amount' => $request->amount]);
        session()->flash('success_message', 'Payment Recorded Successfully for Invoice ' . $invoice->invoice_number);
        return ['success_message' => 'Payment Recorded Successfully for Invoice ' . $invoice->invoice_number, 'id' => $receivePayment->id];
    }

    public function storePhoneNumber(Request $request)
    {
        $phone = $request->phone;
        MetaSetting::query()->updateOrCreate(['key' => 'phone'], ['value' => $phone]);
        return [];
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

    public function customerPaymentReceipt(Request $request, $id)
    {
        $rp = ReceivePayment::findOrFail($id);

        $pos_payment = PosPayment::query()->where('receive_payment_id', $id)->get();
        return view('partials.customer-payment-receipt-content', compact('rp', 'pos_payment'));

    }


    public function invoice_summary(Request $request)
    {
        $start_date = $request->start_date ;
        $end_date = $request->end_date ;
        return ['overdue' => decent_format_dash_if_zero(Invoice::overdue($start_date, $end_date)),
            'draft' => decent_format_dash_if_zero(Invoice::draft($start_date, $end_date)),
            'paid' => decent_format_dash_if_zero(Invoice::paid($start_date, $end_date)),
            'due' => decent_format_dash_if_zero(Invoice::due($start_date, $end_date)),
            'total' => decent_format_dash_if_zero(Invoice::total($start_date, $end_date))];

    }

}
