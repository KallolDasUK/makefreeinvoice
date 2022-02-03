<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\PosCharge;
use App\Models\PosItem;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\Product;
use App\Utils\Ability;
use Carbon\Carbon;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\Nature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PosSalesController extends Controller
{
    use TransactionTrait;


    public function pos_receipt_public(Request $request, $id)
    {
//        $id = $request->id;
//        dd($id);
        $posSale = PosSale::with('customer', 'branch', 'ledger')->withoutGlobalScope('scopeClient')->findOrFail($id);
        $client_id = $posSale->client_id;
        $settings = json_decode(MetaSetting::query()
            ->withoutGlobalScope('scopeClient')
            ->where('client_id', $client_id)
            ->pluck('value', 'key')->toJson());
        $qr_code = route('pos_sales.pos_sale.receipt', $posSale->id);
        $qr_code_style = $settings->qr_code_style ?? 'link';
        if ($qr_code_style == 'tlv') {
            $business_name = $settings->business_name ?? auth()->user()->name ?? 'Unknown Seller';

            $seller_name = '';
            $seller_name .= '1';
            $seller_name .= '' . strlen($business_name);
            $seller_name .= '' . $business_name;

            $vat_number = $settings->vat_reg ?? '123456789';
            $vat_registration = '';
            $vat_registration .= '2';
            $vat_registration .= '' . strlen($vat_number);
            $vat_registration .= '' . $vat_number;

            $creating_time = Carbon::parse($posSale->created_at);
            $invoice_date = Carbon::parse($posSale->date)->toDateString() . ' ' . $creating_time->toTimeString();
//            dd($invoice_date);
            $time_stamp = '';
            $time_stamp .= '3';
            $time_stamp .= '' . strlen($invoice_date);
            $time_stamp .= '' . $invoice_date;

            $taxable = number_format($posSale->total, 2, '.', '');
            $invoice_total = '';
            $invoice_total .= '4';
            $invoice_total .= '' . strlen($taxable);
            $invoice_total .= '' . $taxable;


            $tax = number_format($posSale->tax, 2, '.', '');
            $vat_total = '';
            $vat_total .= '5';
            $vat_total .= '' . strlen($tax);
            $vat_total .= '' . $tax;


            $qr_code = $seller_name . '' . $vat_registration . '' . $time_stamp . '' . $invoice_total . '' . $vat_total;
            $qr_code = base64_encode($qr_code);


        }

        return view('pos_sales.pos_receipt_public', compact('posSale', 'settings', 'qr_code'));
    }

    public function index()
    {


        $posSales = PosSale::with('customer', 'branch', 'ledger')->latest()->paginate(25);
        $categories = Category::all();
        $products = [];

        return view('pos_sales.index', compact('posSales', 'products', 'categories'));
    }


    public function create()
    {

        if (!Customer::query()->where('name', Customer::WALK_IN_CUSTOMER)->exists()) {
            Customer::create(['name' => Customer::WALK_IN_CUSTOMER]);
        }
        $customers = Customer::all()->makeHidden(['advance', 'receivables'])->toArray();
        $branches = Branch::pluck('id', 'id')->all();
        $ledgers = Ledger::find($this->getAssetLedgers())->toArray();
        $categories = Category::all();
        $products = Product::all()->makeHidden(['stock_value'])->all();
        $paymentMethods = PaymentMethod::all();
        $title = "POS - Point Of Sale";
        $ledger_id = Ledger::CASH_AC();
        $bookmarks = Product::query()->where('is_bookmarked', true)->get();
        $start_date = today()->toDateString();
        $end_date = today()->toDateString();
        $orders = PosSale::query()->with('customer')->whereBetween('date', [$start_date, $end_date])->latest()->get();
        $pos_numbers = PosSale::query()->select('pos_number')->get()->toArray();
//        dd($pos_numbers);
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
        } else {

        }
        $can_delete = ability(Ability::POS_DELETE);
        $p = [];
        return view('pos_sales.create', compact('customers', 'branches', 'ledgers', 'ledger_id', 'products', 'categories', 'title', 'orders',
            'paymentMethods', 'bookmarks', 'start_date', 'end_date', 'charges', 'can_delete', 'p', 'pos_numbers'));
    }

    public function getAssetLedgers()
    {
        $this->arr = [];

        $incomeLedgerGroups = LedgerGroup::query()->where('nature', Nature::$ASSET)->get();

        foreach ($incomeLedgerGroups as $group) {
            try {
                $parentBankLedger = LedgerGroup::query()->where('id', $group->id)->first();
                $this->getChildLedgerGroup($parentBankLedger->id);

            } catch (\Exception $exception) {
                dd($exception);
                return [];
            }
        }
        return $this->arr;

    }

    public function store(Request $request)
    {


        $data = $this->getData($request);
        $pos_items = $data['pos_items'];
        $pos_payments = $data['payments'];
        $pos_charges = $data['charges'];

        unset($data['pos_items']);
        unset($data['payments']);
        unset($data['charges']);

        $pos_sales = PosSale::create($data);
        foreach ($pos_items as $pos_item) {

            $pos_item->tax_id = $pos_item->tax_id == '' ? null : $pos_item->tax_id;
            $pos_item->attribute_id = ($pos_item->attribute_id ?? null) == '' ? null : $pos_item->attribute_id ?? null;
            PosItem::create(['pos_sales_id' => $pos_sales->id, 'product_id' => $pos_item->product_id,
                'price' => $pos_item->price, 'qnt' => $pos_item->qnt, 'amount' => $pos_item->amount,
                'tax_id' => $pos_item->tax_id, 'attribute_id' => $pos_item->attribute_id,
                'batch' => $pos_item->batch ?? null,
                'date' => $pos_sales->date]);
        }
        foreach ($pos_charges as $pos_charge) {
            PosCharge::create(['pos_sales_id' => $pos_sales->id, 'key' => $pos_charge->key,
                'value' => $pos_charge->value, 'amount' => $pos_charge->amount ?? 0]);
        }


        $given = collect($pos_payments)->sum('amount');
        $change = $pos_sales->total - $given;
        $pos_sales->change = 0;
//        dd($given, $change, $pos_payments,$change > 0);
        if ($change < 0) {
            $distributed = 0;
            $pos_sales->change = abs($change);
            $pos_sales->saveQuietly();
            foreach ($pos_payments as $index => $pos_payment) {
                if ($distributed == $pos_sales->total) {
                    unset($pos_payments[$index]);
                    continue;
                }

                if ($pos_payment->amount > $pos_sales->total) {
                    $pos_payments[$index]->amount = ($pos_sales->total - $distributed);

                }
                $distributed += $pos_payments[$index]->amount;
            }
        }

        foreach ($pos_payments as $pos_payment) {
            PosPayment::create([
                'pos_sales_id' => $pos_sales->id,
                'ledger_id' => $pos_payment->ledger_id ?? null,
                'amount' => $pos_payment->amount,
                'date' => $pos_sales->date ?? today()->toDateString(),
            ]);
        }
        if ($request->ajax()) {
//            dd($pos_items);
            return $pos_sales->load('pos_charges');
        }


        return redirect()->route('pos_sales.pos_sale.index')
            ->with('success_message', 'Pos Sale was successfully added.');

    }


    public function show($id)
    {
        $posSale = PosSale::with('customer', 'branch', 'ledger')->findOrFail($id);

        return view('pos_sales.show', compact('posSale'));
    }

    public function filter(Request $request)
    {
        $start_date = $request->start_date ?? today()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $pos_number = $request->pos_number;
        if ($pos_number) {
            $orders = PosSale::query()->with('customer')->where('pos_number', 'like', '%' . $pos_number . '%')->latest()->get();
        } else {
            $orders = PosSale::query()->with('customer')->whereBetween('date', [$start_date, $end_date])->latest()->get();
        }


        return $orders;
    }

    public function pay(Request $request)
    {
        $pos_id = $request->order_id;
        $pos_sales = PosSale::find($pos_id);
        $pos_payments = $request->pos_payments ?? [];
        $pos_charges = $request->pos_charges ?? [];
        $pos_payments = json_decode(json_encode($pos_payments), FALSE);
        $pos_charges = json_decode(json_encode($pos_charges), FALSE);
        PosCharge::query()->where('pos_sales_id', $pos_sales->id)->delete();

        foreach ($pos_charges as $pos_charge) {
            PosCharge::create(['pos_sales_id' => $pos_sales->id, 'key' => $pos_charge->key,
                'value' => $pos_charge->value, 'amount' => $pos_charge->amount ?? 0]);
        }

        $pos_sales->total = collect($pos_charges)->sum('amount') + $pos_sales->sub_total;
        $pos_sales->save();
        $given = collect($pos_payments)->sum('amount');
        $change = $pos_sales->due - $given;
        $pos_sales->change = 0;
//        dd($given, $change, $pos_payments,$change > 0);
        if ($change < 0) {
            $distributed = 0;
            $pos_sales->change = abs($change);
            $pos_sales->saveQuietly();
            foreach ($pos_payments as $index => $pos_payment) {
                if ($distributed == $pos_sales->due) {
                    unset($pos_payments[$index]);
                    continue;
                }

                if ($pos_payment->amount > $pos_sales->due) {
                    $pos_payments[$index]->amount = ($pos_sales->due - $distributed);

                }
                $distributed += $pos_payments[$index]->amount;
            }
        }

//        dd($pos_payments);
        foreach ($pos_payments as $pos_payment) {

            PosPayment::create([
                'pos_sales_id' => $pos_id,
                'ledger_id' => $pos_payment->ledger_id ?? null,
                'amount' => $pos_payment->amount,
                'date' => today()->toDateString(),
            ]);
        }

        return [];
    }

    public function details(Request $request)
    {
        $id = $request->pos_sales_id;
        $posSale = PosSale::with('customer', 'branch', 'ledger')->findOrFail($id);

        $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

        $qr_code = route('pos_sales.pos_sale.receipt', $posSale->id);
        $qr_code_style = $settings->qr_code_style ?? 'link';
        if ($qr_code_style == 'tlv') {
            $business_name = $settings->business_name ?? auth()->user()->name ?? 'Unknown Seller';


            $seller_name = $business_name;
            $vat_number = $settings->vat_reg ?? '123456789';
            $creating_time = Carbon::parse($posSale->created_at);
            $invoice_date = Carbon::parse($posSale->date)->toDateString() . ' ' . $creating_time->toTimeString();
            $taxable = number_format($posSale->total, 2, '.', '');
            $tax = number_format($posSale->tax, 2, '.', '');


            $dataToEncode = [
                [1, $seller_name],
                [2, $vat_number],
                [3, $invoice_date],
                [4, $taxable],
                [5, $tax]
            ];

            $__TLV = __getTLV($dataToEncode);
            $__QR = base64_encode($__TLV);
            $qr_code = $__QR;


        } elseif ($qr_code_style == 'text') {
            $business_name = $settings->business_name ?? auth()->user()->name ?? 'Unknown Seller';
            $vat_number = $settings->vat_reg ?? '123456789';
            $creating_time = Carbon::parse($posSale->created_at);
            $invoice_date = Carbon::parse($posSale->date)->toDateString() . ' ' . $creating_time->toTimeString();
            $taxable = number_format($posSale->total, 2, '.', '');
            $tax = number_format($posSale->tax, 2, '.', '');

            $qr_code = "Seller Name: $business_name Vat Reg: $vat_number Total: $taxable Tax: $tax Date and Time: $invoice_date";


        }
        return view('partials.order-details', compact('posSale', 'qr_code', 'qr_code_style'));
    }

    public function eye($id)
    {

        $posSale = PosSale::with('customer', 'branch', 'ledger', 'pos_items', 'pos_charges')->findOrFail($id);

        return $posSale;
    }


    public function edit($id)
    {
        $posSale = PosSale::findOrFail($id);
        if (!Customer::query()->where('name', Customer::WALK_IN_CUSTOMER)->exists()) {
            Customer::create(['name' => Customer::WALK_IN_CUSTOMER]);
        }
        $customers = Customer::all()->makeHidden(['advance', 'receivables'])->toArray();
        $branches = Branch::pluck('id', 'id')->all();
        $ledgers = Ledger::find($this->getAssetLedgers())->toArray();
        $categories = Category::all();
        $products = Product::all()->makeHidden(['stock_value'])->all();
        $paymentMethods = PaymentMethod::all();
        $title = "Edit POS - " . $posSale->pos_number;
        $ledger_id = Ledger::CASH_AC();
        $bookmarks = Product::query()->where('is_bookmarked', true)->get();
        $start_date = today()->toDateString();
        $end_date = today()->toDateString();
        $orders = PosSale::query()->with('customer')->whereBetween('date', [$start_date, $end_date])->latest()->get();
        $pos_numbers = PosSale::query()->select('pos_number')->get()->toArray();
//        dd($pos_numbers);
        $charges = $posSale->pos_charges;
        if (count(PosSale::query()->get()) > 0) {
            $last_order = PosSale::query()->get()->last();
            $pos_charges = $last_order->pos_charges()->select('key', 'value')->get()->toArray();
            foreach ($pos_charges as $index => $pos_charge) {
                if (Str::contains(strtolower($pos_charge['key']), 'discount')) {
                    $pos_charges[$index]['value'] = '';
                }
            }
            $charges = $pos_charges;
        } else {

        }
        $can_delete = ability(Ability::POS_DELETE);
        $p = [];
        $pos_items = $posSale->pos_items()->with('product')->get()->toArray();
//        dd();
        return view('pos_sales.edit', compact('posSale', 'customers', 'branches', 'ledgers', 'ledgers', 'customers', 'branches', 'ledgers', 'ledger_id', 'products', 'categories', 'title', 'orders',
            'paymentMethods', 'bookmarks', 'start_date',
            'end_date', 'charges', 'can_delete', 'p', 'pos_numbers', 'pos_items'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $posSale = PosSale::findOrFail($id);
        $posSale->update($data);

        return redirect()->route('pos_sales.pos_sale.index')
            ->with('success_message', 'Pos Sale was successfully updated.');

    }


    public function destroy($id)
    {

        $posSale = PosSale::findOrFail($id);
        PosItem::query()->where('pos_sales_id', $posSale->id)->delete();
        PosCharge::query()->where('pos_sales_id', $posSale->id)->delete();
        PosPayment::query()->where('pos_sales_id', $posSale->id)->get()->each(function ($model) {
            $model->delete();
        });
        $posSale->delete();

        if (\request()->ajax()) {
            return [];
        }

        return redirect()->route('pos_sales.pos_sale.index')
            ->with('success_message', 'Pos Sale was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'date' => 'nullable|string|min:0',
            'customer_id' => 'nullable',
            'branch_id' => 'nullable',
            'ledger_id' => 'nullable',
            'note' => 'string|min:1|max:1000|nullable',
            'payment_method_id' => 'nullable',
            'sub_total' => 'string|min:1|nullable',
            'total' => 'numeric|nullable',
            'pos_status' => 'string|min:1|nullable',
            'pos_items' => 'nullable',
            'payments' => 'nullable',
            'charges' => 'nullable',
        ];

        $data = $request->validate($rules);
        $data['pos_items'] = json_decode($data['pos_items'] ?? '{}');
        $data['payments'] = json_decode($data['payments'] ?? '{}');
        $data['charges'] = json_decode($data['charges'] ?? '{}');
        $data['pos_number'] = PosSale::nextOrderNumber();
        $data['date'] = $data['date'] ?? today()->toDateString();

        return $data;
    }

}
