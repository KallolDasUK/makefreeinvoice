<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InventoryAdjustmentItem
 *
 * @property int $id
 * @property int $inventory_adjustment_id
 * @property int $product_id
 * @property string $sub_qnt
 * @property string $add_qnt
 * @property string|null $type
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $reason_id
 * @property string|null $date
 * @property-read \App\Models\InventoryAdjustment $inventory_adjustment
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Reason|null $reason
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereAddQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereInventoryAdjustmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereSubQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereUserId($value)
 * @mixin \Eloquent
 */
class InventoryAdjustmentItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function inventory_adjustment()
    {
        return $this->belongsTo(InventoryAdjustment::class, 'inventory_adjustment_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }

}
