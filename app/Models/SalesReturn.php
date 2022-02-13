<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;


    const Partial = "Partial";
    const Paid = "Paid";
    const UnPaid = "Unpaid";

    protected $guarded = [];
    protected $appends = ['due'];


    public function customer()
    {

        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function sr()
    {

        return $this->belongsTo(SR::class, 'sr_id');
    }

    public function invoice_items()
    {
        return $this->hasMany(SalesReturnItem::class, 'sales_return_id');
    }

    public function invoice_extra()
    {
        return $this->hasMany('App\Models\InvoiceExtraField', 'invoice_id');
    }

    public function getExtraFieldsAttribute()
    {
        return ExtraField::query()->where('type', Invoice::class)->where('type_id', $this->id)->get();
    }


    public function payments()
    {
        return $this->hasMany(ReceivePaymentItem::class, 'invoice_id');
    }

    public function getDueAttribute()
    {
        $due = 0;
        $payment = $this->payments->sum('amount');
        $due = $this->total - $payment;

        return number_format((float)$due, 2, '.', '');

    }

    public function getPaymentAttribute()
    {
        $paymentAmount = $this->payments->sum('amount');
        return $paymentAmount;
    }

    public function getPaymentStatusTextAttribute()
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


    public function getTaxableAmountAttribute()
    {
        $taxable = 0;
        foreach ($this->taxes as $tax) {
            $taxable += $tax['tax_amount'];
        }
        return $taxable;
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

    public function getTaxesAttribute()
    {

        $taxes = [];
        $tax_id = [];
//        dd('test');
        foreach ($this->invoice_items as $invoice_item) {
            $invoice_item->tax = 0;
            if ($invoice_item->tax_id) {
                $tax = Tax::find($invoice_item->tax_id);
//                dd($tax,$invoice_item->tax_id);
                if ($tax) {
                    $taxAmount = (floatval($tax->value) / 100) * $invoice_item->amount;
                    if (in_array($tax->id, $tax_id)) {
                        $taxes[$tax->id]['tax_amount'] += $taxAmount;
                        continue;
                    }
                    $taxes[$tax->id] = ['tax_id' => $tax->id, 'tax_name' => $tax->name . '(' . $tax->value . '%)', 'tax_amount' => $taxAmount];
                    $tax_id[] = $tax->id;

                }
            }

        }
//        dd($taxes, $tax_id);
        return $taxes;
    }

    public static function nextInvoiceNumber($increment = 1)
    {
        $next_invoice = 'SR-' . str_pad(count(self::query()->get()) + $increment, 4, '0', STR_PAD_LEFT);
        if (self::query()->where('invoice_number', $next_invoice)->exists()) {
            return self::nextInvoiceNumber($increment + 1);
        }
        return $next_invoice;
    }

    public function getAgeAttribute()
    {
        $age = 0;
        if ($this->invoice_date <= today()->toDateString()) {
            $age = Carbon::today()->diffInDays($this->invoice_date);
        }
        return $age;
    }

    public function getChargesAttribute()
    {
        return $this->invoice_extra()->sum('value');
    }

    public function getDiscountAttribute()
    {
        $discount = 0;
        if ($this->discount_type == 'Flat') {
            $discount = $this->discount_value;
        } else {
            $discount = ($this->discount_value * $this->sub_total) / 100;
        }
        return $discount;
    }

}
