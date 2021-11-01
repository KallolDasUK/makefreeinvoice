<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockEntryItem;
use Illuminate\Http\Request;
use Exception;

class StockEntriesController extends Controller
{

    public function index()
    {
        view()->share('title', 'Stock Entries');
        $stockEntries = StockEntry::with('brand', 'category', 'product')->paginate(25);
        return view('stock_entries.index', compact('stockEntries'));
    }


    public function create()
    {
        view()->share('title', 'Stock Entry');
        $brands = Brand::pluck('name', 'id')->all();
        $categories = Category::pluck('name', 'id')->all();
        $products = Product::all();

        return view('stock_entries.create', compact('brands', 'categories', 'products'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
        $stockEntry = StockEntry::create($data);
        $this->add_items_to_db($request, $stockEntry);

        return redirect()->route('stock_entries.stock_entry.index')->with('success_message', 'Stock Entry was successfully added.');

    }


    public function show($id)
    {
        $stockEntry = StockEntry::with('brand', 'category', 'product')->findOrFail($id);

        return view('stock_entries.show', compact('stockEntry'));
    }


    public function edit($id)
    {
        $stockEntry = StockEntry::findOrFail($id);
        $brands = Brand::pluck('name', 'id')->all();
        $categories = Category::pluck('name', 'id')->all();
        $products = Product::all();
        return view('stock_entries.edit', compact('stockEntry', 'brands', 'categories', 'products'));
    }


    public function update($id, Request $request)
    {

        $data = $this->getData($request);
        $stockEntry = StockEntry::findOrFail($id);
        $stockEntry->update($data);
        $this->add_items_to_db($request, $stockEntry);

        return redirect()->route('stock_entries.stock_entry.index')
            ->with('success_message', 'Stock Entry was successfully updated.');

    }

    public function add_items_to_db(Request $request, $stock_entry)
    {

        StockEntryItem::query()->where('stock_entry_id', $stock_entry->id)->delete();

        $items = json_decode($request->items ?? '{}');
//        dd($items);

        foreach ($items as $item) {
            if (!$item->qnt) continue;
            StockEntryItem::create(['stock_entry_id' => $stock_entry->id,
                'date' => $stock_entry->date,
                'product_id' => $item->product_id,
                'qnt' => $item->qnt]);
        }
    }

    public function destroy($id)
    {

        $stockEntry = StockEntry::findOrFail($id);
        StockEntryItem::query()->where('stock_entry_id', $stockEntry->id)->delete();

        $stockEntry->delete();

        return redirect()->route('stock_entries.stock_entry.index')
            ->with('success_message', 'Stock Entry was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'ref' => 'string|min:1|nullable',
            'date' => 'nullable',
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'product_id' => 'nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
