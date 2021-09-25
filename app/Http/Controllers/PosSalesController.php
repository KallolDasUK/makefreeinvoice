<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Customer;
use App\Models\PaymentMethod;
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
        if (!Customer::query()->where('name', Customer::WALK_IN_CUSTOMER)->exists()){
            Customer::create(['name' => Customer::WALK_IN_CUSTOMER]);
        }
        $customers = Customer::all();
        $branches = Branch::pluck('id', 'id')->all();
        $ledgers = Ledger::pluck('id', 'id')->all();
        $ledgers = PaymentMethod::pluck('id', 'id')->all();
        $categories = Category::all();
        $products = Product::all();
        return view('pos_sales.create', compact('customers', 'branches', 'ledgers', 'ledgers', 'products', 'categories'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        PosSale::create($data);

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
        $posSale->delete();
        return redirect()->route('pos_sales.pos_sale.index')
            ->with('success_message', 'Pos Sale was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'pos_number' => 'nullable|string|min:0',
            'date' => 'nullable|string|min:0',
            'customer_id' => 'nullable',
            'branch_id' => 'nullable',
            'ledger_id' => 'nullable',
            'discount_type' => 'nullable',
            'discount' => 'numeric|nullable',
            'vat' => 'nullable|numeric',
            'service_charge_type' => 'nullable',
            'service_charge' => 'nullable|numeric',
            'note' => 'string|min:1|max:1000|nullable',
            'payment_method_id' => 'nullable',
            'sub_total' => 'string|min:1|nullable',
            'total' => 'numeric|nullable',
            'payment_amount' => 'string|min:1|nullable',
            'due' => 'string|min:1|nullable',
            'pos_status' => 'string|min:1|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
