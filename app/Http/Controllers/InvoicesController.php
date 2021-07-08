<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceExtraField;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Tax;
use Exception;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{


    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->get();

        return view('invoices.index', compact('invoices'));
    }


    public function create()
    {
        $customers = Customer::pluck('name', 'id')->all();
        $products = Product::query()->latest()->get();
        $taxes = Tax::query()->latest()->get()->toArray();
        return view('invoices.create', compact('customers', 'products', 'taxes'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
//        dd($data);
        $invoice_items = $data['invoice_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        unset($data['invoice_items']);
        unset($data['additional']);

        $invoice = Invoice::create($data);
        foreach ($invoice_items as $invoice_item) {
            InvoiceItem::create(['invoice_id' => $invoice->id, 'product_id' => $invoice_item->product_id,
                'description' => $invoice_item->description, 'qnt' => $invoice_item->qnt, 'unit' => $invoice_item->unit ?? '',
                'price' => $invoice_item->price, 'amount' => $invoice_item->price * $invoice_item->qnt, 'tax_id' => $invoice_item->tax_id]);
        }
        foreach ($extraFields as $additional) {
            InvoiceExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'invoice_id' => $invoice->id]);
        }

        return redirect()->route('invoices.invoice.index')
            ->with('success_message', 'Invoice was successfully added.');

    }


    public function show($id)
    {
        $invoice = Invoice::with('customer')->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }


    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $invoice_items = InvoiceItem::query()->where('invoice_id', $invoice->id)->get();
        $additional = InvoiceItem::query()->where('invoice_id', $invoice->id)->get();
        $products = Product::query()->latest()->get();

//        dd($invoice_items,$additional);
        return view('invoices.edit', compact('invoice', 'customers', 'taxes', 'invoice_items', 'additional', 'products'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($data);

        return redirect()->route('invoices.invoice.index')
            ->with('success_message', 'Invoice was successfully updated.');

    }


    public function destroy($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            InvoiceExtraField::query()->where('invoice_id', $invoice->id)->delete();
            InvoiceItem::query()->where('invoice_id', $invoice->id)->delete();
            $invoice->delete();

            return redirect()->route('invoices.invoice.index')
                ->with('success_message', 'Invoice was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
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
            'discount_type' => 'string',
            'discount_value' => 'string',
            'discount' => 'string',
            'sub_total' => 'numeric',
            'shipping_charge' => 'numeric',
            'total' => 'numeric',
            'terms_condition' => 'nullable|string|min:0',
            'notes' => 'nullable|string|min:0',
            'attachment' => ['file', 'nullable'],
            'invoice_items' => 'nullable',
            'additional' => 'nullable',
        ];

        $data = $request->validate($rules);
        $data['invoice_items'] = json_decode($data['invoice_items'] ?? '{}');
        $data['additional'] = json_decode($data['additional'] ?? '{}');

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
}
