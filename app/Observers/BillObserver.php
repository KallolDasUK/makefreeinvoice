<?php

namespace App\Observers;

use App\Events\LogActivityEvent;
use App\Models\Bill;
use Enam\Acc\AccountingFacade;

class BillObserver
{

    public function created(Bill $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_create($bill);
        event(new LogActivityEvent((auth()->user()->name ?? '') . " created a bill #" . $bill->bil_number));

    }


    public function updated(Bill $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_delete($bill);
        $accounting->on_bill_create($bill);
        event(new LogActivityEvent((auth()->user()->name ?? '') . " updated a bill #" . $bill->bil_number));

    }


    public function deleted(Bill $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_delete($bill);
        event(new LogActivityEvent((auth()->user()->name ?? '') . " deleted a bill #" . $bill->bil_number));

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
