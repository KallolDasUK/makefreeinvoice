<?php

namespace App\Observers;

use App\Models\BillPaymentItem;

class BillPaymentItemObserver
{
    /**
     * Handle the BillPaymentItem "created" event.
     *
     * @param  \App\Models\BillPaymentItem  $billPaymentItem
     * @return void
     */
    public function created(BillPaymentItem $billPaymentItem)
    {
        //
    }

    /**
     * Handle the BillPaymentItem "updated" event.
     *
     * @param  \App\Models\BillPaymentItem  $billPaymentItem
     * @return void
     */
    public function updated(BillPaymentItem $billPaymentItem)
    {
        //
    }

    /**
     * Handle the BillPaymentItem "deleted" event.
     *
     * @param  \App\Models\BillPaymentItem  $billPaymentItem
     * @return void
     */
    public function deleted(BillPaymentItem $billPaymentItem)
    {
        //
    }

    /**
     * Handle the BillPaymentItem "restored" event.
     *
     * @param  \App\Models\BillPaymentItem  $billPaymentItem
     * @return void
     */
    public function restored(BillPaymentItem $billPaymentItem)
    {
        //
    }

    /**
     * Handle the BillPaymentItem "force deleted" event.
     *
     * @param  \App\Models\BillPaymentItem  $billPaymentItem
     * @return void
     */
    public function forceDeleted(BillPaymentItem $billPaymentItem)
    {
        //
    }
}
