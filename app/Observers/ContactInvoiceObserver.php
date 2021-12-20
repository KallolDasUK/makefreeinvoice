<?php

namespace App\Observers;

use App\Models\ContactInvoice;
use Enam\Acc\AccountingFacade;

class ContactInvoiceObserver
{
    public function created(ContactInvoice $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_contact_invoice_create($bill);
    }


    public function updated(ContactInvoice $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_contact_invoice_delete($bill);
        $accounting->on_contact_invoice_create($bill);
    }


    public function deleted(ContactInvoice $bill)
    {
        $accounting = new AccountingFacade();
        $accounting->on_contact_invoice_delete($bill);
    }

}
