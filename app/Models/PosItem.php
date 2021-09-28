<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pos_sale()
    {
        return $this->belongsTo(PosSale::class, 'pos_sales_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


}
