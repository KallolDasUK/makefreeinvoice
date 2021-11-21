<?php

namespace App\Http\Controllers\Estimates;

use App\Http\Controllers\Controller;
use App\Mail\EstimateSendMail;
use App\Models\AppMail;
use App\Models\Category;
use App\Models\Customer;
use App\Models\ExtraField;
use App\Models\Estimate;
use App\Models\EstimateExtraField;
use App\Models\EstimateItem;
use App\Models\Invoice;
use App\Models\InvoiceExtraField;
use App\Models\InvoiceItem;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\Tax;
use App\Traits\SettingsTrait;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EstimatesController extends Controller
{
    use TransactionTrait, SettingsTrait;

    public $settings;

    public function __construct()
    {
//        dd($this->settings);
    }

    public function index()
    {
        $estimates = Estimate::with('customer')->latest()->paginate(10);
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        return view('estimates.index', compact('estimates', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }


    public function create()
    {
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $customers = Customer::pluck('name', 'id')->all();
        $products = Product::query()->latest()->get();
        $categories = Category::query()->latest()->get();
        $taxes = Tax::query()->latest()->get()->toArray();
        $extraFields = optional(Estimate::query()->latest()->first())->extra_fields ?? [];
        $estimate_fields = optional(Estimate::query()->latest()->first())->estimate_extra ?? [];
        $next_invoice = 'EST-' . str_pad(count(Estimate::query()->get()) + 1, 4, '0', STR_PAD_LEFT);

        return view('estimates.create', compact('customers', 'products', 'taxes', 'next_invoice', 'categories', 'extraFields', 'estimate_fields', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $random = Str::random(40);
        $data['secret'] = $random;
        $estimate_items = $data['estimate_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
        unset($data['estimate_items']);
        unset($data['additional']);
        unset($data['additional_fields']);
        unset($data['business_logo']);

        $estimate = Estimate::create($data);

        $this->insertDataToOtherTable($estimate, $estimate_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
        return redirect()->route('estimates.estimate.show', $estimate->id)
            ->with('success_message', 'Invoice was successfully added.');

    }

    public function insertDataToOtherTable($estimate, $estimate_items, $extraFields, $additionalFields)
    {
        foreach ($estimate_items as $estimate_item) {
            $product_id = $estimate_item->product_id;
            if (!is_numeric($product_id)) {
                $product = Product::create(['product_type' => 'Service', 'name' => $estimate_item->product_id, 'sell_price' => $estimate_item->price, 'sell_unit' => $estimate_item->unit ?? '',
                    'description' => $estimate_item->description]);
                $product_id = $product->id;
            }

            EstimateItem::create(['estimate_id' => $estimate->id, 'product_id' => $product_id,
                'description' => $estimate_item->description, 'qnt' => $estimate_item->qnt, 'unit' => $estimate_item->unit ?? '',
                'price' => $estimate_item->price, 'amount' => $estimate_item->price * $estimate_item->qnt, 'tax_id' => $estimate_item->tax_id == '' ? 0 : $estimate_item->tax_id, 'date' => $estimate->estimate_date]);
        }
        foreach ($extraFields as $additional) {
            EstimateExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'estimate_id' => $estimate->id]);
        }

        foreach ($additionalFields as $additional) {
            ExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'type' => Estimate::class, 'type_id' => $estimate->id]);
        }


    }

    public function show(Request $request, $id)
    {
        $estimate = Estimate::with('customer')->findOrFail($id);
        $is_print = $request->print ?? false;
        $is_download = $request->download ?? false;
        return view('estimates.show', compact('estimate', 'is_print', 'is_download'));
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
        $estimate = Estimate::findOrFail($id);
        $customers = Customer::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $estimate_items = EstimateItem::query()->where('estimate_id', $estimate->id)->get();
        $categories = Category::query()->latest()->get();
        $estimateExtraField = EstimateExtraField::query()->where('estimate_id', $estimate->id)->get();
        $extraFields = ExtraField::query()->where('type', Estimate::class)->where('type_id', $estimate->id)->get();
        $products = Product::query()->latest()->get();
        $next_invoice = 'EST-' . str_pad(count(Estimate::query()->get()) + 1, 4, '0', STR_PAD_LEFT);

        return view('estimates.edit', compact('estimate', 'customers', 'taxes', 'estimate_items', 'estimateExtraField', 'products', 'extraFields', 'categories', 'cashAcId', 'depositAccounts', 'paymentMethods', 'next_invoice'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);
        $estimate_items = $data['estimate_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
        unset($data['estimate_items']);
        unset($data['additional']);
        unset($data['additional_fields']);

        $estimate = Estimate::findOrFail($id);
        $estimate->update($data);
        EstimateExtraField::query()->where('estimate_id', $estimate->id)->delete();
        EstimateItem::query()->where('estimate_id', $estimate->id)->delete();
        ExtraField::query()->where('type', get_class($estimate))->where('type_id', $estimate->id)->delete();
        ReceivePayment::query()->where('id', $estimate->receive_payment_id)->delete();
        ReceivePaymentItem::query()->where('receive_payment_id', $estimate->receive_payment_id)->delete();

        $this->insertDataToOtherTable($estimate, $estimate_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);


        return redirect()->route('estimates.estimate.show', $estimate->id)->with('success_message', 'Invoice was successfully updated.');

    }


    public function destroy($id)
    {

        $this->delete($id);

        return redirect()->route('estimates.estimate.index')->with('success_message', 'Invoice was successfully deleted.');

    }

    public function delete($id)
    {
        $estimate = Estimate::findOrFail($id);
        EstimateExtraField::query()->where('estimate_id', $estimate->id)->delete();
        EstimateItem::query()->where('estimate_id', $estimate->id)->delete();
        ExtraField::query()->where('type', get_class($estimate))->where('type_id', $estimate->id)->delete();
        $estimate->delete();
    }


    protected function getData(Request $request)
    {

        $rules = [
            'customer_id' => 'nullable',
            'estimate_number' => 'required',
            'order_number' => 'nullable|string|min:0',
            'estimate_date' => 'required',
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
            'estimate_items' => 'nullable',
            'additional' => 'nullable',
            'additional_fields' => 'nullable',
            'business-logo' => 'nullable',
            'currency' => 'nullable',
            'shipping_date' => 'nullable',

        ];

        $data = $request->validate($rules);

        $data['estimate_items'] = json_decode($data['estimate_items'] ?? '{}');
        $data['additional'] = json_decode($data['additional'] ?? '{}');
        $data['additional_fields'] = json_decode($data['additional_fields'] ?? '{}');
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
        $estimate = Estimate::with('customer')->findOrFail($id);
        $title = "Send Estimate - " . $estimate->estimate_number;
        $this->settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

//        dd($estimate, $this->settings, auth()->user(), MetaSetting::query()->pluck('value', 'key')->toJson());
        $from = $this->settings->email ?? '';
        $to = null;
        if (optional($estimate->customer)->email) {
            $to = optional($estimate->customer)->email;
        }
        $customerName = optional($estimate->customer)->name ?? 'Customer';
        $subject = "Estimate #" . ($estimate->estimate_number ?? '') . ' from ' . ($this->settings->business_name ?? 'n/a');
        $businessName = $this->settings->business_name ?? 'Company Name';
        $message = "Hi $customerName ,<br><br> I hope you’re well! Please see attached estimate number [$estimate->estimate_number] , expires on [$estimate->due_date]. Don’t hesitate to reach out if you have any questions. <br> Invoice#: $estimate->estimate_number  <br>Date: $estimate->estimate_date <br>Amount: $estimate->total <br> <br> Kind regards,  <br> $businessName";

//        dd($message);
        return view('estimates.send', compact('estimate', 'title', 'from', 'to', 'subject', 'message'));
    }

    public function sendEstimateMail(Request $request, Estimate $estimate)
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

        $estimate->estimate_status = "sent";
        $estimate->save();


        Mail::to($to)->queue(new EstimateSendMail($estimate, (object)$data, settings()));


        return redirect()->route('estimates.estimate.index')->with('success_message', 'Invoice was sent successfully.');
    }

    public function share($secret)
    {
        $estimate = Estimate::query()->with('customer')->where('secret', $secret)->firstOrFail();
        $settings = json_decode(MetaSetting::query()->where('client_id', $estimate->client_id)->pluck('value', 'key')->toJson());
//        dd($estimate->client_id, $settings);
        return view('estimates.share', compact('estimate', 'settings'));
    }

    public function convertToInvoice(Estimate $estimate)
    {

        $invoiceData = $estimate->toArray();
//        dd($estimate->estimate_extra()->get());
        $invoiceData['invoice_number'] = Invoice::nextInvoiceNumber();
        $invoiceData['invoice_date'] = $invoiceData['estimate_date'];
        $invoiceData['is_payment'] = false;
        $invoiceData['payment_method_id'] = null;
        $invoiceData['deposit_to'] = null;
        $invoiceData['payment_amount'] = null;

        unset($invoiceData['id']);
        unset($invoiceData['estimate_number']);
        unset($invoiceData['estimate_date']);
        unset($invoiceData['updated_at']);
        unset($invoiceData['created_at']);
        unset($invoiceData['estimate_status']);

        $invoice_id = Invoice::create($invoiceData)->id;
        $invoiceItemData = $estimate->estimate_items()->get()->map(function ($item) use ($invoice_id) {
            $item->invoice_id = $invoice_id;
            unset($item->id);
            unset($item->estimate_id);
            unset($item->created_at);
            unset($item->updated_at);
            return $item;
        })->toArray();
        InvoiceItem::insert($invoiceItemData);

        $invoiceExtraFieldData = $estimate->estimate_extra()->get()->map(function ($item) use ($invoice_id) {
            $item->invoice_id = $invoice_id;
            unset($item->id);
            unset($item->estimate_id);
            unset($item->created_at);
            unset($item->updated_at);
            return $item;
        })->toArray();
        InvoiceExtraField::insert($invoiceExtraFieldData);
        ExtraField::query()
            ->where('type', Estimate::class)
            ->where('type_id', $estimate->id)
            ->update(['type' => Invoice::class, 'type_id' => $invoice_id]);

        // Deleting Estimate
        $this->delete($estimate->id);

        return redirect()->route('invoices.invoice.edit', $invoice_id);
    }

}
