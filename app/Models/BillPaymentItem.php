<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPaymentItem extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function bill()
    {
        return $this->belongsTo('App\Models\Bill', 'bill_id');
    }
}
