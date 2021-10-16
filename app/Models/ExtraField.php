<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExtraField
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property string|null $type
 * @property int|null $type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static Builder|ExtraField newModelQuery()
 * @method static Builder|ExtraField newQuery()
 * @method static Builder|ExtraField query()
 * @method static Builder|ExtraField whereClientId($value)
 * @method static Builder|ExtraField whereCreatedAt($value)
 * @method static Builder|ExtraField whereId($value)
 * @method static Builder|ExtraField whereName($value)
 * @method static Builder|ExtraField whereType($value)
 * @method static Builder|ExtraField whereTypeId($value)
 * @method static Builder|ExtraField whereUpdatedAt($value)
 * @method static Builder|ExtraField whereUserId($value)
 * @method static Builder|ExtraField whereValue($value)
 * @mixin \Eloquent
 */
class ExtraField extends Model
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
