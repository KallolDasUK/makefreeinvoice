<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EstimateItem
 *
 * @property int $id
 * @property int $estimate_id
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
 * @property-read \App\Models\Estimate $estimate
 * @property-read \App\Models\Product $product
 * @method static Builder|EstimateItem newModelQuery()
 * @method static Builder|EstimateItem newQuery()
 * @method static Builder|EstimateItem query()
 * @method static Builder|EstimateItem whereAmount($value)
 * @method static Builder|EstimateItem whereClientId($value)
 * @method static Builder|EstimateItem whereCreatedAt($value)
 * @method static Builder|EstimateItem whereDate($value)
 * @method static Builder|EstimateItem whereDescription($value)
 * @method static Builder|EstimateItem whereEstimateId($value)
 * @method static Builder|EstimateItem whereId($value)
 * @method static Builder|EstimateItem wherePrice($value)
 * @method static Builder|EstimateItem whereProductId($value)
 * @method static Builder|EstimateItem whereQnt($value)
 * @method static Builder|EstimateItem whereTaxId($value)
 * @method static Builder|EstimateItem whereUnit($value)
 * @method static Builder|EstimateItem whereUpdatedAt($value)
 * @method static Builder|EstimateItem whereUserId($value)
 * @mixin \Eloquent
 */
class EstimateItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function estimate()
    {
        return $this->belongsTo('App\Models\Estimate', 'estimate_id');
    }

    public function getAmountAttribute()
    {
        return $this->qnt * $this->price;
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
