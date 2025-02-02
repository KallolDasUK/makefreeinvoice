<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSendMail;
use App\Models\AppMail;
use App\Models\Bill;
use App\Models\Category;
use App\Models\ExtraField;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnExtra;
use App\Models\PurchaseReturnItem;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\SalesReturn;
use App\Models\SalesReturnExtraField;
use App\Models\SalesReturnItem;
use App\Models\Tax;
use App\Models\Vendor;
use App\Observers\InvoiceObserver;
use App\Traits\SettingsTrait;
use Carbon\Carbon;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PurchaseReturnsController extends Controller
{
    use TransactionTrait, SettingsTrait;

    public $settings;

    public function index(Request $request)
    {
        view()->share('title', "All Purchase Returns");
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $vendor_id = $request->vendor;
        $sr_id = $request->sr_id;
        $q = $request->q;
        $invoices = PurchaseReturn::with('vendor')
            ->when($vendor_id != null, function ($query) use ($vendor_id) {
                return $query->where('vendor_id', $vendor_id);
            })->when($q != null, function ($query) use ($q) {
                return $query->where('purchase_return_number', 'like', '%' . $q . '%');
            })
            ->when($start_date != null && $end_date != null, function ($query) use ($start_date, $end_date) {
                $start_date = Carbon::parse($start_date)->toDateString();
                $end_date = Carbon::parse($end_date)->toDateString();
                return $query->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)]);
            })
            ->latest()
            ->paginate(10);
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $vendors = Vendor::all();
        $ledgerGroups = LedgerGroup::all();
//        dd($invoices);
        return view('purchase_return.index', compact('invoices', 'q', 'cashAcId', 'depositAccounts',
                'paymentMethods',
                'start_date', 'end_date', 'vendor_id', 'vendors', 'ledgerGroups', 'sr_id') + $this->summaryReport($start_date, $end_date));
    }

    public function summaryReport($start_date, $end_date)
    {
        return ['overdue' => Invoice::overdue($start_date, $end_date), 'draft' => Invoice::draft($start_date, $end_date), 'paid' => Invoice::paid($start_date, $end_date), 'due' => Invoice::due($start_date, $end_date), 'total' => Invoice::total($start_date, $end_date)];
    }

    public function create()
    {
        $this->authorize('create', Bill::class);
        $cashAcId = Ledger::CASH_AC();
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $vendors = Vendor::pluck('name', 'id')->all();
        $products = Product::query()->latest()->get();
        $categories = Category::query()->latest()->get();
        $taxes = Tax::query()->latest()->get()->toArray();
        $extraFields = optional(PurchaseReturn::query()->latest()->first())->extra_fields ?? [];
        $invoice_fields = optional(PurchaseReturn::query()->latest()->first())->purchase_return_extra ?? [];
        $next_invoice = PurchaseReturn::nextInvoiceNumber();
        $ledgerGroups = LedgerGroup::all();
        $title = "Register Purchase Return";
        return view('purchase_return.create', compact('vendors', 'ledgerGroups', 'title', 'products', 'taxes', 'next_invoice', 'categories', 'extraFields', 'invoice_fields', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Bill::class);


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

        $invoice = PurchaseReturn::create($data);

        $this->insertDataToOtherTable($invoice, $invoice_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
//        $invoice_observer = new InvoiceObserver;
//        $invoice_observer->invoice_item_created($invoice);

        return redirect()->route('purchase_returns.purchase_return.show', $invoice->id)
            ->with('success_message', 'Return was successfully added.');

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

            PurchaseReturnItem::create(['purchase_return_id' => $invoice->id, 'product_id' => $product_id,
                'description' => $invoice_item->description, 'qnt' => $invoice_item->qnt, 'unit' => $invoice_item->unit ?? '',
                'price' => $invoice_item->price, 'amount' => $invoice_item->price * $invoice_item->qnt, 'tax_id' => $invoice_item->tax_id == '' ? 0 : $invoice_item->tax_id, 'date' => $invoice->date]);
        }
        foreach ($extraFields as $additional) {
            PurchaseReturnExtra::create(['name' => $additional->name, 'value' => $additional->value, 'purchase_return_id' => $invoice->id]);
        }

        foreach ($additionalFields as $additional) {
            ExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'type' => PurchaseReturn::class, 'type_id' => $invoice->id]);
        }

        $accounting = new AccountingFacade();
        $accounting->on_purchase_return_delete($invoice);
        $accounting->on_purchase_return_create($invoice);


    }

    public function show($id)
    {
        view()->share('title', "Purchase Return Invoice");

        $purchaseReturn = PurchaseReturn::with('vendor')->findOrFail($id);

        return view('purchase_return.show', compact('purchaseReturn'));
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

        view()->share('title', "Edit Purchase Return");

        $cashAcId = Ledger::CASH_AC();
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $invoice = PurchaseReturn::findOrFail($id);

//        $this->authorize('update', $invoice);
        $vendors = Vendor::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $invoice_items = PurchaseReturnItem::query()->where('purchase_return_id', $invoice->id)->get();
        $categories = Category::query()->latest()->get();
        $invoiceExtraField = PurchaseReturnExtra::query()->where('purchase_return_id', $invoice->id)->get();
        $extraFields = ExtraField::query()->where('type', PurchaseReturn::class)->where('type_id', $invoice->id)->get();
        $products = Product::query()->latest()->get();
//        dd($invoice_items);
        $ledgerGroups = LedgerGroup::all();
        $next_invoice = '';

//        dd($invoice->invoice_items);
        return view('purchase_return.edit', compact('invoice', 'ledgerGroups', 'vendors', 'taxes',
            'invoice_items', 'invoiceExtraField', 'products', 'extraFields', 'categories', 'cashAcId',
            'depositAccounts', 'paymentMethods', 'next_invoice'));
    }

    public function update($id, Request $request)
    {

        $invoice = PurchaseReturn::findOrFail($id);
//        $this->authorize('update', $invoice);

        $data = $this->getData($request);
        $invoice_items = $data['invoice_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
//        dd($data);
        unset($data['invoice_items']);
        unset($data['additional']);
        unset($data['additional_fields']);


        PurchaseReturnExtra::query()->where('purchase_return_id', $invoice->id)->delete();
        PurchaseReturnItem::query()->where('purchase_return_id', $invoice->id)->delete();
        ExtraField::query()->where('type', get_class($invoice))->where('type_id', $invoice->id)->delete();


        $invoice->update($data);
        $this->insertDataToOtherTable($invoice, $invoice_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
        return redirect()->route('purchase_returns.purchase_return.index', $invoice->id)->with('success_message', 'Invoice was successfully updated.');

    }

    public function destroy($id)
    {

        $invoice = PurchaseReturn::findOrFail($id);
        PurchaseReturnExtra::query()->where('purchase_return_id', $invoice->id)->delete();
        PurchaseReturnItem::query()->where('purchase_return_id', $invoice->id)->delete();
        ExtraField::query()->where('type', get_class($invoice))->where('type_id', $invoice->id)->delete();

        $accounting = new AccountingFacade();
        $accounting->on_purchase_return_delete($invoice);
        $invoice->delete();

        return redirect()->route('purchase_returns.purchase_return.index')->with('success_message', 'Purchase Return was successfully deleted.');

    }

    protected function getData(Request $request)
    {

        $rules = [
            'vendor_id' => 'nullable',
            'bill_number' => 'required',
            'purchase_return_number' => 'nullable|string|min:0',
            'date' => 'required',
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
        $data['is_payment'] = $request->is_payment == 1;

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


}
