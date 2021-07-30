<?php

namespace App\Mail;

use App\Models\Estimate;
use App\Models\MetaSetting;
use ConsoleTVs\Invoices\Classes\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class InvoiceSendMail extends Mailable
{

    use Queueable, SerializesModels;

    public $settings;


    public $invoice;
    public $request_data;


    public function __construct(Estimate $invoice, $request_data)
    {
        $this->invoice = $invoice;
        $this->request_data = $request_data;
        $this->settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

    }

    public function send($mailer)
    {
        parent::send($mailer);
    }


    public function build()
    {
        $attachmentUrl = public_path('sample\enam_cv.pdf');
        $savedPdfPath = '/invoices/' . ($this->invoice->invoice_number ?? 'invoice') . '.pdf';
//        $this->getInvoiceAsPDF()->save('public/' . $savedPdfPath);
//        dd($savedPdfPath);
        return $this
            ->from($this->request_data->from, $this->settings->business_name ?? 'InvoicePedia')
            ->replyTo($this->request_data->from, $this->settings->business_name ?? 'InvoicePedia')
            ->subject($this->request_data->subject)
            ->view('mail.invoice-mail');
//            ->attach(public_path() . '/storage' . $savedPdfPath);
//            ->attachData($this->getInvoiceAsPDF(), 'invoice.pdf');
    }


    public function getInvoiceAsPDF()
    {

        $invoice = \ConsoleTVs\Invoices\Classes\Invoice::make()
            ->addItem('Test Item', 10.25, 2, 1412)
            ->addItem('Test Item 2', 5, 2, 923)
            ->addItem('Test Item 3', 15.55, 5, 42)
            ->addItem('Test Item 4', 1.25, 1, 923)
            ->addItem('Test Item 5', 3.12, 1, 3142)
            ->addItem('Test Item 6', 6.41, 3, 452)
            ->addItem('Test Item 7', 2.86, 1, 1526)
            ->addItem('Test Item 8', 5, 2, 923, 'https://dummyimage.com/64x64/000/fff')
            ->number(4021)
            ->with_pagination(true)
            ->duplicate_header(true)
            ->due_date(Carbon::now()->addMonths(1))
            ->notes('Lrem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->customer([
                'name' => 'Èrik Campobadal Forés',
                'id' => '12345678A',
                'phone' => '+34 123 456 789',
                'location' => 'C / Unknown Street 1st',
                'zip' => '08241',
                'city' => 'Manresa',
                'country' => 'Spain',
            ]);
        return $invoice;

    }


}
