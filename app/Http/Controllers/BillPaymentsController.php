<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\PaymentMethod;
use App\Models\Vendor;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Exception;

class BillPaymentsController extends Controller
{
    use TransactionTrait;


    public function index()
    {
        $billPayments = BillPayment::with('vendor', 'bill', 'paymentmethod', 'ledger')
            ->latest()
            ->paginate(25);

        return view('bill_payments.index', compact('billPayments'));
    }


    public function create()
    {
        $paymentSerial = 'VPM' . str_pad(BillPayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $vendors = Vendor::pluck('name', 'id')->all();
        $bills = Bill::pluck('bill_number', 'id')->all();
        $paymentMethods = PaymentMethod::query()->get();
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');

        $ledgers = Ledger::pluck('id', 'id')->all();

        return view('bill_payments.create', compact('vendors', 'bills', 'paymentMethods', 'ledgers', 'paymentSerial', 'depositAccounts'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $billPayment = BillPayment::create($data);
        $payments = json_decode($request->data ?? '{}');
        foreach ($payments as $payment) {
            BillPaymentItem::create(['bill_id' => $payment->bill_id, 'bill_payment_id' => $billPayment->id, 'amount' => $payment->amount]);
        }
        return redirect()->route('bill_payments.bill_payment.index')
            ->with('success_message', 'Bill Payment was successfully added.');

    }


    public function show($id)
    {
        $billPayment = BillPayment::with('vendor', 'bill', 'paymentmethod', 'ledger')->findOrFail($id);

        return view('bill_payments.show', compact('billPayment'));
    }


    public function edit($id)
    {
        $billPayment = BillPayment::findOrFail($id);
        $vendors = Vendor::pluck('name', 'id')->all();
        $bills = Bill::pluck('bill_number', 'id')->all();
        $paymentMethods = PaymentMethod::query()->get();
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        return view('bill_payments.edit', compact('billPayment', 'vendors', 'bills', 'paymentMethods', 'depositAccounts'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $billPayment = BillPayment::findOrFail($id);
        $billPayment->update($data);
        BillPaymentItem::query()->where('bill_payment_id', $billPayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        $payments = json_decode($request->data ?? '{}');
        foreach ($payments as $payment) {
            BillPaymentItem::create(['bill_id' => $payment->bill_id, 'bill_payment_id' => $billPayment->id, 'amount' => $payment->amount]);
        }

        return redirect()->route('bill_payments.bill_payment.index')
            ->with('success_message', 'Bill Payment was successfully updated.');

    }

    public function destroy($id)
    {

        $billPayment = BillPayment::findOrFail($id);
        BillPaymentItem::query()->where('bill_payment_id', $billPayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        $billPayment->delete();

        return redirect()->route('bill_payments.bill_payment.index')
            ->with('success_message', 'Bill Payment was successfully deleted.');

    }


    protected function getData(Request $request)
    {


        $rules = [
            'vendor_id' => 'required|nullable',
            'payment_date' => 'required',
            'payment_sl' => 'required',
            'payment_method_id' => 'nullable',
            'ledger_id' => 'required|nullable',
            'note' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}