<?php

namespace App\Imports;

use App\Http\Controllers\ProductsController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Enam\Acc\Utils\EntryType;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport extends ProductsController implements ToCollection
{
    public function collection($rows)
    {
        foreach ($rows as $index => $row) {

            if ($index == 0) continue;
            if (Product::query()->where('name', $row[1])->exists()) continue;
            $category = null;
            $brand = null;
            if ($row[3] != '' && $row[3] != null) {
                $category = Category::query()->firstOrCreate(['name' => $row[3]], ['name' => $row[3]]);
            }
            if ($row[4] != '' && $row[4] != null) {
                $brand = Brand::query()->firstOrCreate(['name' => $row[4]], ['name' => $row[4]]);
            }
            $product = Product::create([
                'product_type' => 'Goods',
                'name' => $row[1],
                'description' => $row[2],
                'category_id' => optional($category)->id,
                'brand_id' => optional($brand)->id,
                'sell_price' => $row[5],
                'sell_unit' => $row[6],
                'purchase_price' => $row[7],
                'purchase_unit' => $row[8],
                'opening_stock' => $row[9],
                'opening_stock_price' => $row[10],
                'minimum_stock' => $row[11],
                'code' => $row[12],
            ]);
            if ($product->opening_stock) {
                $this->storeOpeningStock($product, $product->opening_stock_price, EntryType::$DR);
            }
        }
    }

}
