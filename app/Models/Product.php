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
    protected $appends = ['stock', 'short_name', 'stock_value', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class, 'product_id');
    }

    public function bill_items()
    {
        return $this->hasMany(BillItem::class, 'product_id');
    }

    public function pos_Items()
    {
        return $this->hasMany(PosItem::class, 'product_id');
    }

    public function purchase_return_items()
    {
        return $this->hasMany(PurchaseReturnItem::class, 'product_id');
    }

    public function sales_return_items()
    {
        return $this->hasMany(SalesReturnItem::class, 'product_id');
    }

    public function inventory_adjustment_items()
    {
        return $this->hasMany(InventoryAdjustmentItem::class, 'product_id');
    }

    public function ingredient_items()
    {
        return $this->hasMany(IngredientItem::class, 'product_id');
    }

    public function production_items()
    {
        return $this->hasMany(ProductionItem::class, 'product_id');
    }

    public function stock_entry_items()
    {
        return $this->hasMany(StockEntryItem::class, 'product_id');
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

    public function getImageAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return '';

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


    public function getPurchasePriceAttribute($value)
    {
        $purchase_price = $value;
        $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
        $generate_report_from = $settings->generate_report_from ?? 'purchase_price';
        if ($generate_report_from == 'purchase_price_average') {
            $bill_items = BillItem::query()->where('product_id', $this->id)->get();
            try {
                $averagePrice = $bill_items->sum('amount') / $bill_items->sum('qnt');

            } catch (\Exception $exception) {
                $averagePrice = $purchase_price;
            }
            $purchase_price = $averagePrice;
        } elseif ($generate_report_from == 'purchase_price_last') {
            $last_bill_item = BillItem::query()->where('product_id', $this->id)->latest()->first();
            if ($last_bill_item) {
                $purchase_price = $last_bill_item->price;
            }
        } elseif ($generate_report_from == 'purchase_price_cost_average') {
            $bill_items = BillItem::query()->where('product_id', $this->id)->get();

            $prices = [];
            foreach ($bill_items as $bill_item) {
                $bill = $bill_item->bill;
                $purchase_costs = $bill->charges;
                $price = ($bill_item->amount + ($purchase_costs / count($bill->bill_items))) / $bill_item->qnt;
                $prices[] = $price;
//                dd($bill_items, $prices, ((104 + 0) + ($purchase_costs / count($bill->bill_items))) / $bill_item->qnt, $prices, $price, $bill->bill_items->sum('amount'));
            }
            $purchase_price = collect($prices)->avg();
            if ($purchase_price <= 0) {
                $purchase_price = $value;
            }

        }
        return number_format($purchase_price, 2, '.', '');;
    }

    public function getShortNameAttribute()
    {
        $maxLength = 25;
        $shortName = $this->name;
        if (strlen($this->name) > $maxLength) {
            $shortName = substr($this->name, 0, $maxLength) . '...';
        }

//        return utf8_encode($shortName);
        return $shortName;

    }


    public function currentStock($product, $start_date)
    {
        $enteredOpening = $product->opening_stock ?? 0;
        $sold = $this->invoice_items
            ->where('date', '<=', $start_date)
            ->sum('qnt');


        $sold += $this->pos_Items
            ->where('date', '<=', $start_date)
            ->sum('qnt');

        $purchase = $this->bill_items
            ->where('date', '<=', $start_date)
            ->sum('qnt');

        $purchase_return = $this->purchase_return_items
            ->where('date', '<=', $start_date)
            ->sum('qnt');
        $sales_return = $this->sales_return_items
            ->where('date', '<=', $start_date)
            ->sum('qnt');
        $added = $this->inventory_adjustment_items
            ->where('date', '<=', $start_date)
            ->sum('add_qnt');

        $removed = $this->inventory_adjustment_items
            ->where('date', '<=', $start_date)
            ->sum('sub_qnt');

        $used_in_production = $this->ingredient_items
            ->where('date', '<=', $start_date)
            ->sum('qnt');

        $produced_in_production = $this->production_items
            ->where('date', '<=', $start_date)
            ->sum('qnt');
        $stock_entry = $this->stock_entry_items
            ->where('product_id', $product->id)
            ->where('date', '<=', $start_date)
            ->sum('qnt');

        $stock = ($enteredOpening + $purchase + $added + $sales_return + $produced_in_production + $stock_entry) - ($sold + $removed + $purchase_return + $used_in_production);
        return $stock;
    }


}
