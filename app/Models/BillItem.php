<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BillItem
 *
 * @property int $id
 * @property int $bill_id
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
 * @property-read \App\Models\Bill $bill
 * @property-read mixed $tax_amount
 * @property-read \App\Models\Product $product
 * @method static Builder|BillItem newModelQuery()
 * @method static Builder|BillItem newQuery()
 * @method static Builder|BillItem query()
 * @method static Builder|BillItem whereAmount($value)
 * @method static Builder|BillItem whereBillId($value)
 * @method static Builder|BillItem whereClientId($value)
 * @method static Builder|BillItem whereCreatedAt($value)
 * @method static Builder|BillItem whereDate($value)
 * @method static Builder|BillItem whereDescription($value)
 * @method static Builder|BillItem whereId($value)
 * @method static Builder|BillItem wherePrice($value)
 * @method static Builder|BillItem whereProductId($value)
 * @method static Builder|BillItem whereQnt($value)
 * @method static Builder|BillItem whereTaxId($value)
 * @method static Builder|BillItem whereUnit($value)
 * @method static Builder|BillItem whereUpdatedAt($value)
 * @method static Builder|BillItem whereUserId($value)
 * @mixin \Eloquent
 */
class BillItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function bill()
    {
        return $this->belongsTo('App\Models\Bill', 'bill_id');
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
