<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tax
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $value
 * @property string|null $tax_type
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static Builder|Tax newModelQuery()
 * @method static Builder|Tax newQuery()
 * @method static Builder|Tax query()
 * @method static Builder|Tax whereClientId($value)
 * @method static Builder|Tax whereCreatedAt($value)
 * @method static Builder|Tax whereId($value)
 * @method static Builder|Tax whereName($value)
 * @method static Builder|Tax whereTaxType($value)
 * @method static Builder|Tax whereUpdatedAt($value)
 * @method static Builder|Tax whereUserId($value)
 * @method static Builder|Tax whereValue($value)
 * @mixin \Eloquent
 */
class Tax extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'taxes';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'value',
                  'tax_type'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

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
