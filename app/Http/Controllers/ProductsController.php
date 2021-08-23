<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{


    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();

        return view('products.create', compact('categories'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $product = Product::create($data);
        if ($request->ajax()) {
            return $product;
        }

        return redirect()->route('products.product.index')
            ->with('success_message', 'Product was successfully added.');

    }


    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.show', compact('product'));
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::pluck('name', 'id')->all();

        return view('products.edit', compact('product', 'categories'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $product = Product::findOrFail($id);
        $product->update($data);

        return redirect()->route('products.product.index')
            ->with('success_message', 'Product was successfully updated.');

    }


    public function destroy($id)
    {

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.product.index')
            ->with('success_message', 'Product was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'product_type' => 'required|nullable',
            'name' => 'required|nullable|string',
            'sku' => 'nullable|string|min:0|max:255',
            'photo' => ['file', 'nullable'],
            'category_id' => 'nullable',
            'sell_price' => 'required|nullable|numeric',
            'sell_unit' => 'nullable',
            'purchase_price' => 'nullable|numeric',
            'purchase_unit' => 'nullable',
            'description' => 'nullable|string|min:0|max:1000',
            'is_track' => 'boolean|nullable',
            'opening_stock' => 'string|min:1|nullable|numeric',
            'opening_stock_price' => 'nullable|numeric',
        ];

        $data = $request->validate($rules);
        if ($request->has('custom_delete_photo')) {
            $data['photo'] = null;
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->moveFile($request->file('photo'));
        }
        if (array_key_exists('category_id',$data)) {
            if (!is_numeric($data['category_id'])) {
                $data['category_id'] = Category::create(['name' => $data['category_id']])->id;
            }
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
