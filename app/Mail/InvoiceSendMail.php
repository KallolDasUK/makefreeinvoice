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
    public $request_data;

    public function __construct(Invoice $invoice, $request_data)
    {
        $this->invoice = $invoice;
        $this->request_data = $request_data;
    }


    public function build()
    {
        return $this
            ->from($this->request_data->from, 'Business Name')
            ->replyTo($this->request_data->from, 'Business Name')
            ->subject($this->request_data->subject)
            ->view('mail.invoice-mail');
//            ->attach(asset('sample/enam_cv.pdf'));
    }
}
