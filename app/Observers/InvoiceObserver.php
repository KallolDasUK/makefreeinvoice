<?php

namespace App\Observers;

use App\Events\LogActivityEvent;
use App\Models\Invoice;
use Enam\Acc\AccountingFacade;
use Illuminate\Support\Str;

class InvoiceObserver
{

    public function invoice_item_created(Invoice $invoice)
    {
        $accounting = new AccountingFacade();
        $accounting->on_invoice_create($invoice);
        event(new LogActivityEvent((auth()->user()->name ?? '') . " created a invoice #" . $invoice->invoice_number));
    }

    public function invoice_item_updated(Invoice $invoice)
    {
        $accounting = new AccountingFacade();
        $accounting->on_invoice_delete($invoice);
        $accounting->on_invoice_create($invoice);
        event(new LogActivityEvent((auth()->user()->name ?? '') . " updated a invoice #" . $invoice->invoice_number));

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
        event(new LogActivityEvent((auth()->user()->name ?? '') . " deleted a invoice #" . $invoice->invoice_number));

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
