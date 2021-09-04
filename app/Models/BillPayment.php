<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function items()
    {
        return $this->hasMany(BillPaymentItem::class, 'bill_payment_id');
    }

    public function getAmountAttribute()
    {
        return BillPaymentItem::query()->where('bill_payment_id', $this->id)->sum('amount');
    }

    public function getBillAttribute()
    {
//        dd('test');
        return join(",", Bill::find(BillPaymentItem::query()->where('bill_payment_id', $this->id)->pluck('bill_id'))->pluck('bill_number')->toArray());
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


}
