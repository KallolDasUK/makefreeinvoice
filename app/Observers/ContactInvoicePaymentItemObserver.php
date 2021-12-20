<?php

namespace App\Observers;

use App\Models\ContactInvoicePaymentItem;
use Enam\Acc\AccountingFacade;

class ContactInvoicePaymentItemObserver
{
    public function created(ContactInvoicePaymentItem $billPayment)
    {
        $bill = $billPayment->bill;
        $bill->payment_status = $bill->payment_status_text;
        $bill->save();
        $accounting = new AccountingFacade();
        $accounting->on_contact_invoice_payment_create($billPayment);
    }


    public function updated(ContactInvoicePaymentItem $billPayment)
    {
        $accounting = new AccountingFacade();
        $accounting->on_bill_payment_delete($billPayment);
        $accounting->on_contact_invoice_payment_create($billPayment);
    }


    public function deleted(ContactInvoicePaymentItem $billPayment)
    {

        $bill = $billPayment->bill;
        $bill->payment_status = $bill->payment_status_text;
        $bill->save();
        $accounting = new AccountingFacade();
        $accounting->on_bill_payment_delete($billPayment);
    }

}
