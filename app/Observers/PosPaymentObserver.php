<?php

namespace App\Observers;

use App\Models\PosPayment;
use Enam\Acc\AccountingFacade;

class PosPaymentObserver
{

    public function created(PosPayment $posPayment)
    {
        $accounting = new AccountingFacade();
        $accounting->on_pos_payment_create($posPayment);
    }


    public function updated(PosPayment $posPayment)
    {


    }


    public function deleted(PosPayment $posPayment)
    {
        $accounting = new AccountingFacade();
        $accounting->on_pos_payment_delete($posPayment);
    }


}
