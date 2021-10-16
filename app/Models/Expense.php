<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property int|null $ledger_id
 * @property int|null $vendor_id
 * @property int|null $customer_id
 * @property string|null $ref
 * @property int|null $is_billable
 * @property string|null $file
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpenseItem[] $expense_items
 * @property-read int|null $expense_items_count
 * @property-read mixed $amount
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\Vendor|null $vendor
 * @method static Builder|Expense newModelQuery()
 * @method static Builder|Expense newQuery()
 * @method static Builder|Expense query()
 * @method static Builder|Expense whereClientId($value)
 * @method static Builder|Expense whereCreatedAt($value)
 * @method static Builder|Expense whereCustomerId($value)
 * @method static Builder|Expense whereDate($value)
 * @method static Builder|Expense whereFile($value)
 * @method static Builder|Expense whereId($value)
 * @method static Builder|Expense whereIsBillable($value)
 * @method static Builder|Expense whereLedgerId($value)
 * @method static Builder|Expense whereRef($value)
 * @method static Builder|Expense whereUpdatedAt($value)
 * @method static Builder|Expense whereUserId($value)
 * @method static Builder|Expense whereVendorId($value)
 * @mixin \Eloquent
 */
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
