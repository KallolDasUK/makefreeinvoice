<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guarded = [];
    protected $appends = ['stock'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('scopeClient', function (Builder $builder) {
            if (optional(auth()->user())->client_id) {
                $builder->where('client_id', auth()->user()->client_id ?? -1);
            }
        });
    }

    public function getStockAttribute()
    {

        return $this->currentStock($this, today()->toDateString());

    }

    public function getPriceAttribute()
    {
        $price = $this->purchase_price;
        if ($price == null) {
            $lastPurchase = BillItem::query()->where('product_id', $this->id)->latest()->first();
            if ($lastPurchase) {
                $price = $lastPurchase->price;
            }
        }

        return $price;

    }


    public function currentStock($product, $start_date)
    {
        $enteredOpening = $product->opening_stock ?? 0;
        $sold = InvoiceItem::query()
            ->where('product_id', $product->id)
            ->whereDate('date', '<=', $start_date)
            ->sum('qnt');

        $purchase = BillItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<=', $start_date)
            ->sum('qnt');

        $added = InventoryAdjustmentItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<=', $start_date)
            ->sum('add_qnt');

        $removed = InventoryAdjustmentItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<=', $start_date)
            ->sum('sub_qnt');


        $stock = ($enteredOpening + $purchase + $added) - ($sold + $removed);
        return $stock;
    }

}
