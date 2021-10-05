<?php

namespace App\Models;

use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PosSale extends Model
{


    protected $guarded = [];
    protected $appends = ['due', 'payment', 'charges'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function pos_items()
    {
        return $this->hasMany(PosItem::class, 'pos_sales_id');
    }

    public function pos_charges()
    {
        return $this->hasMany(PosCharge::class, 'pos_sales_id');
    }

    public function payments()
    {
        return $this->hasMany(PosPayment::class, 'pos_sales_id');
    }


    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public static function nextOrderNumber($increment = 1)
    {
        $next_order = 'POS-' . str_pad(count(self::query()->get()) + $increment, 4, '0', STR_PAD_LEFT);
        if (self::query()->where('pos_number', $next_order)->exists()) {
            return self::nextOrderNumber($increment + 1);
        }
        return $next_order;
    }

    public function getDueAttribute()
    {
        $due = 0;
        $payment = $this->payments->sum('amount');
        $due = $this->total - $payment;

        return number_format((float)$due, 2, '.', '');

    }


    public function getChargesAttribute()
    {
        return $this->pos_charges()->sum('amount');
    }

    public function getPaymentAttribute()
    {
        $paymentAmount = $this->payments->sum('amount');
        return $paymentAmount;
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
