<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    const Partial = "Partial";
    const Paid = "Paid";
    const UnPaid = "Un Paid";

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function invoice_items()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id');
    }

    public function invoice_extra()
    {
        return $this->hasMany('App\Models\InvoiceExtraField', 'invoice_id');
    }

    public function getExtraFieldsAttribute()
    {
        return ExtraField::query()->where('type', Invoice::class)->where('type_id', $this->id)->get();
    }


    public function getDueAttribute()
    {
        $due = 0;
        $payment = $this->payments->sum('amount');
        $due = $this->total - $payment;

        return $due;

    }

    public function payments()
    {
        return $this->hasMany(ReceivePaymentItem::class, 'invoice_id');
    }



    public function getPaymentStatusAttribute()
    {
        $paymentAmount = $this->payments->sum('amount');
        $this->total = floatval($this->total);
//        dump($paymentAmount,$this->total);
        if ($this->total <= $paymentAmount) {
            return self::Paid;
        } else if ($paymentAmount > 0 && $paymentAmount < $this->total) {
            return self::Partial;
        } else {
            return self::UnPaid;
        }
    }


}
