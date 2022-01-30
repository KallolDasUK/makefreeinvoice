<?php

namespace App\Models;

use Carbon\CarbonPeriod;
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

//        $period = \Carbon\CarbonPeriod::create('2022-01-01', '2025-01-01');
//        foreach ($period as $date) {
//            if (!TimeTable::query()->where('date', $date->toDateString())->exists()) {
//                TimeTable::create(['date' => $date->toDateString()]);
//            }
//        }

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
