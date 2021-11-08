<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\PosCharge;
use App\Models\PosItem;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\Product;
use App\Utils\Ability;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\Nature;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;

class PosSalesController extends Controller
{
    use TransactionTrait;

    public function index()
    {


        $posSales = PosSale::with('customer', 'branch', 'ledger')->latest()->paginate(25);
        $categories = Category::all();
        $products = [];

        return view('pos_sales.index', compact('posSales', 'products', 'categories'));
    }


    public function create()
    {

//        $p = PosSale::find(51)->load('pos_charges');
//        dd($p);
        if (!Customer::query()->where('name', Customer::WALK_IN_CUSTOMER)->exists()) {
            Customer::create(['name' => Customer::WALK_IN_CUSTOMER]);
        }
        $customers = Customer::all();
        $branches = Branch::pluck('id', 'id')->all();
        $ledgers = Ledger::find($this->getAssetLedgers())->toArray();
        $categories = Category::all();
        $products = Product::all();
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
        return view('pos_sales.create',
            compact('customers', 'branches', 'ledgers', 'ledger_id', 'products', 'categories', 'title', 'orders',
                'paymentMethods', 'bookmarks', 'start_date', 'end_date', 'charges', 'can_delete'));
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
        $orders = PosSale::query()->whereBetween('date', [$start_date, $end_date])->latest()->get();


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

        return view('partials.order-details', compact('posSale'));
    }

    public function eye($id)
    {

        $posSale = PosSale::with('customer', 'branch', 'ledger', 'pos_items', 'pos_charges')->findOrFail($id);

        return $posSale;
    }


    public function edit($id)
    {
        $posSale = PosSale::findOrFail($id);
        $customers = Customer::pluck('name', 'id')->all();
        $branches = Branch::pluck('id', 'id')->all();
        $ledgers = Ledger::pluck('id', 'id')->all();
        $ledgers = PaymentMethod::pluck('id', 'id')->all();

        return view('pos_sales.edit', compact('posSale', 'customers', 'branches', 'ledgers', 'ledgers'));
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
