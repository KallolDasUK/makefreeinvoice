<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Model;

class CustomerAdvancePayment extends Model
{


    protected $table = 'customer_advance_payments';


    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }


    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }


}
