<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExpenseItem
 *
 * @property int $id
 * @property int $expense_id
 * @property int|null $ledger_id
 * @property string|null $notes
 * @property string|null $tax_id
 * @property string $amount
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property-read \App\Models\Expense $expense
 * @property-read mixed $tax_amount
 * @property-read Ledger|null $ledger
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereExpenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereLedgerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereUserId($value)
 * @mixin \Eloquent
 */
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
