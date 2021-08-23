<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
