<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
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
}
