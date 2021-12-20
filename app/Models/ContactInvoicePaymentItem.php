<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInvoicePaymentItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bill()
    {
        return $this->belongsTo(ContactInvoice::class, 'contact_invoice_id');
    }

    public function bill_payment()
    {
        return $this->belongsTo(ContactInvoicePayment::class, 'contact_invoice_payment_id');
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
