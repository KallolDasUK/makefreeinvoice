<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInvoiceItem extends Model
{
    use HasFactory;

    protected $guarded = [];
//    protected $appends = ['amount'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function invoice()
    {
        return $this->belongsTo(ContactInvoice::class, 'contact_invoice_id');
    }

    public function getTotalAttribute()
    {


        return ($this->amount + $this->invoice->charges) + $this->tax_amount;
    }
//
//    public function getAmountAttribute($amount)
//    {
//
//
//        return $amount + $this->tax_amount;
//    }

    public function getTaxAmountAttribute()
    {
        $tax_amount = 0;
        if (!$this->tax_id) {
            return $tax_amount;
        }
        $tax = Tax::find($this->tax_id);
        $tax_amount = ($tax->value / 100) * ($this->amount + $this->invoice->charges);
        return $tax_amount;
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
