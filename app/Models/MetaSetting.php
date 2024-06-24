<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MetaSetting
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static Builder|MetaSetting newModelQuery()
 * @method static Builder|MetaSetting newQuery()
 * @method static Builder|MetaSetting query()
 * @method static Builder|MetaSetting whereClientId($value)
 * @method static Builder|MetaSetting whereCreatedAt($value)
 * @method static Builder|MetaSetting whereId($value)
 * @method static Builder|MetaSetting whereKey($value)
 * @method static Builder|MetaSetting whereUpdatedAt($value)
 * @method static Builder|MetaSetting whereUserId($value)
 * @method static Builder|MetaSetting whereValue($value)
 * @mixin \Eloquent
 */
class MetaSetting extends Model
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
