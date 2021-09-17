<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct($request)
    {
        $this->request = (object)$request;
    }


    public function build()
    {
        return $this
            ->subject($this->request->subject)
            ->from('inovicepedia@gmail.com', 'InvoicePedia')
            ->html($this->request->body ?? '<p>Empty</p>');
    }
}
