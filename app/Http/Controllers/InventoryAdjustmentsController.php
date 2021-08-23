<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InventoryAdjustment;
use App\Models\InventoryAdjustmentItem;
use App\Models\Product;
use App\Models\Reason;
use Enam\Acc\Models\Ledger;
use Illuminate\Http\Request;
use Exception;

class InventoryAdjustmentsController extends Controller
{


    public function index()
    {

        $inventoryAdjustments = InventoryAdjustment::with('ledger', 'reason')->latest()->paginate(25);
        return view('inventory_adjustments.index', compact('inventoryAdjustments'));
    }

    public function create()
    {
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $products = Product::all();
        $reasons = Reason::all();
        $ref = InventoryAdjustment::nextNumber();

        return view('inventory_adjustments.create', compact('ledgers', 'products', 'ref', 'reasons'));
    }


    public function store(Request $request)
    {
        $data = $this->getData($request);
        $inventory_adjustment_items = $data['inventory_adjustment_items'];
        unset($data['inventory_adjustment_items']);
//        dd($inventory_adjustment_items,$data);
        $inventory_adjustment = InventoryAdjustment::create($data);
        foreach ($inventory_adjustment_items as $item) {
            if ($item->reason_id == '') {
                $item->reason_id = null;
            }
            if ($item->type == 'add') {
                $item->sub_qnt = 0;
            }
            if ($item->type == 'sub') {
                $item->add_qnt = 0;
            }
            InventoryAdjustmentItem::create(['product_id' => $item->product_id,
                'reason_id' => $item->reason_id, 'type' => $item->type,
                'inventory_adjustment_id' => $inventory_adjustment->id,
                'add_qnt' => $item->add_qnt, 'sub_qnt' => $item->sub_qnt,
                'date' => $inventory_adjustment->date]);
        }

        return redirect()->route('inventory_adjustments.inventory_adjustment.index')
            ->with('success_message', 'Inventory Adjustment was successfully added.');

    }


    public function show($id)
    {
        $inventoryAdjustment = InventoryAdjustment::with('ledger')->findOrFail($id);
//        dd($inventoryAdjustment->inventory_adjustment_items);
        return view('inventory_adjustments.show', compact('inventoryAdjustment'));
    }


    public function edit($id)
    {
        $inventoryAdjustment = InventoryAdjustment::findOrFail($id);
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $products = Product::all();
        $reasons = Reason::all();
        return view('inventory_adjustments.edit', compact('inventoryAdjustment', 'ledgers', 'reasons', 'products'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);
        $inventory_adjustment_items = $data['inventory_adjustment_items'];
        unset($data['inventory_adjustment_items']);

        $inventoryAdjustment = InventoryAdjustment::findOrFail($id);
        InventoryAdjustmentItem::query()->where('inventory_adjustment_id', $inventoryAdjustment->id)->delete();
        foreach ($inventory_adjustment_items as $item) {
            if ($item->type == 'add') {
                $item->sub_qnt = 0;
            }
            if ($item->type == 'sub') {
                $item->add_qnt = 0;
            }
            InventoryAdjustmentItem::create(['product_id' => $item->product_id,
                'reason_id' => $item->reason_id, 'type' => $item->type,
                'inventory_adjustment_id' => $inventoryAdjustment->id,
                'add_qnt' => $item->add_qnt, 'sub_qnt' => $item->sub_qnt,
                'date' => $inventoryAdjustment->date
                ]);
        }

        $inventoryAdjustment->update($data);

        return redirect()->route('inventory_adjustments.inventory_adjustment.index')
            ->with('success_message', 'Inventory Adjustment was successfully updated.');

    }


    public function destroy($id)
    {

        $inventoryAdjustment = InventoryAdjustment::findOrFail($id);
        InventoryAdjustmentItem::query()->where('inventory_adjustment_id', $inventoryAdjustment->id)->delete();

        $inventoryAdjustment->delete();

        return redirect()->route('inventory_adjustments.inventory_adjustment.index')
            ->with('success_message', 'Inventory Adjustment was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'date' => 'required|nullable|string|min:1',
            'ref' => 'string|min:1|nullable',
            'ledger_id' => 'required|nullable',
            'reason_id' => 'nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'inventory_adjustment_items' => 'nullable',
        ];

        $data = $request->validate($rules);
        $data['inventory_adjustment_items'] = json_decode($data['inventory_adjustment_items'] ?? '{}');
        return $data;
    }

}
