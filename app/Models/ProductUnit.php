<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductUnit
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|ProductUnit newModelQuery()
 * @method static Builder|ProductUnit newQuery()
 * @method static Builder|ProductUnit query()
 * @method static Builder|ProductUnit whereClientId($value)
 * @method static Builder|ProductUnit whereCreatedAt($value)
 * @method static Builder|ProductUnit whereId($value)
 * @method static Builder|ProductUnit whereName($value)
 * @method static Builder|ProductUnit whereUpdatedAt($value)
 * @method static Builder|ProductUnit whereUserId($value)
 * @mixin \Eloquent
 */
class ProductUnit extends Model
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

    public static function units()
    {
        return ['KG', 'M', 'CM', 'BOX', 'LT.'] + ProductUnit::all()->pluck('name')->unique()->toArray();
    }


}
