<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IngredientItem;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductionItem;
use Illuminate\Http\Request;
use Exception;

class ProductionsController extends Controller
{


    public function index()
    {
        view()->share('title', 'My Productions');
        $productions = Production::query()->latest()->paginate(10);

        return view('productions.index', compact('productions'));
    }


    public function create()
    {
        view()->share('title', 'New Production');
        $products = Product::all();
        $next_ref = Production::nextRef();
        return view('productions.create', compact('products', 'next_ref'));
    }


    public function store(Request $request)
    {
        $data = $this->getData($request);


        $production = Production::create($data);
        $this->add_items_to_database($request, $production);
        return redirect()->route('productions.production.index')->with('success_message', 'Production was successfully added.');

    }

    public function add_items_to_database(Request $request, $production)
    {

        ProductionItem::query()->where('production_id', $production->id)->delete();
        IngredientItem::query()->where('production_id', $production->id)->delete();

        $production_items = json_decode($request->production_items ?? '{}');
        $used_items = json_decode($request->used_items ?? '{}');
        foreach ($production_items as $production_item) {
            ProductionItem::create(['production_id' => $production->id, 'product_id' => $production_item->product_id, 'qnt' => $production_item->qnt, 'date' => $production->date]);
        }
        foreach ($used_items as $used_item) {
            IngredientItem::create(['production_id' => $production->id, 'product_id' => $used_item->product_id, 'qnt' => $used_item->qnt, 'date' => $production->date]);
        }
    }

    public function show($id)
    {
        $production = Production::findOrFail($id);

        return view('productions.show', compact('production'));
    }


    public function edit($id)
    {
        $production = Production::findOrFail($id);
        $products = Product::all();
//        dd($production->production_items);
        $next_ref = Production::nextRef();

        return view('productions.edit', compact('production', 'products', 'next_ref'));
    }

    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $production = Production::findOrFail($id);
        $production->update($data);
        $this->add_items_to_database($request, $production);
        return redirect()->route('productions.production.index')
            ->with('success_message', 'Production was successfully updated.');

    }


    public function destroy($id)
    {

        $production = Production::findOrFail($id);
        ProductionItem::query()->where('production_id', $production->id)->delete();
        IngredientItem::query()->where('production_id', $production->id)->delete();
        $production->delete();

        return redirect()->route('productions.production.index')
            ->with('success_message', 'Production was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'ref' => 'string|min:1|nullable',
            'date' => 'required|nullable|string|min:1',
            'status' => 'required|nullable',
            'note' => 'nullable'
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
