<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\PaymentMethod;
use App\Models\Vendor;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\EntryType;
use Illuminate\Http\Request;
use Exception;

class BillPaymentsController extends Controller
{
    use TransactionTrait;


    public function index( Request $request)
    {
        $title = "Bill Payments";
        $vendor_id = $request->vendor_id;
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $vendors = Vendor::all();
        $billPayments = BillPayment::with('vendor', 'ledger')
            ->when($vendor_id != null, function ($query) use ($vendor_id) {
                return $query->where('vendor_id', $vendor_id);
            })
            ->whereBetween('payment_date', [$start_date, $end_date])
            ->latest()->paginate(25);

//        $billPayments = BillPayment::with('vendor',  'bill', 'paymentmethod', 'ledger')
//            ->latest()
//            ->paginate(25);
        return view('bill_payments.index', compact('billPayments', 'vendors', 'vendor_id', 'start_date', 'end_date', 'title'));

//        return view('bill_payments.index', compact('billPayments', 'title'));
    }


    public function create()
    {
        $paymentSerial = 'VPM' . str_pad(BillPayment::query()->count(), 3, '0', STR_PAD_LEFT);
        $title = "Pay Bill";
        $vendors = Vendor::pluck('name', 'id')->all();
        $bills = Bill::pluck('bill_number', 'id')->all();
        $paymentMethods = PaymentMethod::query()->get();
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $vendor_id = \request()->get('vendor_id');
        $ledgers = Ledger::pluck('id', 'id')->all();
        $ledgerGroups = LedgerGroup::all();

        return view('bill_payments.create', compact('vendors', 'ledgerGroups', 'title', 'bills', 'paymentMethods', 'ledgers', 'paymentSerial', 'depositAccounts', 'vendor_id'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $billPayment = BillPayment::create($data);
        $payments = json_decode($request->data ?? '{}');
        foreach ($payments as $payment) {
            try {
                BillPaymentItem::create(['bill_id' => $payment->bill_id, 'bill_payment_id' => $billPayment->id, 'amount' => $payment->amount]);
            } catch (\Exception $exception) {

            }
        }
        $this->storePreviousDue($request, $billPayment);

        return redirect()->route('bill_payments.bill_payment.index')
            ->with('success_message', 'Bill Payment was successfully added.');

    }

    public function storePreviousDue($request, $billPayment)
    {



        if ($request->has('previous_due')) {
            $vendor = Vendor::find($billPayment->vendor_id);
            $previous_due = $request->previous_due;
            AccountingFacade::addTransaction(optional($vendor->ledger)->id, $billPayment->ledger_id,
                $previous_due, EntryType::$OPENING_BALANCE, $billPayment->payment_date, "Vendor Payment",
                Ledger::class, optional($vendor->ledger)->id, $billPayment->payment_sl, $vendor->name);

        }
    }

    public function show($id)
    {
        $billPayment = BillPayment::with('vendor', 'bill', 'paymentmethod', 'ledger')->findOrFail($id);

        return view('bill_payments.show', compact('billPayment'));
    }


    public function edit($id)
    {
        $title = "Edit Pay Bill";

        $billPayment = BillPayment::findOrFail($id);
        $vendors = Vendor::pluck('name', 'id')->all();
        $bills = Bill::pluck('bill_number', 'id')->all();
        $paymentMethods = PaymentMethod::query()->get();
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $ledgerGroups = LedgerGroup::all();

        return view('bill_payments.edit', compact('billPayment', 'ledgerGroups', 'title', 'vendors', 'bills', 'paymentMethods', 'depositAccounts'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $billPayment = BillPayment::findOrFail($id);
        $vendor = $billPayment->vendor;

        TransactionDetail::query()->where([
            'type' => Ledger::class,
            'type_id' => optional($vendor->ledger)->id,
            'amount' => $billPayment->previous_due,
            'ref' => $billPayment->payment_sl
        ])->forceDelete();

        $billPayment->update($data);
        BillPaymentItem::query()->where('bill_payment_id', $billPayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        $payments = json_decode($request->data ?? '{}');
        foreach ($payments as $payment) {
            try {
                BillPaymentItem::create(['bill_id' => $payment->bill_id, 'bill_payment_id' => $billPayment->id, 'amount' => $payment->amount]);
            } catch (\Exception $exception) {

            }
        }
        $this->storePreviousDue($request, $billPayment);

        return redirect()->route('bill_payments.bill_payment.index')
            ->with('success_message', 'Bill Payment was successfully updated.');

    }

    public function destroy($id)
    {

        $billPayment = BillPayment::findOrFail($id);
        BillPaymentItem::query()->where('bill_payment_id', $billPayment->id)->get()->each(function ($model) {
            $model->delete();
        });
        $vendor = $billPayment->vendor;

        TransactionDetail::query()->where([
            'type' => Ledger::class,
            'type_id' => optional($vendor->ledger)->id,
            'amount' => $billPayment->previous_due,
            'ref' => $billPayment->payment_sl
        ])->forceDelete();


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
            'previous_due' => 'nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
