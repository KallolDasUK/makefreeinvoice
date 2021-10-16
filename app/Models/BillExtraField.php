<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BillExtraField
 *
 * @property int $id
 * @property string|null $bill_id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|BillExtraField newModelQuery()
 * @method static Builder|BillExtraField newQuery()
 * @method static Builder|BillExtraField query()
 * @method static Builder|BillExtraField whereBillId($value)
 * @method static Builder|BillExtraField whereClientId($value)
 * @method static Builder|BillExtraField whereCreatedAt($value)
 * @method static Builder|BillExtraField whereId($value)
 * @method static Builder|BillExtraField whereName($value)
 * @method static Builder|BillExtraField whereUpdatedAt($value)
 * @method static Builder|BillExtraField whereUserId($value)
 * @method static Builder|BillExtraField whereValue($value)
 * @mixin \Eloquent
 */
class BillExtraField extends Model
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
