<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function sales_returns()
    {
        return $this->belongsTo(SalesReturn::class, 'sales_return_id');
    }

    public function getAmountAttribute()
    {
        return $this->qnt * $this->price;
    }

    public function getTaxAmountAttribute()
    {
        $tax_amount = 0;
        if ($this->tax_id == null) {
            return $tax_amount;
        }
        $tax = Tax::find($this->tax_id);
        $tax_amount = ($tax->value / 100) * $this->amount;
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
