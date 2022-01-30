<?php

namespace App\Http\Controllers;

use App\Models\AppMail;
use App\Models\Bill;
use App\Models\BillExtraField;
use App\Models\BillItem;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\Category;
use App\Models\ContactInvoice;
use App\Models\ContactInvoiceExtraField;
use App\Models\ContactInvoiceItem;
use App\Models\ContactInvoicePayment;
use App\Models\ContactInvoicePaymentItem;
use App\Models\Customer;
use App\Models\ExtraField;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\Tax;
use App\Models\Vendor;
use App\Traits\SettingsTrait;
use Carbon\Carbon;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactInvoiceController extends Controller
{
    use TransactionTrait, SettingsTrait;

    public $settings;

    public function __construct()
    {
//        dd($this->settings);

    }

    public function index(Request $request)
    {


        view()->share('title', 'All Tax Invoices');

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $customer_id = $request->customer_id;
        $q = $request->q;
        $user_id = $request->user_id;
        $contact_invoices = ContactInvoice::with('customer')
            ->when($customer_id != null, function ($query) use ($customer_id) {
                return $query->where('customer_id', $customer_id);
            })
            ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->when($q != null, function ($query) use ($q) {
                return $query->where('invoice_number', 'like', '%' . $q . '%');
            })
            ->when($start_date != null && $end_date != null, function ($query) use ($start_date, $end_date) {
                $start_date = Carbon::parse($start_date)->toDateString();
                $end_date = Carbon::parse($end_date)->toDateString();
                return $query->whereBetween('invoice_date', [$start_date, $end_date]);
            })
            ->latest();
//        dd($contact_invoices->get()->toArray());
        $totalAmount = $contact_invoices->get()->sum('total');
        $totalDue = $contact_invoices->get()->sum('due');
        $totalPaid = $contact_invoices->get()->sum('paid');
//        dd($totalAmount);
        $contact_invoices = $contact_invoices->paginate(10);
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $customers = Customer::all();
        return view('contact-invoices.index', compact('contact_invoices', 'cashAcId', 'depositAccounts', 'paymentMethods',
            'start_date', 'end_date', 'customer_id', 'customers', 'q', 'totalAmount', 'totalDue', 'totalPaid', 'user_id'));
    }


    public function create()
    {
//        $this->authorize('create', Bill::class);

        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $customers = Customer::pluck('name', 'id')->all();
        $products = Product::query()->latest()->get();
        $categories = Category::query()->latest()->get();
        $taxes = Tax::query()->latest()->get()->toArray();
        $extraFields = optional(ContactInvoice::query()->latest()->first())->extra_fields ?? [];
        $bill_fields = optional(ContactInvoice::query()->latest()->first())->invoice_extra ?? [];
        $next_invoice = ContactInvoice::nextInvoiceNumber();

        return view('contact-invoices.create', compact('customers', 'products', 'taxes', 'next_invoice', 'categories', 'extraFields', 'bill_fields', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
//        dd($data);
        $random = Str::random(40);
        $data['secret'] = $random;
        $bill_items = $data['bill_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
        unset($data['bill_items']);
        unset($data['additional']);
        unset($data['additional_fields']);

        $bill = ContactInvoice::create($data);

        $this->insertDataToOtherTable($bill, $bill_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
        return redirect()->route('contact_invoices.contact_invoice.show', $bill->id)
            ->with('success_message', 'Tax Invoice was successfully added.');

    }

    public function insertDataToOtherTable($bill, $bill_items, $extraFields, $additionalFields)
    {
//        dd($bill_items);
        foreach ($bill_items as $bill_item) {
            $product_id = $bill_item->product_id;
            if (!is_numeric($product_id)) {
                $product = Product::create(['product_type' => 'Service', 'name' => $bill_item->product_id, 'purchase_price' => $bill_item->price ?? 0, 'sell_unit' => $bill_item->unit ?? '',
                    'description' => $bill_item->description]);
                $product_id = $product->id;
            }

            ContactInvoiceItem::create(['contact_invoice_id' => $bill->id, 'product_id' => $product_id,
                'description' => $bill_item->description, 'workers' => $bill_item->workers, 'monthly_cost' => $bill_item->monthly_cost ?? '',
                'daily_cost' => $bill_item->daily_cost, 'working_days' => $bill_item->working_days, 'amount' => ($bill_item->workers ?? 0) * ($bill_item->daily_cost ?? 0) * ($bill_item->working_days ?? 0),
                'tax_id' => $bill_item->tax_id == '' ? 0 : $bill_item->tax_id, 'date' => $bill->invoice_date]);
        }
        foreach ($extraFields as $additional) {
            ContactInvoiceExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'contact_invoice_id' => $bill->id]);
        }

        foreach ($additionalFields as $additional) {
            ExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'type' => ContactInvoice::class, 'type_id' => $bill->id]);
        }

        $bill->payment_status = $bill->payment_status_text;
        $bill->save();
        if (!$bill->is_payment) return;
        $paymentSerial = 'CPM' . str_pad(ContactInvoicePayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $billPayment = ContactInvoicePayment::create([
            'contact_invoice_id' => $bill->id,
            'customer_id' => $bill->customer_id,
            'payment_method_id' => $bill->payment_method_id,
            'ledger_id' => $bill->deposit_to,
            'payment_sl' => $paymentSerial,
            'note' => $bill->notes,
            'payment_date' => $bill->invoice_date
        ]);

        ContactInvoicePaymentItem::create(['contact_invoice_payment_id' => $billPayment->id, 'contact_invoice_id' => $bill->id, 'amount' => $bill->payment_amount]);
        $bill->invoice_payment_id = $billPayment->id;
        $bill->save();

    }

    public function show($id)
    {

        $invoice = ContactInvoice::with('customer')->findOrFail($id);
        $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
//        dd($settings);
        $template = $settings->invoice_template ?? 'classic';

//        dd($template);
        $qr_code = route('invoices.invoice.share', [$invoice->secret, 'template' => $template]);
        $qr_code_style = $settings->qr_code_style ?? 'link';


        if ($qr_code_style == 'tlv') {
            $business_name = $settings->business_name ?? auth()->user()->name ?? 'Unknown Seller';


            $seller_name = $business_name;
            $vat_number = $settings->vat_reg ?? '123456789';
            $creating_time = Carbon::parse($invoice->created_at);
            $invoice_date = Carbon::parse($invoice->invoice_date)->toDateString() . ' ' . $creating_time->toTimeString();

            $taxable = number_format($invoice->invoice_items[0]->total, 2, '.', '');
            $tax = number_format($invoice->invoice_items[0]->tax_amount, 2, '.', '');

            $dataToEncode = [
                [1, $seller_name],
                [2, $vat_number],
                [3, $invoice_date],
                [4, $taxable],
                [5, $tax]
            ];

            $__TLV = __getTLV($dataToEncode);
            $__QR = base64_encode($__TLV);
            $qr_code = $__QR;


        } elseif ($qr_code_style == 'text') {
            $business_name = $settings->business_name ?? auth()->user()->name ?? 'Unknown Seller';
            $vat_number = $settings->vat_reg ?? '123456789';
            $creating_time = Carbon::parse($invoice->created_at);
            $invoice_date = Carbon::parse($invoice->invoice_date)->toDateString() . ' ' . $creating_time->toTimeString();
            $taxable = number_format($invoice->total, 2, '.', '');
            $tax = number_format($invoice->taxable_amount, 2, '.', '');

            $qr_code = " Seller Name: $business_name Vat Reg: $vat_number Total: $taxable Tax: $tax  Date and Time: $invoice_date";

        } elseif ($qr_code_style == 'hide') {
            $qr_code = '';
        }
        $contact_invoice = $invoice;
//        dd($contact_invoice->invoice_extra);
        return view('contact-invoices.show', compact('contact_invoice', 'qr_code_style', 'qr_code'));
    }

    public function saveTermsNDNote($data)
    {
        if (array_key_exists('terms_condition', $data)) {
            MetaSetting::query()->updateOrCreate(['key' => 'terms_condition'], ['key' => 'terms_condition', 'value' => $data['terms_condition']]);
        }
        if (array_key_exists('notes', $data)) {
            MetaSetting::query()->updateOrCreate(['key' => 'notes'], ['key' => 'notes', 'value' => $data['notes']]);
        }

    }

    public function edit($id)
    {

        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $contact_invoice = ContactInvoice::findOrFail($id);
//        $this->authorize('update', $bill);
        $customers = Customer::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $bill_items = ContactInvoiceItem::query()->where('contact_invoice_id', $contact_invoice->id)->get()->map(function ($item) {
            $item->stock = optional(Product::find($item->product_id))->stock ?? 0;
            return $item;
        });
        $categories = Category::query()->latest()->get();
        $billExtraField = ContactInvoiceExtraField::query()->where('contact_invoice_id', $contact_invoice->id)->get();
        $extraFields = ExtraField::query()->where('type', ContactInvoice::class)->where('type_id', $contact_invoice->id)->get();
        $products = Product::query()->latest()->get();

        return view('contact-invoices.edit', compact('contact_invoice', 'customers', 'taxes', 'bill_items', 'billExtraField', 'products', 'extraFields', 'categories', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);
        $bill_items = $data['bill_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
//        dd($data);
        unset($data['bill_items']);
        unset($data['additional']);
        unset($data['additional_fields']);

        $bill = ContactInvoice::findOrFail($id);
//        $this->authorize('update', $bill);

        ContactInvoiceExtraField::query()->where('contact_invoice_id', $bill->id)->delete();
        ContactInvoiceItem::query()->where('contact_invoice_id', $bill->id)->delete();
        ExtraField::query()->where('type', get_class($bill))->where('type_id', $bill->id)->delete();
        ContactInvoicePayment::query()->where('id', $bill->invoice_payment_id)->delete();
        ContactInvoicePaymentItem::query()->where('contact_invoice_payment_id', $bill->invoice_payment_id)->get()->each(function ($model) {
            $model->delete();
        });
        $bill->update($data);


        $this->insertDataToOtherTable($bill, $bill_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);


        return redirect()->route('contact_invoices.contact_invoice.show', $bill->id)->with('success_message', 'Invoice was successfully updated.');

    }


    public function destroy($id)
    {

        $bill = ContactInvoice::findOrFail($id);
//        $this->authorize('delete', $bill);
        ContactInvoiceExtraField::query()->where('contact_invoice_id', $bill->id)->delete();
        ContactInvoiceItem::query()->where('contact_invoice_id', $bill->id)->delete();
        ExtraField::query()->where('type', get_class($bill))->where('type_id', $bill->id)->delete();

        ContactInvoicePayment::query()->where('contact_invoice_id', $bill->id)->get()->each(function ($model) {
            $model->delete();
        });
        ContactInvoicePaymentItem::query()->where('contact_invoice_id', $bill->id)->get()->each(function ($model) {
            $model->delete();
        });
        $bill->delete();

        return redirect()->route('contact_invoices.contact_invoice.index')->with('success_message', 'Tax Invoice was successfully deleted.');

    }


    public function items($id)
    {
        $invoice = Bill::with('vendor')->findOrFail($id);
        return ['vendor_id' => $invoice->vendor_id, 'items' => $invoice->bill_items];
    }

    protected function getData(Request $request)
    {

        $rules = [
            'customer_id' => 'nullable',
            'invoice_number' => 'required',
            'order_number' => 'nullable|string|min:0',
            'invoice_date' => 'required',
            'due_date' => 'nullable',
            'discount_type' => 'nullable',
            'discount_value' => 'nullable',
            'discount' => 'nullable',
            'sub_total' => 'numeric',
            'shipping_charge' => 'numeric',
            'total' => 'numeric',
            'notes' => 'nullable|string|min:0',
            'attachment' => ['file', 'nullable'],
            'bill_items' => 'nullable',
            'additional' => 'nullable',
            'additional_fields' => 'nullable',
            'currency' => 'nullable',
            'shipping_date' => 'nullable',
            'is_payment' => 'nullable',
            'bill_payment_id' => 'nullable',
            'payment_method_id' => 'nullable',
            'ledger_id' => 'nullable',
            'payment_amount' => 'nullable',
            'from_advance' => 'nullable',
        ];

        $data = $request->validate($rules);

        $data['bill_items'] = json_decode($data['bill_items'] ?? '{}');
        $data['additional'] = json_decode($data['additional'] ?? '{}');
        $data['additional_fields'] = json_decode($data['additional_fields'] ?? '{}');
        $data['is_payment'] = $request->has('is_payment');
        if ($request->has('custom_delete_attachment')) {
            $data['attachment'] = null;
        }
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $this->moveFile($request->file('attachment'));
        }


        return $data;
    }


    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }

        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }

    public function send($id)
    {
        $bill = Bill::with('customer')->findOrFail($id);
        $title = "Send Bill - " . $bill->bill_number;
        $this->settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

//        dd($bill, $this->settings, auth()->user(), MetaSetting::query()->pluck('value', 'key')->toJson());
        $from = $this->settings->email ?? '';
        $to = null;
        if (optional($bill->customer)->email) {
            $to = optional($bill->customer)->email;
        }
        $customerName = optional($bill->customer)->name ?? 'Customer';
        $subject = "Bill #" . ($bill->bill_number ?? '') . ' from ' . ($this->settings->business_name ?? 'n/a');
        $businessName = $this->settings->business_name ?? 'Company Name';
        $businessEmail = $this->settings->email ?? '';
        $businessPhone = $this->settings->phone ?? '';
        $businessWebsite = $this->settings->website ?? '';
        $message = "Hi $customerName ,<br><br> I hope you’re well! Please see attached bill number [$bill->bill_number] , due on [$bill->due_date]. Don’t hesitate to reach out if you have any questions. <br> Bill#: $bill->bill_number  <br>Date: $bill->bill_date <br>Amount: $bill->total <br> <br> Kind regards,  <br> $businessName <br> $businessEmail <br> $businessPhone <br> $businessWebsite";

//        dd($message);
        return view('bills.send', compact('bill', 'title', 'from', 'to', 'subject', 'message'));
    }

    public function sendBillMail(Request $request, Bill $bill)
    {
        $data = $request->all();
        $to = [];
        foreach (json_decode($data['to'] ?? '{}') as $item) {
            $validator = validator()->make(['email' => $item->value], [
                'email' => 'email'
            ]);
            if ($validator->passes()) {
                $to[] = $item->value;
            }
        }
        $data['send_to_business'] = $request->has('send_to_business');
        $data['attach_pdf'] = $request->has('attach_pdf');
        $data['to'] = $to;

        $bill->bill_status = "sent";
        $bill->save();


        Mail::to($to)->queue(new BillSendMail($bill, (object)$data, settings()));


        return redirect()->route('bills.bill.index')->with('success_message', 'Bill was sent successfully.');
    }

    public function share($secret)
    {
        $bill = Bill::query()->with('vendor')->where('secret', $secret)->firstOrFail();
        $settings = json_decode(MetaSetting::query()->where('client_id', $bill->client_id)->pluck('value', 'key')->toJson());
//        dd($bill->client_id, $settings);
        return view('bills.share', compact('bill', 'settings'));
    }

}
