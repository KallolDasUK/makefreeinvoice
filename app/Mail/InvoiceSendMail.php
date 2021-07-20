<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\MetaSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceSendMail extends Mailable
{

    use Queueable, SerializesModels;
    public $settings;


    public $invoice;
    public $request_data;

    public function __construct(Invoice $invoice, $request_data)
    {
        $this->invoice = $invoice;
        $this->request_data = $request_data;
        $this->settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

    }


    public function build()
    {
        return $this
            ->from($this->request_data->from, $this->settings->business_name??'InvoicePedia')
            ->replyTo($this->request_data->from, $this->settings->business_name??'InvoicePedia')
            ->subject($this->request_data->subject)
            ->view('mail.invoice-mail');
//            ->attach(asset('sample/enam_cv.pdf'));
    }
}
