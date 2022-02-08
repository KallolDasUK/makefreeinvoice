<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public $products;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->products = Product::all();
        return $this->products;
    }

    public function map($product): array
    {
        $index = $this->products->search(function ($user) use ($product) {
            return $user->id === $product->id;
        });
        return [
            $index + 1,
            $product->name,
            $product->description,
            optional($product->category)->name,
            optional($product->brand)->name,
            $product->sell_price,
            $product->sell_unit,
            $product->purchase_price,
            $product->purchase_unit,
            $product->opening_stock,
            $product->opening_stock_price,
            $product->minimum_stock,
            $product->code,
        ];


    }

    public function headings(): array
    {
        return ["#", "name", "description", "category", "brand", "sell_price", "sell_unit", "purchase_price", "purchase_unit", "opening_stock", "opening_stock_price",
            "minimum_stock", "barcode"];
    }
}
