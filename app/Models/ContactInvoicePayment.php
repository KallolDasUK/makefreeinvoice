<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInvoicePayment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public function invoice()
    {
        return $this->belongsTo(ContactInvoice::class, 'contact_invoice_id');
    }
}
