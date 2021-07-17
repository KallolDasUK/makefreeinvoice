<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\ExtraField;
use App\Models\Invoice;
use App\Models\InvoiceExtraField;
use App\Models\InvoiceItem;
use App\Models\MetaSetting;
use App\Models\Product;
use App\Models\Tax;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{


    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(2);

        return view('invoices.index', compact('invoices'));
    }


    public function create()
    {
//        dd(html_entity_decode(currencies()[0]['symbol']));
//        dd(currencies());
        $customers = Customer::pluck('name', 'id')->all();
        $products = Product::query()->latest()->get();
        $categories = Category::query()->latest()->get();
        $taxes = Tax::query()->latest()->get()->toArray();
        $extraFields = ExtraField::query()->where('type', Invoice::class)->where('name', '!=', '')->get();

        $next_invoice = str_pad(count(Invoice::query()->get()) + 1, 4, '0', STR_PAD_LEFT);


        return view('invoices.create', compact('customers', 'products', 'taxes', 'next_invoice', 'categories', 'extraFields'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
//        dd($request->all());

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
        return redirect()->route('invoices.invoice.index')
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
                'price' => $invoice_item->price, 'amount' => $invoice_item->price * $invoice_item->qnt, 'tax_id' => $invoice_item->tax_id == '' ? 0 : $invoice_item->tax_id]);
        }
        foreach ($extraFields as $additional) {
            InvoiceExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'invoice_id' => $invoice->id]);
        }

        foreach ($additionalFields as $additional) {
            ExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'type' => Invoice::class, 'type_id' => $invoice->id]);
        }
    }

    public function show($id)
    {
        $invoice = Invoice::with('customer')->findOrFail($id);
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
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $invoice_items = InvoiceItem::query()->where('invoice_id', $invoice->id)->get();
        $categories = Category::query()->latest()->get();
        $invoiceExtraField = InvoiceExtraField::query()->where('invoice_id', $invoice->id)->get();
        $extraFields = ExtraField::query()->where('type', Invoice::class)->where('type_id', $invoice->id)->get();
        $products = Product::query()->latest()->get();

        return view('invoices.edit', compact('invoice', 'customers', 'taxes', 'invoice_items', 'invoiceExtraField', 'products', 'extraFields', 'categories'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);
        $invoice_items = $data['invoice_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
        unset($data['invoice_items']);
        unset($data['additional']);
        unset($data['additional_fields']);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($data);
        InvoiceExtraField::query()->where('invoice_id', $invoice->id)->delete();
        InvoiceItem::query()->where('invoice_id', $invoice->id)->delete();
        ExtraField::query()->where('type', get_class($invoice))->where('type_id', $invoice->id)->delete();
        $this->insertDataToOtherTable($invoice, $invoice_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);


        return redirect()->route('invoices.invoice.index')->with('success_message', 'Invoice was successfully updated.');

    }


    public function destroy($id)
    {

        $invoice = Invoice::findOrFail($id);
        InvoiceExtraField::query()->where('invoice_id', $invoice->id)->delete();
        InvoiceItem::query()->where('invoice_id', $invoice->id)->delete();
        ExtraField::query()->where('type', get_class($invoice))->where('type_id', $invoice->id)->delete();
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
        ];

        $data = $request->validate($rules);

        $data['invoice_items'] = json_decode($data['invoice_items'] ?? '{}');
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
}
