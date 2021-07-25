<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReceivePayment extends Model
{




    protected $fillable = [
        'customer_id',
        'payment_date',
        'payment_sl',
        'payment_method_id',
        'deposit_to',
        'note'
    ];


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method_id');
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
            $builder->where('client_id', auth()->user()->client_id ?? -1);
        });
    }

}
