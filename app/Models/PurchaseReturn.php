<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    const Partial = "Partial";
    const Paid = "Paid";
    const UnPaid = "Unpaid";

    protected $appends = ['paid', 'due'];

    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function bill_items()
    {
        return $this->hasMany(PurchaseReturnItem::class, 'purchase_return_id');
    }

    public function bill_extra()
    {
        return $this->hasMany(PurchaseReturnExtra::class, 'purchase_return_id');
    }

    public function getExtraFieldsAttribute()
    {
        return ExtraField::query()->where('type', PurchaseReturn::class)->where('type_id', $this->id)->get();
    }


    public function getDueAttribute()
    {
        $due = 0;
        try {
            $payment = optional($this->payments)->sum('amount');
        } catch (\Exception $exception) {
            $payment = 0;
        }

        $due = $this->total - $payment;

        return number_format((float)$due, 2, '.', '');

    }


    public function getPaidAttribute()
    {
        return optional($this->payments)->sum('amount');
    }

    public function getPaymentAttribute()
    {
        return optional($this->payments)->sum('amount');
    }

    public function payments()
    {
        return $this->hasMany(BillPaymentItem::class, 'bill_id');
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
        foreach ($this->bill_items as $bill_item) {
            $bill_item->tax = 0;
            if ($bill_item->tax_id) {
                $tax = Tax::find($bill_item->tax_id);
//                dd($tax,$bill_item->tax_id);
                if ($tax) {
                    $taxAmount = (floatval($tax->value) / 100) * $bill_item->amount;
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
        $next_invoice = 'PR-' . str_pad(count(self::query()->get()) + $increment, 4, '0', STR_PAD_LEFT);
        if (self::query()->where('purchase_return_number', $next_invoice)->exists()) {
            return self::nextInvoiceNumber($increment + 1);
        }
        return $next_invoice;
    }

    public function getAgeAttribute()
    {
        $age = 0;
        if ($this->bill_date <= today()->toDateString()) {
            $age = Carbon::today()->diffInDays($this->bill_date);
        }
        return $age;
    }

    public function getChargesAttribute()
    {
        return $this->bill_extra()->sum('value');
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
