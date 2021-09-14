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

class InvoiceSendMail extends Mailable
{

    use Queueable, SerializesModels;

    public $settings;


    public $invoice;
    public $request_data;


    public function __construct(\App\Models\Invoice $invoice, $request_data, $settings)
    {
        $this->invoice = $invoice;
        $this->request_data = $request_data;
        $this->settings = $settings;

    }

    public function send($mailer)
    {
        parent::send($mailer);
    }


    public function build()
    {
        $fileName = ($this->invoice->invoice_number ?? 'invoice') . '.pdf';

        $mailable = $this
            ->from($this->request_data->from, $this->settings->business_name ?? 'InvoicePedia')
            ->replyTo($this->request_data->from, $this->settings->business_name ?? 'InvoicePedia')
            ->subject($this->request_data->subject)
            ->view('mail.invoice-mail');

        if ($this->request_data->attach_pdf) {
            $mailable = $mailable->attachData($this->getInvoiceAsPDF()->stream(), $fileName);

        }
        return $mailable;
    }


    public function getInvoiceAsPDF()
    {
        $this->invoice;
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
        foreach ($this->invoice->invoice_items as $invoice_item) {
            $items[] = (new InvoiceItem())->title($invoice_item->product->name)->pricePerUnit($invoice_item->price)->quantity($invoice_item->qnt)->units($invoice_item->unit);
        }

        $notes = [
            $this->invoice->notes ?? '',
            'Terms & Condition',
            $this->invoice->terms_condition ?? ''
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Invoice')
            ->series($this->invoice->invoice_number ?? 'UNKNOWN')
            ->serialNumberFormat('{SERIES}')
            ->taxableAmount($this->invoice->taxable_amount)
            ->totalDiscount($this->invoice->discount)
            ->shipping($this->invoice->shipping_charge)
            ->date(\Carbon\Carbon::parse($this->invoice->estimate_date))
            ->seller($client)
            ->buyer($customer)
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol($this->invoice->currency)
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->totalAmount($this->invoice->total)
            ->notes($notes)
            ->logo(public_path('/storage/' . (property_exists($this->settings, 'business_logo') ? $this->settings->business_logo : 'logo.png')));

        $invoice->taxes = $this->invoice->taxes;
        $invoice->invoice = $this->invoice;
        $invoice->expires_on = false;
        $invoice->extras = $this->invoice->extra_fields;
        $invoice->cost_extra = $this->invoice->invoice_extra;
        $invoice->settings = $this->settings;

//        $invoice->stream();
        return $invoice;
    }


}
