<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string|null $product_type
 * @property string|null $name
 * @property string|null $sku
 * @property string|null $photo
 * @property int|null $category_id
 * @property string|null $sell_price
 * @property string|null $sell_unit
 * @property string|null $purchase_price
 * @property string|null $purchase_unit
 * @property string|null $description
 * @property int|null $is_track
 * @property string|null $opening_stock
 * @property string|null $opening_stock_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @property int|null $brand_id
 * @property string|null $code
 * @property int $is_bookmarked
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @property-read mixed $price
 * @property-read mixed $short_name
 * @property-read mixed $stock
 * @property-read mixed $stock_value
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereClientId($value)
 * @method static Builder|Product whereCode($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsBookmarked($value)
 * @method static Builder|Product whereIsTrack($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereOpeningStock($value)
 * @method static Builder|Product whereOpeningStockPrice($value)
 * @method static Builder|Product wherePhoto($value)
 * @method static Builder|Product whereProductType($value)
 * @method static Builder|Product wherePurchasePrice($value)
 * @method static Builder|Product wherePurchaseUnit($value)
 * @method static Builder|Product whereSellPrice($value)
 * @method static Builder|Product whereSellUnit($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUserId($value)
 * @mixin \Eloquent
 */
class Product extends Model
{

    protected $guarded = [];
    protected $appends = ['stock', 'short_name', 'stock_value'];

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

    public function getStockValueAttribute()
    {

        $stock = $this->stock;
        if ($stock <= 0) {
            $stock = 0;
        }
        return $stock * ($this->purchase_price ?? $this->sell_price) ?? 0;

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

    public function getShortNameAttribute()
    {
        $maxLength = 25;
        $shortName = $this->name;
        if (strlen($this->name) > $maxLength) {
            $shortName = substr($this->name, 0, $maxLength) . '...';
        }

        return $shortName;

    }


    public function currentStock($product, $start_date)
    {
        $enteredOpening = $product->opening_stock ?? 0;
        $sold = InvoiceItem::query()
            ->where('product_id', $product->id)
            ->whereDate('date', '<=', $start_date)
            ->sum('qnt');

        $sold += PosItem::query()
            ->where('product_id', $product->id)
            ->whereDate('date', '<=', $start_date)
            ->sum('qnt');

        $purchase = BillItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<=', $start_date)
            ->sum('qnt');
        $purchase_return = PurchaseReturnItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<=', $start_date)
            ->sum('qnt');
        $sales_return = SalesReturnItem::query()
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


        $stock = ($enteredOpening + $purchase + $added + $sales_return) - ($sold + $removed + $purchase_return);
        return $stock;
    }


}
