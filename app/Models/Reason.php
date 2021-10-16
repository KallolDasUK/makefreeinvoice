<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reason
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Reason newModelQuery()
 * @method static Builder|Reason newQuery()
 * @method static Builder|Reason query()
 * @method static Builder|Reason whereClientId($value)
 * @method static Builder|Reason whereCreatedAt($value)
 * @method static Builder|Reason whereId($value)
 * @method static Builder|Reason whereName($value)
 * @method static Builder|Reason whereUpdatedAt($value)
 * @method static Builder|Reason whereUserId($value)
 * @mixin \Eloquent
 */
class Reason extends Model
{
    use HasFactory;

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
