<?php

namespace App\Observers;

use App\Models\ExpenseItem;
use Enam\Acc\AccountingFacade;

class ExpenseItemObserver
{

    public function created(ExpenseItem $expenseItem)
    {
        $accounting = new AccountingFacade();
        $accounting->on_expense_create($expenseItem);
    }


    public function updated(ExpenseItem $expenseItem)
    {
        //
    }


    public function deleted(ExpenseItem $expenseItem)
    {
        $accounting = new AccountingFacade();
        $accounting->on_expense_delete($expenseItem);
    }


    public function restored(ExpenseItem $expenseItem)
    {
        //
    }


    public function forceDeleted(ExpenseItem $expenseItem)
    {
        //
    }
}
