<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAdvancePayment;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Illuminate\Http\Request;
use Exception;

class CustomerAdvancePaymentsController extends Controller
{


    public function index()
    {
        $customerAdvancePayments = CustomerAdvancePayment::with('customer', 'ledger')->paginate(25);

        return view('customer_advance_payments.index', compact('customerAdvancePayments'));
    }


    public function create()
    {
        $customers = Customer::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();

        return view('customer_advance_payments.create', compact('customers', 'ledgers'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $customerAdvancePayment = CustomerAdvancePayment::create($data);
        $this->advanceTransactions($customerAdvancePayment);

        return redirect()->route('customer_advance_payments.customer_advance_payment.index')
            ->with('success_message', 'Customer Advance Payment was successfully added.');

    }


    public function show($id)
    {
        $customerAdvancePayment = CustomerAdvancePayment::with('customer', 'ledger')->findOrFail($id);

        return view('customer_advance_payments.show', compact('customerAdvancePayment'));
    }


    public function edit($id)
    {
        $customerAdvancePayment = CustomerAdvancePayment::findOrFail($id);
        $customers = Customer::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();

        return view('customer_advance_payments.edit', compact('customerAdvancePayment', 'customers', 'ledgers'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $customerAdvancePayment = CustomerAdvancePayment::findOrFail($id);
        $customerAdvancePayment->update($data);
        $this->advanceTransactions($customerAdvancePayment);
        return redirect()->route('customer_advance_payments.customer_advance_payment.index')
            ->with('success_message', 'Customer Advance Payment was successfully updated.');

    }


    public function destroy($id)
    {

        $customerAdvancePayment = CustomerAdvancePayment::findOrFail($id);
        Transaction::query()->where(['type' => CustomerAdvancePayment::class, 'type_id' => $customerAdvancePayment->id])->forceDelete();
        TransactionDetail::query()->where(['type' => CustomerAdvancePayment::class, 'type_id' => $customerAdvancePayment->id])->forceDelete();

        $customerAdvancePayment->delete();

        return redirect()->route('customer_advance_payments.customer_advance_payment.index')
            ->with('success_message', 'Customer Advance Payment was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'customer_id' => 'required|nullable',
            'ledger_id' => 'required|nullable',
            'amount' => 'required|nullable|string|min:1',
            'date' => 'required|nullable|string|min:1',
            'note' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);

        return $data;
    }

    public function advanceTransactions($customerAdvancePayment)
    {
//        dd($customerAdvancePayment->customer->ledger->id);
        Transaction::query()->where(['type' => CustomerAdvancePayment::class, 'type_id' => $customerAdvancePayment->id])->forceDelete();
        TransactionDetail::query()->where(['type' => CustomerAdvancePayment::class, 'type_id' => $customerAdvancePayment->id])->forceDelete();
        AccountingFacade::addTransaction(
            $customerAdvancePayment->ledger_id,
            optional(optional($customerAdvancePayment->customer)->ledger)->id,
            $customerAdvancePayment->amount,
            $customerAdvancePayment->note,
            $customerAdvancePayment->date,
            "Customer Advance Payment",
            CustomerAdvancePayment::class,
            $customerAdvancePayment->id);
    }

}
