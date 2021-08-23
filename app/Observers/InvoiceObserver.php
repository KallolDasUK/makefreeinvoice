<?php

namespace App\Observers;

use App\Models\Invoice;
use Enam\Acc\AccountingFacade;
use Illuminate\Support\Str;

class InvoiceObserver
{

    public function invoice_item_created(Invoice $invoice)
    {
        $accounting = new AccountingFacade();
        $accounting->on_invoice_create($invoice);
    }

    public function invoice_item_updated(Invoice $invoice)
    {
        $accounting = new AccountingFacade();
        $accounting->on_invoice_delete($invoice);
        $accounting->on_invoice_create($invoice);
    }

    public function created(Invoice $invoice)
    {
        $random = Str::random(40);
        $invoice->secret = $random;

    }


    public function deleted(Invoice $invoice)
    {
        $accounting = new AccountingFacade();
        $accounting->on_invoice_delete($invoice);
    }


    public function restored(Invoice $invoice)
    {
        //
    }


    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
