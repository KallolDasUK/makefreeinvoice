<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\MetaSetting;
use App\Models\Product;
use App\Models\ProductUnit;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\EntryType;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use TransactionTrait;

    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        $brands = Brand::pluck('name', 'id')->all();
        $units = ProductUnit::all();
        return view('products.create', compact('categories', 'units', 'brands'));
    }

    public function barcode_size(Request $request)
    {
        MetaSetting::query()->updateOrCreate(['key' => 'barcode_height'], ['value' => $request->height]);
        MetaSetting::query()->updateOrCreate(['key' => 'barcode_width'], ['value' => $request->width]);

        return [];
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);

        $product = Product::create($data);
        if ($product->opening_stock_price) {
            $this->storeOpeningStock($product, $product->opening_stock_price, EntryType::$DR);
        }
        if ($request->ajax()) {
            return $product;
        }

        return redirect()->route('products.product.index')
            ->with('success_message', 'Product was successfully added.');

    }

    protected function storeOpeningStock(Product $product, $amount, $entry_type)
    {
        $inventory_ledger_id = Ledger::INVENTORY_AC();
        $ledger = Ledger::find($inventory_ledger_id);

        $txn = Transaction::where('txn_type', EntryType::$OPENING_STOCK)->where('type', Product::class)->where('type_id', $product->id)->first();
        if ($txn) {
            $txn
                ->update(['amount' => $amount, 'type' => Product::class,
                    'type_id' => $product->id]);

            TransactionDetail::where('transaction_id', $txn->id)
                ->update(['entry_type' => $entry_type, 'amount' => $amount, 'type' => Product::class,
                    'type_id' => $product->id, 'ref' => $product->name]);
        } else {
            $voucher_no = $this->getVoucherID();
            $txn = Transaction::create(['ledger_name' => $ledger->ledger_name, 'voucher_no' => $voucher_no,
                'amount' => $amount, 'note' => EntryType::$OPENING_STOCK, 'txn_type' => EntryType::$OPENING_STOCK, 'type' => Product::class,
                'type_id' => $product->id, 'date' => today()->toDateString()]);

            TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $ledger->id, 'entry_type' => $entry_type, 'amount' => $amount,
                'voucher_no' => $voucher_no, 'date' => today()->toDateString(), 'note' => EntryType::$OPENING_STOCK, 'type' => Product::class,
                'type_id' => $product->id, 'ref' => $product->name]);

        }

    }


    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        if (\request()->ajax()) {
            return $product;
        }
        return view('products.show', compact('product'));
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::pluck('name', 'id')->all();
        $units = ProductUnit::all();
        $brands = Brand::pluck('name', 'id')->all();

        return view('products.edit', compact('product', 'categories', 'units', 'brands'));
    }

    public function barcode()
    {
        view()->share('title', 'Print Barcode');
        $products = Product::all();
        return view('products.barcode', compact('products'));
    }

    public function bookmark(Request $request)
    {

        $product_id = $request->get('product_id');
        if ($product_id) {
            $product = Product::find(intval($product_id));
//            dd($product_id,$request->all(),$product);
            $product->is_bookmarked = !$product->is_bookmarked;
            $product->save();

        }
        $products = Product::query()->where('is_bookmarked', true)->get();

        return $products;
    }


    public function updateBarcode($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->code = $request->code;
        $product->save();

        return [];
    }

    public function update($id, Request $request)
    {


        $data = $this->getData($request, $id);

        $product = Product::findOrFail($id);
        $product->update($data);
        if ($product->opening_stock_price) {
            $this->storeOpeningStock($product, $product->opening_stock_price, EntryType::$DR);
        } else {
            Transaction::where('type', Product::class)->where('type_id', $product->id)->delete();
            TransactionDetail::where('type', Product::class)->where('type_id', $product->id)->delete();
        }
        return redirect()->route('products.product.index')
            ->with('success_message', 'Product was successfully updated.');

    }


    public function destroy($id)
    {

        $product = Product::findOrFail($id);
        Transaction::where('type', Product::class)->where('type_id', $product->id)->delete();
        TransactionDetail::where('type', Product::class)->where('type_id', $product->id)->delete();
        $product->delete();

        return redirect()->route('products.product.index')
            ->with('success_message', 'Product was successfully deleted.');

    }


    protected function getData(Request $request, $id = null)
    {
        $rules = [
            'product_type' => 'required|nullable',
            'name' => 'required|nullable|string',
            'code' => 'nullable|string|unique:products,code',
            'sku' => 'nullable|string|min:0|max:255',
            'photo' => ['file', 'nullable'],
            'category_id' => 'nullable',
            'brand_id' => 'nullable',
            'sell_price' => 'required|nullable|numeric',
            'sell_unit' => 'nullable',
            'purchase_price' => 'nullable|numeric',
            'purchase_unit' => 'nullable',
            'description' => 'nullable|string|min:0|max:1000',
            'is_track' => 'boolean|nullable',
            'opening_stock' => 'string|min:1|nullable|numeric',
            'opening_stock_price' => 'nullable|numeric',
        ];
        if ($id) {

            $rules['code'] = 'nullable|string|unique:products,code,' . $id;
        }
//        dd($request->all());

        $data = $request->validate($rules);
        if ($request->has('custom_delete_photo')) {
            $data['photo'] = null;
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->moveFile($request->file('photo'));
        }
        if (array_key_exists('category_id', $data)) {
            if (!is_numeric($data['category_id'])) {
                $exiting_category = Category::query()->where('name', $data['category_id'])->first();
                if ($exiting_category) {
                    $data['category_id'] = $exiting_category->id;
                } else {
                    $data['category_id'] = Category::create(['name' => $data['category_id']])->id;
                }
            }
        }
        if (array_key_exists('brand_id', $data)) {
            if (!is_numeric($data['brand_id'])) {
                $exiting_brand = Brand::query()->where('name', $data['brand_id'])->first();
                if ($exiting_brand) {
                    $data['brand_id'] = $exiting_brand->id;
                } else {
                    $data['brand_id'] = Brand::create(['name' => $data['brand_id']])->id;
                }
            }
        }
        if (array_key_exists('sell_unit', $data)) {
            ProductUnit::query()->firstOrCreate(['name' => $data['sell_unit']], ['name' => $data['sell_unit']]);
        }
        if (array_key_exists('purchase_unit', $data)) {
            ProductUnit::query()->firstOrCreate(['name' => $data['purchase_unit']], ['name' => $data['purchase_unit']]);
        }


        $data['is_track'] = $request->has('is_track');

        return $data;
    }


    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }


        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }
}
