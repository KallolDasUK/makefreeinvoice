<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\PosCharge;
use App\Models\PosItem;
use App\Models\PosSale;
use App\Models\Product;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Illuminate\Http\Request;
use Exception;

class PosSalesController extends Controller
{


    public function index()
    {
        $posSales = PosSale::with('customer', 'branch', 'ledger')->paginate(25);
        $categories = Category::all();
        $products = Product::all();

        return view('pos_sales.index', compact('posSales', 'products', 'categories'));
    }


    public function create()
    {
        if (!Customer::query()->where('name', Customer::WALK_IN_CUSTOMER)->exists()) {
            Customer::create(['name' => Customer::WALK_IN_CUSTOMER]);
        }
        $customers = Customer::all();
        $branches = Branch::pluck('id', 'id')->all();
        $ledgers = Ledger::pluck('id', 'id')->all();
        $ledgers = PaymentMethod::pluck('id', 'id')->all();
        $categories = Category::all();
        $products = Product::all();
        $title = "POS - Point Of Sale";
        $orders = PosSale::query()->latest()->limit(50)->get();
//        dd($orders);
        return view('pos_sales.create', compact('customers', 'branches', 'ledgers', 'ledgers', 'products', 'categories', 'title', 'orders'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
        $pos_items = $data['pos_items'];
        $pos_charges = $data['charges'];

        unset($data['pos_items']);
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
            PosCharge::create(['pos_sales_id' => $pos_sales->id, 'key' => $pos_charge->key, 'value' => $pos_charge->value]);
        }
        if ($request->ajax()) {
            return $pos_sales;
        }


        return redirect()->route('pos_sales.pos_sale.index')
            ->with('success_message', 'Pos Sale was successfully added.');

    }


    public function show($id)
    {
        $posSale = PosSale::with('customer', 'branch', 'ledger')->findOrFail($id);

        return view('pos_sales.show', compact('posSale'));
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
        $posSale->delete();
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
            'charges' => 'nullable',
        ];

        $data = $request->validate($rules);
        $data['pos_items'] = json_decode($data['pos_items'] ?? '{}');
        $data['charges'] = json_decode($data['charges'] ?? '{}');
        $data['pos_number'] = PosSale::nextOrderNumber();

        return $data;
    }

}
