<?php

namespace App\Observers;

use App\Models\PosSale;
use Enam\Acc\AccountingFacade;

class PosSaleObserver
{

    public function created(PosSale $posSale)
    {
        $accounting = new AccountingFacade();
        $accounting->on_pos_sales_create($posSale);
    }


    public function updated(PosSale $posSale)
    {
        $accounting = new AccountingFacade();
        $accounting->on_pos_sales_delete($posSale);
        $accounting->on_pos_sales_create($posSale);
    }


    public function deleted(PosSale $posSale)
    {
        $accounting = new AccountingFacade();
        $accounting->on_pos_sales_delete($posSale);
    }

}
