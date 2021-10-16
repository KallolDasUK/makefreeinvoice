<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_default
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static Builder|PaymentMethod newModelQuery()
 * @method static Builder|PaymentMethod newQuery()
 * @method static Builder|PaymentMethod query()
 * @method static Builder|PaymentMethod whereClientId($value)
 * @method static Builder|PaymentMethod whereCreatedAt($value)
 * @method static Builder|PaymentMethod whereDescription($value)
 * @method static Builder|PaymentMethod whereId($value)
 * @method static Builder|PaymentMethod whereIsDefault($value)
 * @method static Builder|PaymentMethod whereName($value)
 * @method static Builder|PaymentMethod whereUpdatedAt($value)
 * @method static Builder|PaymentMethod whereUserId($value)
 * @mixin \Eloquent
 */
class PaymentMethod extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('scopeClient', function (Builder $builder) {
            if (optional(auth()->user())->client_id){
                $builder->where('client_id', auth()->user()->client_id ?? -1);
            }
        });
    }
}
