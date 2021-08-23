<?php

namespace App\Observers;

use App\Models\Bill;
use Enam\Acc\AccountingFacade;

class BillObserver
{

    public function created(Bill $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_create($bill);
    }


    public function updated(Bill $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_delete($bill);
        $accounting->on_bill_create($bill);
    }


    public function deleted(Bill $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_delete($bill);
    }


    public function restored(Bill $bill)
    {
        //
    }


    public function forceDeleted(Bill $bill)
    {
        //
    }
}
