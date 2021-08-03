<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'expenses';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'ledger_id',
        'vendor_id',
        'customer_id',
        'ref',
        'is_billable',
        'file'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the ledger for this model.
     *
     * @return App\Models\Ledger
     */
    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    /**
     * Get the vendor for this model.
     *
     * @return App\Models\Vendor
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * Get the customer for this model.
     *
     * @return App\Models\Customer
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    /**
     * Get the customer for this model.
     *
     * @return App\Models\Customer
     */
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


}
