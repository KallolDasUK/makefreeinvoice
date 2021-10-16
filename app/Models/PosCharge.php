<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PosCharge
 *
 * @property int $id
 * @property int $pos_sales_id
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $amount
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\PosSale $pos_sale
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge wherePosSalesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereValue($value)
 * @mixin \Eloquent
 */
class PosCharge extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pos_sale()
    {
        return $this->belongsTo(PosSale::class, 'pos_sales_id');
    }
}
