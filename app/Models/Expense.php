<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{


    protected $fillable = [
        'date',
        'ledger_id',
        'vendor_id',
        'customer_id',
        'ref',
        'is_billable',
        'file'
    ];

    protected $appends = ['amount'];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }


    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }


    public function expense_items()
    {
        return $this->hasMany('App\Models\ExpenseItem', 'expense_id');
    }

    public function getAmountAttribute()
    {
        return $this->expense_items->sum('amount') + $this->taxable_amount;
    }

    public function getTaxesAttribute()
    {
        $taxes = [];
        $tax_id = [];
        foreach ($this->expense_items as $expense_item) {
            $expense_item->tax = 0;
            if ($expense_item->tax_id) {
                $tax = Tax::find($expense_item->tax_id);
                if ($tax) {
                    $taxAmount = (floatval($tax->value) / 100) * $expense_item->amount;
                    if (in_array($tax->id, $tax_id)) {
                        $taxes[$tax->id]['tax_amount'] += $taxAmount;
                        continue;
                    }
                    $taxes[$tax->id] = ['tax_id' => $tax->id, 'tax_name' => $tax->name . '(' . $tax->value . '%)', 'tax_amount' => $taxAmount];
                    $tax_id[] = $tax->id;

                }
            }

        }
        return $taxes;
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

}
