<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InventoryAdjustment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property string|null $ref
 * @property int|null $ledger_id
 * @property int|null $reason_id
 * @property string|null $description
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InventoryAdjustmentItem[] $inventory_adjustment_items
 * @property-read int|null $inventory_adjustment_items_count
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\Reason|null $reason
 * @method static Builder|InventoryAdjustment newModelQuery()
 * @method static Builder|InventoryAdjustment newQuery()
 * @method static Builder|InventoryAdjustment query()
 * @method static Builder|InventoryAdjustment whereClientId($value)
 * @method static Builder|InventoryAdjustment whereCreatedAt($value)
 * @method static Builder|InventoryAdjustment whereDate($value)
 * @method static Builder|InventoryAdjustment whereDescription($value)
 * @method static Builder|InventoryAdjustment whereId($value)
 * @method static Builder|InventoryAdjustment whereLedgerId($value)
 * @method static Builder|InventoryAdjustment whereReasonId($value)
 * @method static Builder|InventoryAdjustment whereRef($value)
 * @method static Builder|InventoryAdjustment whereUpdatedAt($value)
 * @method static Builder|InventoryAdjustment whereUserId($value)
 * @mixin \Eloquent
 */
class InventoryAdjustment extends Model
{

    protected $guarded = [];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public function inventory_adjustment_items()
    {
        return $this->hasMany(InventoryAdjustmentItem::class, 'inventory_adjustment_id');
    }

    public function reason()
    {
        return $this->belongsTo('App\Models\Reason', 'reason_id');
    }

    public static function nextNumber()
    {
        $next_invoice = 'ADJ-' . str_pad(count(InventoryAdjustment::query()->get()) + 1, 4, '0', STR_PAD_LEFT);
        return $next_invoice;

    }

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
