<?php

namespace App\Observers;

use App\Models\BillPaymentItem;
use Enam\Acc\AccountingFacade;

class BillPaymentItemObserver
{

    public function created(BillPaymentItem $billPayment)
    {
        $bill = $billPayment->bill;
//        $bill->payment_status = $bill->payment_status_text;
//        $bill->saveQuietly();
        $accounting = new AccountingFacade();
        $accounting->on_bill_payment_create($billPayment);
    }


    public function updated(BillPaymentItem $billPayment)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_payment_delete($billPayment);
        $accounting->on_bill_payment_create($billPayment);
    }


    public function deleted(BillPaymentItem $billPayment)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_payment_delete($billPayment);
    }


    public function restored(BillPaymentItem $billPayment)
    {
        //
    }


    public function forceDeleted(BillPaymentItem $billPayment)
    {
        //
    }
}
