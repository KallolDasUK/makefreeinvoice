<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
