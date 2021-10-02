<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReceivePayment extends Model
{


    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'deposit_to');
    }

    public function items()
    {
        return $this->hasMany('App\Models\ReceivePaymentItem', 'receive_payment_id');
    }

    public function getAmountAttribute()
    {
        return ReceivePaymentItem::query()->where('receive_payment_id', $this->id)->sum('amount');
    }

    public function getInvoiceAttribute()
    {
        return join(",", Invoice::find(ReceivePaymentItem::query()->where('receive_payment_id', $this->id)->pluck('invoice_id'))->pluck('invoice_number')->toArray());
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
