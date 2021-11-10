<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\PosPayment;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use Cassandra\Custom;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\EntryType;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Http\Request;
use Exception;

class ReceivePaymentsController extends Controller
{
    use TransactionTrait;


    public function index(Request $request)
    {
        $customer_id = $request->customer_id;
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $receivePayments = ReceivePayment::with('customer', 'ledger')
            ->when($customer_id != null, function ($query) use ($customer_id) {
                return $query->where('customer_id', $customer_id);
            })
            ->whereBetween('payment_date', [$start_date, $end_date])
            ->latest()->paginate(10);
        $customers = Customer::all();
        return view('receive_payments.index', compact('receivePayments', 'customers', 'customer_id', 'start_date', 'end_date'));
    }


    public function create()
    {
        $title = "Receive Payment";
        $paymentSerial = 'PM' . str_pad(ReceivePayment::query()->count(), 3, '0', STR_PAD_LEFT);
        $customers = Customer::pluck('name', 'id')->all();
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $customer_id = \request()->get('customer_id');
        $ledgerGroups = LedgerGroup::all();

        return view('receive_payments.create', compact('customers', 'ledgerGroups', 'customer_id', 'title', 'paymentMethods', 'paymentSerial', 'depositAccounts', 'cashAcId'));
    }


    public function store(Request $request)
    {

//        dd($request->all());

        $data = $this->getData($request);
        $rp = ReceivePayment::create($data);

        $payments = json_decode($request->data ?? '{}');
        $pos_payments = json_decode($request->pos ?? '{}');
        foreach ($payments as $payment) {
            try {
                ReceivePaymentItem::create(['invoice_id' => $payment->invoice_id, 'receive_payment_id' => $rp->id, 'amount' => $payment->amount]);
            } catch (Exception $exception) {

            }
        }
        foreach ($pos_payments as $pos_payment) {
            PosPayment::create(['pos_sales_id' => $pos_payment->pos_id, 'receive_payment_id' => $rp->id, 'amount' => $pos_payment->amount,
                'date' => $rp->payment_date, 'ledger_id' => $rp->deposit_to]);
        }


        if ($request->has('previous_due')) {
            $customer = Customer::find($request->customer_id);
            $previous_due = $request->previous_due;
            if ($previous_due > 0) {
                AccountingFacade::addTransaction($rp->deposit_to, optional($customer->ledger)->id,
                    $previous_due, "OpeningBalance", $rp->payment_date, "Customer Payment", Ledger::class, optional($customer->ledger)->id, $rp->payment_sl, $customer->name);

            }

        }
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
        $ledgerGroups = LedgerGroup::all();
        $pos_payments = PosPayment::query()->where('receive_payment_id', $receivePayment->id)->get();

//        dd($receivePayment->items);
        return view('receive_payments.edit', compact('receivePayment', 'ledgerGroups', 'customers',
            'paymentMethods', 'depositAccounts', 'pos_payments'));
    }


    public function update($id, Request $request)
    {

//        dd($request->all());

        $data = $this->getData($request);

        $receivePayment = ReceivePayment::findOrFail($id);
        $receivePayment->update($data);
        ReceivePaymentItem::query()->where('receive_payment_id', $receivePayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        PosPayment::query()->where('receive_payment_id', $receivePayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        $payments = json_decode($request->data ?? '{}');
        $pos_payments = json_decode($request->pos ?? '{}');

        foreach ($payments as $payment) {
            ReceivePaymentItem::create(['invoice_id' => $payment->invoice_id, 'receive_payment_id' => $receivePayment->id, 'amount' => $payment->amount]);
        }
        foreach ($pos_payments as $pos_payment) {
            PosPayment::create(['pos_sales_id' => $pos_payment->pos_id, 'receive_payment_id' => $receivePayment->id, 'amount' => $pos_payment->amount,
                'date' => $receivePayment->payment_date, 'ledger_id' => $receivePayment->deposit_to]);
        }

        return redirect()->route('receive_payments.receive_payment.index')->with('success_message', 'Receive Payment was successfully updated.');

    }


    public function destroy($id)
    {

        $receivePayment = ReceivePayment::findOrFail($id);
        ReceivePaymentItem::query()->where('receive_payment_id', $receivePayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        PosPayment::query()->where('receive_payment_id', $receivePayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        $customer = $receivePayment->customer;

        TransactionDetail::query()->where([
            'type' => Ledger::class,
            'type_id' => optional($customer->ledger)->id,
            'entry_type' => EntryType::$CR,
            'amount' => $receivePayment->previous_due,
        ])->forceDelete();

        $receivePayment->delete();

        return redirect()->route('receive_payments.receive_payment.index')->with('success_message', 'Receive Payment was successfully deleted.');

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
            'given' => 'string|nullable',
            'previous_due' => 'nullable'
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
