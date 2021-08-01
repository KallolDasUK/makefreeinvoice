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
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

class EstimateSendMail extends Mailable
{

    use Queueable, SerializesModels;

    public $settings;


    public $estimate;
    public $request_data;


    public function __construct(Estimate $invoice, $request_data, $settings)
    {
        $this->estimate = $invoice;
        $this->request_data = $request_data;
        $this->settings = $settings;
    }

    public function send($mailer)
    {
        parent::send($mailer);
    }


    public function build()
    {
        $fileName = ($this->estimate->estimate_number ?? 'estimate') . '.pdf';

        $mailable = $this
            ->from($this->request_data->from, $this->settings->business_name ?? 'InvoicePedia')
            ->replyTo($this->request_data->from, $this->settings->business_name ?? 'InvoicePedia')
            ->subject($this->request_data->subject)
            ->view('mail.estimate-mail');

        if ($this->request_data->attach_pdf) {
            $mailable = $mailable->attachData($this->getEstimateAsPDF()->stream(), $fileName);

        }
        return $mailable;
//            ->attach($attachmentUrl);
//            ->attach(public_path() . '/storage' . $savedPdfPath);
    }


    public function getEstimateAsPDF()
    {
        $estimate = $this->estimate;
        $client = new Party([
            'name' => 'Roosevelt Lloyd',
            'phone' => '(520) 318-9486',
            'custom_fields' => [
                'note' => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);
        $customer = new Party([
            'name' => 'Ashley Medina',
            'address' => 'The Green Street 12',
            'code' => '#22663214',
            'custom_fields' => [
                'order number' => '> 654321 <',
            ],
        ]);
        $items = [];
        foreach ($estimate->estimate_items as $estimate_item) {
            $items[] = (new InvoiceItem())->title($estimate_item->product->name)->pricePerUnit($estimate_item->price)->quantity($estimate_item->qnt)->units($estimate_item->unit);
        }

        $notes = [
            $estimate->notes ?? '',
            'Terms & Condition',
            $estimate->terms_condition ?? ''
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Estimate')
            ->series($estimate->estimate_number ?? 'UNKNOWN')
            ->serialNumberFormat('{SERIES}')
            ->taxableAmount($estimate->taxable_amount)
            ->totalDiscount($estimate->discount)
            ->shipping($estimate->shipping_charge)
            ->date(\Carbon\Carbon::parse($estimate->estimate_date))
            ->seller($client)
            ->buyer($customer)
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol($estimate->currency)
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->totalAmount($estimate->total)
            ->notes($notes)
            ->logo(public_path('/storage/' . (property_exists(settings(), 'business_logo') ? settings()->business_logo : 'logo.png')));

        $invoice->taxes = $estimate->taxes;
        $invoice->invoice = $estimate;
        $invoice->expires_on = $estimate->due_date;
        $invoice->extras = $estimate->extra_fields;
        $invoice->cost_extra = $estimate->estimate_extra;
        $invoice->settings = $this->settings;
        return $invoice;
    }


}
