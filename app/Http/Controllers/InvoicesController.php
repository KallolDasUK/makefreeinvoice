<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSendMail;
use App\Models\AppMail;
use App\Models\Category;
use App\Models\Customer;
use App\Models\ExtraField;
use App\Models\Invoice;
use App\Models\InvoiceExtraField;
use App\Models\InvoiceItem;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\Tax;
use App\Observers\InvoiceObserver;
use App\Traits\SettingsTrait;
use Carbon\Carbon;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvoicesController extends Controller
{
    use TransactionTrait, SettingsTrait;

    public $settings;

    public function __construct()
    {
//        dd($this->settings);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Invoice::class);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $customer_id = $request->customer;
        $q = $request->q;
        $invoices = Invoice::with('customer')
            ->when($customer_id != null, function ($query) use ($customer_id) {
                return $query->where('customer_id', $customer_id);
            })->when($q != null, function ($query) use ($q) {
                return $query->where('invoice_number', 'like', '%' . $q . '%');
            })
            ->when($start_date != null && $end_date != null, function ($query) use ($start_date, $end_date) {
                $start_date = Carbon::parse($start_date)->toDateString();
                $end_date = Carbon::parse($end_date)->toDateString();
                return $query->whereBetween('invoice_date', [Carbon::parse($start_date), Carbon::parse($end_date)]);
            })
            ->latest()
            ->paginate(10);
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $customers = Customer::all();

        return view('invoices.index', compact('invoices', 'q', 'cashAcId', 'depositAccounts', 'paymentMethods', 'start_date', 'end_date', 'customer_id', 'customers') + $this->summaryReport());
    }

    public function summaryReport()
    {


        return ['overdue' => Invoice::overdue(), 'draft' => Invoice::draft(), 'due_next_30' => Invoice::dueNext30(), 'paid' => Invoice::paid()];
    }

    public function create()
    {
        $this->authorize('create', Invoice::class);
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $customers = Customer::pluck('name', 'id')->all();
        $products = Product::query()->latest()->get();
        $categories = Category::query()->latest()->get();
        $taxes = Tax::query()->latest()->get()->toArray();
        $extraFields = optional(Invoice::query()->latest()->first())->extra_fields ?? [];
        $invoice_fields = optional(Invoice::query()->latest()->first())->invoice_extra ?? [];
        $next_invoice = 'INV-' . str_pad(count(Invoice::query()->get()) + 1, 4, '0', STR_PAD_LEFT);

        return view('invoices.create', compact('customers', 'products', 'taxes', 'next_invoice', 'categories', 'extraFields', 'invoice_fields', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }


    public function store(Request $request)
    {
        $this->authorize('create', Invoice::class);


        $data = $this->getData($request);

        $random = Str::random(40);
        $data['secret'] = $random;
        $invoice_items = $data['invoice_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
        unset($data['invoice_items']);
        unset($data['additional']);
        unset($data['additional_fields']);
        unset($data['business_logo']);

        $invoice = Invoice::create($data);

        $this->insertDataToOtherTable($invoice, $invoice_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
        $invoice_observer = new InvoiceObserver;
        $invoice_observer->invoice_item_created($invoice);


        return redirect()->route('invoices.invoice.show', $invoice->id)
            ->with('success_message', 'Invoice was successfully added.');

    }

    public function insertDataToOtherTable($invoice, $invoice_items, $extraFields, $additionalFields)
    {
//        dd($invoice_items);
        foreach ($invoice_items as $invoice_item) {
            $product_id = $invoice_item->product_id;
            if (!is_numeric($product_id)) {
                $product = Product::create(['product_type' => 'Service', 'name' => $invoice_item->product_id, 'sell_price' => $invoice_item->price, 'sell_unit' => $invoice_item->unit ?? '',
                    'description' => $invoice_item->description]);
                $product_id = $product->id;
            }

            InvoiceItem::create(['invoice_id' => $invoice->id, 'product_id' => $product_id,
                'description' => $invoice_item->description, 'qnt' => $invoice_item->qnt, 'unit' => $invoice_item->unit ?? '',
                'price' => $invoice_item->price, 'amount' => $invoice_item->price * $invoice_item->qnt, 'tax_id' => $invoice_item->tax_id == '' ? 0 : $invoice_item->tax_id, 'date' => $invoice->invoice_date]);
        }
        foreach ($extraFields as $additional) {
            InvoiceExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'invoice_id' => $invoice->id]);
        }

        foreach ($additionalFields as $additional) {
            ExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'type' => Invoice::class, 'type_id' => $invoice->id]);
        }


        if (!$invoice->is_payment) return;
        $paymentSerial = 'PM' . str_pad(ReceivePayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $receivePayment = ReceivePayment::create([
            'payment_date' => $invoice->invoice_date,
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'payment_method_id' => $invoice->payment_method_id,
            'deposit_to' => $invoice->deposit_to,
            'payment_sl' => $paymentSerial,
            'payment_sl' => $invoice->invoice_date,
            'note' => $invoice->notes
        ]);

        ReceivePaymentItem::create(['receive_payment_id' => $receivePayment->id, 'invoice_id' => $invoice->id, 'amount' => $invoice->payment_amount]);
        $invoice->receive_payment_id = $receivePayment->id;
        $invoice->save();

    }

    public function show($id)
    {

        $invoice = Invoice::with('customer')->findOrFail($id);
        $this->authorize('view', $invoice);

        $invoice->taxes;
        return view('invoices.show', compact('invoice'));
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
        $invoice = Invoice::findOrFail($id);

        $this->authorize('update', $invoice);
        $customers = Customer::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $invoice_items = InvoiceItem::query()->where('invoice_id', $invoice->id)->get();
        $categories = Category::query()->latest()->get();
        $invoiceExtraField = InvoiceExtraField::query()->where('invoice_id', $invoice->id)->get();
        $extraFields = ExtraField::query()->where('type', Invoice::class)->where('type_id', $invoice->id)->get();
        $products = Product::query()->latest()->get();
//        dd($invoice_items);
        return view('invoices.edit', compact('invoice', 'customers', 'taxes', 'invoice_items', 'invoiceExtraField', 'products', 'extraFields', 'categories', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }


    public function update($id, Request $request)
    {

        $invoice = Invoice::findOrFail($id);
        $this->authorize('update', $invoice);

        $data = $this->getData($request);
        $invoice_items = $data['invoice_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
//        dd($data);
        unset($data['invoice_items']);
        unset($data['additional']);
        unset($data['additional_fields']);


        InvoiceExtraField::query()->where('invoice_id', $invoice->id)->delete();
        InvoiceItem::query()->where('invoice_id', $invoice->id)->delete();
        ExtraField::query()->where('type', get_class($invoice))->where('type_id', $invoice->id)->delete();
        ReceivePayment::query()->where('id', $invoice->receive_payment_id)->delete();
        ReceivePaymentItem::query()->where('receive_payment_id', $invoice->receive_payment_id)->get()->each(function ($model) {
            $model->delete();
        });


        $invoice->update($data);
        $this->insertDataToOtherTable($invoice, $invoice_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
        $invoice_observer = new InvoiceObserver;
        $invoice_observer->invoice_item_updated($invoice);
        return redirect()->route('invoices.invoice.show', $invoice->id)->with('success_message', 'Invoice was successfully updated.');

    }


    public function destroy($id)
    {

        $invoice = Invoice::findOrFail($id);
        $this->authorize('delete', $invoice);
        InvoiceExtraField::query()->where('invoice_id', $invoice->id)->delete();
        InvoiceItem::query()->where('invoice_id', $invoice->id)->delete();
        ExtraField::query()->where('type', get_class($invoice))->where('type_id', $invoice->id)->delete();

        ReceivePaymentItem::query()->where('invoice_id', $invoice->id)->get()->each(function ($model) {
            try {
                $model->receive_payment->delete();
            } catch (\Exception $exception) {
            }
            $model->delete();
        });
        $invoice->delete();

        return redirect()->route('invoices.invoice.index')->with('success_message', 'Invoice was successfully deleted.');

    }


    protected function getData(Request $request)
    {

        $rules = [
            'customer_id' => 'nullable',
            'invoice_number' => 'required',
            'order_number' => 'nullable|string|min:0',
            'invoice_date' => 'required',
            'payment_terms' => 'nullable',
            'due_date' => 'nullable',
            'discount_type' => 'nullable',
            'discount_value' => 'nullable',
            'discount' => 'nullable',
            'sub_total' => 'numeric',
            'shipping_charge' => 'numeric',
            'total' => 'numeric',
            'terms_condition' => 'nullable|string|min:0',
            'notes' => 'nullable|string|min:0',
            'attachment' => ['file', 'nullable'],
            'invoice_items' => 'nullable',
            'additional' => 'nullable',
            'additional_fields' => 'nullable',
            'business-logo' => 'nullable',
            'currency' => 'nullable',
            'shipping_date' => 'nullable',
            'is_payment' => 'nullable',
            'payment_method_id' => 'nullable',
            'deposit_to' => 'nullable',
            'payment_amount' => 'nullable',
        ];

        $data = $request->validate($rules);

        $data['invoice_items'] = json_decode($data['invoice_items'] ?? '{}');
        $data['additional'] = json_decode($data['additional'] ?? '{}');
        $data['additional_fields'] = json_decode($data['additional_fields'] ?? '{}');
        $data['is_payment'] = $request->has('is_payment');
        if ($request->has('custom_delete_attachment')) {
            $data['attachment'] = null;
        }
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $this->moveFile($request->file('attachment'));
        }
        if ($request->hasFile('business_logo')) {

            MetaSetting::query()->updateOrCreate(['key' => 'business_logo'], ['key' => 'business_logo', 'value' => $this->moveFile($request->file('business_logo'))]);
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
        $invoice = Invoice::with('customer')->findOrFail($id);
        $title = "Send Invoice - " . $invoice->invoice_number;
        $this->settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

//        dd($invoice, $this->settings, auth()->user(), MetaSetting::query()->pluck('value', 'key')->toJson());
        $from = $this->settings->email ?? '';
        $to = null;
        if (optional($invoice->customer)->email) {
            $to = optional($invoice->customer)->email;
        }
        $customerName = optional($invoice->customer)->name ?? 'Customer';
        $subject = "Invoice #" . ($invoice->invoice_number ?? '') . ' from ' . ($this->settings->business_name ?? 'n/a');
        $businessName = $this->settings->business_name ?? 'Company Name';
        $businessEmail = $this->settings->email ?? '';
        $businessPhone = $this->settings->phone ?? '';
        $businessWebsite = $this->settings->website ?? '';
        $message = "Hi $customerName ,<br><br> I hope you’re well! Please see attached invoice number [$invoice->invoice_number] , due on [$invoice->due_date]. Don’t hesitate to reach out if you have any questions. <br> Invoice#: $invoice->invoice_number  <br>Date: $invoice->invoice_date <br>Amount: $invoice->total <br> <br> Kind regards,  <br> $businessName <br> $businessEmail <br> $businessPhone <br> $businessWebsite";

//        dd($message);
        return view('invoices.send', compact('invoice', 'title', 'from', 'to', 'subject', 'message'));
    }

    public function sendInvoiceMail(Request $request, Invoice $invoice)
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

        $invoice->invoice_status = "sent";
        $invoice->save();


        Mail::to($to)->queue(new InvoiceSendMail($invoice, (object)$data, settings()));


        return redirect()->route('invoices.invoice.index')->with('success_message', 'Invoice was sent successfully.');
    }

    public function share($secret)
    {
        $invoice = Invoice::query()->with('customer')->where('secret', $secret)->firstOrFail();
        $settings = json_decode(MetaSetting::query()->where('client_id', $invoice->client_id)->pluck('value', 'key')->toJson());
//        dd($invoice->client_id, $settings);
        return view('invoices.share', compact('invoice', 'settings'));
    }

}
