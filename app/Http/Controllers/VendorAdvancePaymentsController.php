<?php

namespace App\Http\Controllers;

use App\Models\CustomerAdvancePayment;
use App\Models\Vendor;
use App\Models\VendorAdvancePayment;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Illuminate\Http\Request;

class VendorAdvancePaymentsController extends Controller
{


    public function index()
    {
        $vendorAdvancePayments = VendorAdvancePayment::with('vendor', 'ledger')->latest()->paginate(25);

        return view('vendor_advance_payments.index', compact('vendorAdvancePayments'));
    }


    public function create(Request $request)
    {
        $vendors = Vendor::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $vendor_id = $request->vendor_id;

        return view('vendor_advance_payments.create', compact('vendors', 'ledgers', 'vendor_id'));
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);

        $vendorAdvancePayment = VendorAdvancePayment::create($data);
        $this->advanceTransactions($vendorAdvancePayment);

        return redirect()->route('vendor_advance_payments.vendor_advance_payment.index')
            ->with('success_message', 'Vendor Advance Payment was successfully added.');

    }


    public function show($id)
    {
        $vendorAdvancePayment = VendorAdvancePayment::with('vendor', 'ledger')->findOrFail($id);

        return view('vendor_advance_payments.show', compact('vendorAdvancePayment'));
    }


    public function edit($id)
    {
        $vendorAdvancePayment = VendorAdvancePayment::findOrFail($id);
        $vendors = Vendor::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();

        return view('vendor_advance_payments.edit', compact('vendorAdvancePayment', 'vendors', 'ledgers'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $vendorAdvancePayment = VendorAdvancePayment::findOrFail($id);
        $vendorAdvancePayment->update($data);
        $this->advanceTransactions($vendorAdvancePayment);

        return redirect()->route('vendor_advance_payments.vendor_advance_payment.index')
            ->with('success_message', 'Vendor Advance Payment was successfully updated.');

    }


    public function destroy($id)
    {

        $vendorAdvancePayment = VendorAdvancePayment::findOrFail($id);
        $vendorAdvancePayment->delete();

        return redirect()->route('vendor_advance_payments.vendor_advance_payment.index')
            ->with('success_message', 'Vendor Advance Payment was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'vendor_id' => 'required',
            'ledger_id' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required',
            'note' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

    public function advanceTransactions($vendorAdvancePayment)
    {
//        dd($vendorAdvancePayment->customer->ledger->id);
        Transaction::query()->where(['type' => VendorAdvancePayment::class, 'type_id' => $vendorAdvancePayment->id])->forceDelete();
        TransactionDetail::query()->where(['type' => VendorAdvancePayment::class, 'type_id' => $vendorAdvancePayment->id])->forceDelete();
        AccountingFacade::addTransaction(
            optional(optional($vendorAdvancePayment->vendor)->ledger)->id,
            $vendorAdvancePayment->ledger_id,
            $vendorAdvancePayment->amount,
            $vendorAdvancePayment->note,
            $vendorAdvancePayment->date,
            "Vendor Advance Payment",
            VendorAdvancePayment::class,
            $vendorAdvancePayment->id);
    }


}
