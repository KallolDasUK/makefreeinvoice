<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EstimateExtraField
 *
 * @property int $id
 * @property string|null $estimate_id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|EstimateExtraField newModelQuery()
 * @method static Builder|EstimateExtraField newQuery()
 * @method static Builder|EstimateExtraField query()
 * @method static Builder|EstimateExtraField whereClientId($value)
 * @method static Builder|EstimateExtraField whereCreatedAt($value)
 * @method static Builder|EstimateExtraField whereEstimateId($value)
 * @method static Builder|EstimateExtraField whereId($value)
 * @method static Builder|EstimateExtraField whereName($value)
 * @method static Builder|EstimateExtraField whereUpdatedAt($value)
 * @method static Builder|EstimateExtraField whereUserId($value)
 * @method static Builder|EstimateExtraField whereValue($value)
 * @mixin \Eloquent
 */
class EstimateExtraField extends Model
{
    use HasFactory;

    protected $table = 'estimate_extra_fields';

    protected $guarded = [];

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
