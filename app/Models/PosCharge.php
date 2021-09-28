<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosCharge extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pos_sale()
    {
        return $this->belongsTo(PosSale::class, 'pos_sales_id');
    }
}
