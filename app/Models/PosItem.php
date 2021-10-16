<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PosItem
 *
 * @property int $id
 * @property int $pos_sales_id
 * @property int $product_id
 * @property string|null $price
 * @property string|null $qnt
 * @property string|null $amount
 * @property int|null $tax_id
 * @property int|null $attribute_id
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\PosSale $pos_sale
 * @property-read \App\Models\Product $product
 * @method static Builder|PosItem newModelQuery()
 * @method static Builder|PosItem newQuery()
 * @method static Builder|PosItem query()
 * @method static Builder|PosItem whereAmount($value)
 * @method static Builder|PosItem whereAttributeId($value)
 * @method static Builder|PosItem whereClientId($value)
 * @method static Builder|PosItem whereCreatedAt($value)
 * @method static Builder|PosItem whereDate($value)
 * @method static Builder|PosItem whereId($value)
 * @method static Builder|PosItem wherePosSalesId($value)
 * @method static Builder|PosItem wherePrice($value)
 * @method static Builder|PosItem whereProductId($value)
 * @method static Builder|PosItem whereQnt($value)
 * @method static Builder|PosItem whereTaxId($value)
 * @method static Builder|PosItem whereUpdatedAt($value)
 * @method static Builder|PosItem whereUserId($value)
 * @mixin \Eloquent
 */
class PosItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pos_sale()
    {
        return $this->belongsTo(PosSale::class, 'pos_sales_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
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
