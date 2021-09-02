<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\ReceivePaymentItem;
use Enam\Acc\AccountingFacade;

class ReceivePaymentItemObserver
{

    public function created(ReceivePaymentItem $invoice_payment)
    {
        $invoice = $invoice_payment->invoice;
        $invoice->payment_status = $invoice->payment_status_text;
        $invoice->saveQuietly();
        $accounting = new AccountingFacade();
        $accounting->on_invoice_payment_create($invoice_payment);
//        dd(ReceivePaymentItemObserver::class);

    }


    public function updated(ReceivePaymentItem $invoice_payment)
    {
        $accounting = new AccountingFacade();
        $accounting->on_invoice_payment_delete($invoice_payment);
        $accounting->on_invoice_payment_create($invoice_payment);
    }


    public function deleted(ReceivePaymentItem $invoice_payment)
    {
        $invoice = $invoice_payment->invoice;
//        dd($invoice, $invoice_payment);
        $invoice->payment_status = $invoice->payment_status_text;
        $invoice->saveQuietly();
        $accounting = new AccountingFacade();
        $accounting->on_invoice_payment_delete($invoice_payment);
    }


    public function restored(ReceivePaymentItem $invoice_payment)
    {
        //
    }


    public function forceDeleted(ReceivePaymentItem $invoice_payment)
    {
        //
    }
}
