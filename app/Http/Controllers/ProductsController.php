<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
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
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    use TransactionTrait;

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::query()->where('name', 'like', '%' . $request->search . '%')->select(['id', 'name as text'])->limit(5)->get();

            if ($request->search) {
                return ['results' => $products];
            }
            return ['results' => Product::query()->latest()->select(['id', 'name as text'])->limit(5)->get()];
        }
        return [];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            return Product::query()->orderBy('name')->get();
        }
        view()->share('title', 'Product List');
        $q = $request->q;
        $products = Product::with(['category', 'brand'])
        ->when($q != null,function($query) use($q){
          return $query->where('name','like','%'.$q.'%');          
        })
        ->paginate(10, ['id', 'name', 'sell_price', 'brand_id', 'category_id', 'purchase_price', 'product_type', 'photo', 'code']);
        return view('products.index', compact('products','q'));
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
                ->update([
                    'amount' => $amount, 'type' => Product::class,
                    'type_id' => $product->id
                ]);

            TransactionDetail::where('transaction_id', $txn->id)
                ->update([
                    'entry_type' => $entry_type, 'amount' => $amount, 'type' => Product::class,
                    'type_id' => $product->id, 'ref' => $product->name
                ]);
        } else {
            $voucher_no = $this->getVoucherID();
            $txn = Transaction::create([
                'ledger_name' => $ledger->ledger_name, 'voucher_no' => $voucher_no,
                'amount' => $amount, 'note' => EntryType::$OPENING_STOCK, 'txn_type' => EntryType::$OPENING_STOCK, 'type' => Product::class,
                'type_id' => $product->id, 'date' => today()->toDateString()
            ]);

            TransactionDetail::create([
                'transaction_id' => $txn->id, 'ledger_id' => $ledger->id, 'entry_type' => $entry_type, 'amount' => $amount,
                'voucher_no' => $voucher_no, 'date' => today()->toDateString(), 'note' => EntryType::$OPENING_STOCK, 'type' => Product::class,
                'type_id' => $product->id, 'ref' => $product->name
            ]);
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

    public function export()
    {
        return Excel::download(new ProductsExport(), 'products_' . today()->toDateString() . '.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ProductsImport(), $request->file('file'));
        } catch (\Exception $exception) {
            //            dd($exception);
            return redirect()->route('products.product.index')
                ->with('error_message', "Invalid file format. Please select xls or xlsx or csv file.");
        }
        return redirect()->route('products.product.index')
            ->with('success_message', 'Products was imported. All good.');
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
            'name' => 'required|string',
            'code' => 'nullable|string|unique_saas:products,code',
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
            'minimum_stock' => 'nullable|numeric',
        ];


        if ($id) {
            $rules['code'] = 'nullable|string|unique_saas:products,code,' . $id;
        }
        //        dd($request->all());

        $data = $request->validate($rules, ['code.unique_saas' => 'Product Code Already In Use']);


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
// php artisan make:export ProductsExport --model=Product
