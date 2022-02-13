<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\Category;
use App\Models\ContactInvoice;
use App\Models\ContactInvoicePayment;
use App\Models\ContactInvoicePaymentItem;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\PaymentRequest;
use App\Models\PosItem;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\Product;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\SalesReturn;
use App\Models\User;
use App\Models\Vendor;
use App\Utils\Ability;
use Carbon\Carbon;
use Cassandra\Custom;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    use TransactionTrait;

    public function receivePaymentCustomerInvoice(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        $invoices = Invoice::query()
            ->where('customer_id', $customer->id)
            ->where('payment_status', '!=', Invoice::Paid)
            ->get()->filter(function ($sale) {
                return $sale->due > 0;
            });

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
            ->get()->filter(function ($sale) {
                return $sale->due > 0;
            });


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

    public function storeContactInvoiceInfo(Request $request)
    {
        $customer_id = $request->customer_id;
        $customer = Customer::find($customer_id);
        $contact_invoice_id = $request->contact_invoice_id;
        $contact_invoice = ContactInvoice::find($contact_invoice_id);
        MetaSetting::query()->updateOrCreate(['key' => 'supplier_name_ar'], ['value' => $request->supplier_name_ar]);
        MetaSetting::query()->updateOrCreate(['key' => 'supplier_address_ar'], ['value' => $request->supplier_address_ar]);
        MetaSetting::query()->updateOrCreate(['key' => 'supplier_vat_ar'], ['value' => $request->supplier_vat_ar]);
        if ($customer) {
            $customer->customer_name_ar = $request->supplier_name_ar;
            $customer->customer_address_ar = $request->customer_address_ar;
            $customer->save();
        }
        if ($contact_invoice_id) {
            $contact_invoice->subject_ar = $request->subject_ar;
            $contact_invoice->month_ar = $request->month_ar;
            $contact_invoice->save();
        }

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

    public function contactInvoicePayment(Request $request)
    {

//       return dd($request->all());
        $request->validate(['payment_date' => 'required', 'invoice_id' => 'required']);
        $paymentSerial = 'CIPM' . str_pad(ReceivePayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $invoice = ContactInvoice::find($request->invoice_id);
        $payment = ContactInvoicePayment::create([
            'contact_invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'payment_method_id' => $invoice->payment_method_id,
            'ledger_id' => $invoice->deposit_to,
            'payment_sl' => $paymentSerial,
            'note' => $invoice->notes,
            'payment_date' => $invoice->invoice_date
        ]);

        ContactInvoicePaymentItem::create(['contact_invoice_payment_id' => $payment->id, 'contact_invoice_id' => $invoice->id, 'amount' => $request->amount]);
        session()->flash('success_message', 'Payment Recorded Successfully for Tax Invoice ' . $invoice->invoice_number);
        return ['success_message' => 'Payment Recorded Successfully for Tax Invoice ' . $invoice->invoice_number, 'id' => $payment->id];

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
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        return ['overdue' => decent_format_dash_if_zero(Invoice::overdue($start_date, $end_date)),
            'draft' => decent_format_dash_if_zero(Invoice::draft($start_date, $end_date)),
            'paid' => decent_format_dash_if_zero(Invoice::paid($start_date, $end_date)),
            'due' => decent_format_dash_if_zero(Invoice::due($start_date, $end_date)),
            'total' => decent_format_dash_if_zero(Invoice::total($start_date, $end_date))];

    }

    public function bill_summary(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $bills = Bill::query()
            ->when($start_date != null && $end_date != null, function ($query) use ($start_date, $end_date) {
                $start_date = Carbon::parse($start_date)->toDateString();
                $end_date = Carbon::parse($end_date)->toDateString();
                return $query->whereBetween('bill_date', [$start_date, $end_date]);
            })
            ->latest();
        $totalAmount = $bills->get()->sum('total');
        $totalDue = $bills->get()->sum('due');
        $totalPaid = $bills->get()->sum('paid');
        return ['total_amount' => decent_format_dash_if_zero($totalAmount),
            'total_due' => decent_format_dash_if_zero($totalDue),
            'total_paid' => decent_format_dash_if_zero($totalPaid)];
    }


    public function today_report()
    {
        $today_sale = Invoice::query()->where('invoice_date', today()->toDateString())->sum('total');
        $today_sale += PosSale::query()->where('date', today()->toDateString())->sum('total');
        $today_sale = decent_format_dash_if_zero($today_sale);

        $due_sale = Invoice::query()->where('invoice_date', today()->toDateString())->get()->sum('due');
        $due_sale += PosSale::query()->where('date', today()->toDateString())->get()->sum('due');
        $due_sale = decent_format_dash_if_zero($due_sale);

        $due_collection = ReceivePayment::query()->where('payment_date', today()->toDateString())->get()->sum('amount');
        $due_collection += PosPayment::query()->where('date', today()->toDateString())->sum('amount');
        $due_collection = decent_format_dash_if_zero($due_collection);


        $due_payment = BillPayment::query()->where('payment_date', today()->toDateString())->get()->sum('amount');
        $due_payment = decent_format_dash_if_zero($due_payment);

        $expense = Expense::query()->where('date', today()->toDateString())->get()->sum('amount');
        $expense = decent_format_dash_if_zero($expense);

        $cash = optional(Ledger::find(Ledger::CASH_AC()))->balance;
        $cash = decent_format_dash_if_zero($cash ?? 0);

        return view('partials.today-report', compact('today_sale', 'due_sale', 'due_collection', 'due_payment', 'expense', 'cash'));
    }

    public function withdrawFund(Request $request)
    {
        PaymentRequest::create([
            'date' => today()->toDateString(),
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'Processing',
            'note' => $request->payment_method
        ]);
        return [];
    }

    public function posCreateData()
    {
        $customers = Customer::all()->makeHidden(['advance', 'receivables'])->toArray();
        $branches = Branch::pluck('id', 'id')->all();
        $ledgers = Ledger::find($this->getAssetLedgers())->toArray();
        $categories = Category::all();
        $products = Product::all()->makeHidden(['stock', 'short_name', 'stock_value', 'image']);
        $paymentMethods = PaymentMethod::all();
        $title = "POS - Point Of Sale";
        $ledger_id = Ledger::CASH_AC();
        $bookmarks = Product::query()->where('is_bookmarked', true)->get();
        $start_date = today()->toDateString();
        $end_date = today()->toDateString();
        $orders = PosSale::query()->whereBetween('date', [$start_date, $end_date])->latest()->get();
        $charges = [['key' => 'Discount', 'Value' => ''], ['key' => '', 'Value' => '']];
        if (count(PosSale::query()->get()) > 0) {
            $last_order = PosSale::query()->get()->last();
            $pos_charges = $last_order->pos_charges()->select('key', 'value')->get()->toArray();
            foreach ($pos_charges as $index => $pos_charge) {
                if (Str::contains(strtolower($pos_charge['key']), 'discount')) {
                    $pos_charges[$index]['value'] = '';
                }
            }
            $charges = $pos_charges;
//            dd($pos_charges);
        } else {

        }
//        dd($ledgers);

        $can_delete = ability(Ability::POS_DELETE);

//        return ['customers' => $customers];

        return compact('customers', 'branches', 'ledgers', 'ledger_id', 'products', 'categories', 'title', 'orders',
            'paymentMethods', 'bookmarks', 'start_date', 'end_date', 'charges', 'can_delete');
    }

    public function toggleAdSettings(Request $request)
    {
        $show_ads = $request->show_ads;
        $user = User::find($request->user_id);
        $updated = MetaSetting::withoutGlobalScope('scopeClient')
            ->where('client_id', $user->client_id)
            ->updateOrCreate(['key' => 'ads', 'client_id' => $user->client_id], ['value' => $show_ads, 'client_id' => $user->client_id]);
        return [$user->settings];

    }

    public function productBatch(Request $request)
    {
        $product_id = $request->product_id;
        $bill_items = BillItem::query()->where('product_id', $product_id)->whereNotNull('batch')->get();
        $records = [];
        foreach ($bill_items as $bill_item) {
            $sold_qnt_from_batch = InvoiceItem::query()->where(['product_id' => $product_id, 'batch' => $bill_item->batch])->sum('qnt');
            $sold_qnt_from_batch_pos = PosItem::query()->where(['product_id' => $product_id, 'batch' => $bill_item->batch])->sum('qnt');
//            dump($sold_qnt_from_batch_pos);
            $remaining_qnt = $bill_item->qnt - ($sold_qnt_from_batch + $sold_qnt_from_batch_pos);
            if ($remaining_qnt > 0) {
                $records[] = $bill_item->batch;
            }
        }
//        dd('');

        return $records;

    }
}
