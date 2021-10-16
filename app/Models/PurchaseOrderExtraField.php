<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PurchaseOrderExtraField
 *
 * @property int $id
 * @property string|null $purchase_order_id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereValue($value)
 * @mixin \Eloquent
 */
class PurchaseOrderExtraField extends Model
{
    use HasFactory;
}
