<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Http\Request;
use Exception;

class ReceivePaymentsController extends Controller
{
    use TransactionTrait;


    public function index()
    {
        $receivePayments = ReceivePayment::with('customer', 'paymentmethod')->latest()->paginate(10);

        return view('receive_payments.index', compact('receivePayments'));
    }


    public function create()
    {
        $title = "Receive Payment";
        $paymentSerial = 'PM' . str_pad(ReceivePayment::query()->count(), 3, '0', STR_PAD_LEFT);
        $customers = Customer::pluck('name', 'id')->all();
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();

        return view('receive_payments.create', compact('customers', 'title', 'paymentMethods', 'paymentSerial', 'depositAccounts', 'cashAcId'));
    }


    public function store(Request $request)
    {

//        dd($request->all());

        $data = $this->getData($request);
        $rp = ReceivePayment::create($data);

        $payments = json_decode($request->data ?? '{}');
        foreach ($payments as $payment) {
            ReceivePaymentItem::create(['invoice_id' => $payment->invoice_id, 'receive_payment_id' => $rp->id, 'amount' => $payment->amount]);
        }
//        dd($payments);


        return redirect()->route('receive_payments.receive_payment.index')->with('success_message', 'Receive Payment was successfully added.');

    }


    public function show($id)
    {
        $receivePayment = ReceivePayment::with('customer', 'paymentmethod')->findOrFail($id);

        return view('receive_payments.show', compact('receivePayment'));
    }


    public function edit($id)
    {
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');

        $receivePayment = ReceivePayment::findOrFail($id);
        $customers = Customer::pluck('name', 'id')->all();
        $paymentMethods = PaymentMethod::query()->get();
//        dd($receivePayment->items);
        return view('receive_payments.edit', compact('receivePayment', 'customers', 'paymentMethods', 'depositAccounts'));
    }


    public function update($id, Request $request)
    {

//        dd($request->all());

        $data = $this->getData($request);

        $receivePayment = ReceivePayment::findOrFail($id);
        $receivePayment->update($data);
        ReceivePaymentItem::query()->where('receive_payment_id', $receivePayment->id)->get()->each(function ($model) {
            $model->delete();
        });;
        $payments = json_decode($request->data ?? '{}');
        foreach ($payments as $payment) {
            ReceivePaymentItem::create(['invoice_id' => $payment->invoice_id, 'receive_payment_id' => $receivePayment->id, 'amount' => $payment->amount]);
        }

        return redirect()->route('receive_payments.receive_payment.index')->with('success_message', 'Receive Payment was successfully updated.');

    }


    public function destroy($id)
    {

        $receivePayment = ReceivePayment::findOrFail($id);
        ReceivePaymentItem::query()->where('receive_payment_id', $receivePayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        $receivePayment->delete();

        return redirect()->route('receive_payments.receive_payment.index')
            ->with('success_message', 'Receive Payment was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'customer_id' => 'required|nullable',
            'payment_date' => 'required',
            'payment_sl' => 'required',
            'payment_method_id' => 'nullable',
            'deposit_to' => 'required|nullable',
            'note' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
