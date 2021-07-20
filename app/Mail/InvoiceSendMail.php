<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceSendMail extends Mailable
{
    use Queueable, SerializesModels;


    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }


    public function build()
    {
        return $this
            ->from('from@gmail.com', 'From Business')
            ->replyTo('from@gmail.com', 'From Business')
            ->subject('Invoice #' . $this->invoice->invoice_number)
            ->view('mail.invoice-mail')
            ->attach(asset('sample/enam_cv.pdf'));
    }
}
