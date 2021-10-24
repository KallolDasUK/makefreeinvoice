<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Model;

class VendorAdvancePayment extends Model
{


    protected $table = 'vendor_advance_payments';


    protected $primaryKey = 'id';

    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }


    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }


}
