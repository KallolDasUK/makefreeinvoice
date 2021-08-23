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
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function bill_payment()
    {
        return $this->belongsTo(BillPayment::class, 'bill_payment_id');
    }
}
