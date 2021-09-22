<?php

namespace App\Models;

use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Model;

class PosSale extends Model
{


    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }


    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

}
