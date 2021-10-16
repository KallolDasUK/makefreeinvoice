<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PurchaseOrderItem
 *
 * @property int $id
 * @property int $purchase_order_id
 * @property int $product_id
 * @property string|null $description
 * @property string $qnt
 * @property string|null $unit
 * @property string $price
 * @property string $amount
 * @property int|null $tax_id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property-read mixed $tax_amount
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\PurchaseOrder $purchase_order
 * @method static Builder|PurchaseOrderItem newModelQuery()
 * @method static Builder|PurchaseOrderItem newQuery()
 * @method static Builder|PurchaseOrderItem query()
 * @method static Builder|PurchaseOrderItem whereAmount($value)
 * @method static Builder|PurchaseOrderItem whereClientId($value)
 * @method static Builder|PurchaseOrderItem whereCreatedAt($value)
 * @method static Builder|PurchaseOrderItem whereDate($value)
 * @method static Builder|PurchaseOrderItem whereDescription($value)
 * @method static Builder|PurchaseOrderItem whereId($value)
 * @method static Builder|PurchaseOrderItem wherePrice($value)
 * @method static Builder|PurchaseOrderItem whereProductId($value)
 * @method static Builder|PurchaseOrderItem wherePurchaseOrderId($value)
 * @method static Builder|PurchaseOrderItem whereQnt($value)
 * @method static Builder|PurchaseOrderItem whereTaxId($value)
 * @method static Builder|PurchaseOrderItem whereUnit($value)
 * @method static Builder|PurchaseOrderItem whereUpdatedAt($value)
 * @method static Builder|PurchaseOrderItem whereUserId($value)
 * @mixin \Eloquent
 */
class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function getAmountAttribute()
    {
        return $this->qnt * $this->price;
    }

    public function getTaxAmountAttribute()
    {
        $tax_amount = 0;
        if ($this->tax_id == null) {
            return $tax_amount;
        }
        $tax = Tax::find($this->tax_id);
        $tax_amount = ($tax->value / 100) * $this->amount;
        return $tax_amount;
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
}
