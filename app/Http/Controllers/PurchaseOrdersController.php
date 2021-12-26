<?php

namespace App\Http\Controllers;

use App\Models\AppMail;
use App\Models\Bill;
use App\Models\BillExtraField;
use App\Models\BillItem;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\Category;
use App\Models\Customer;
use App\Models\ExtraField;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderExtraField;
use App\Models\PurchaseOrderItem;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\Tax;
use App\Models\Vendor;
use App\Traits\SettingsTrait;
use Carbon\Carbon;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\LedgerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PurchaseOrdersController extends Controller
{
    use TransactionTrait, SettingsTrait;

    public $settings;

    public function __construct()
    {
//        dd($this->settings);
    }

    public function index(Request $request)
    {


//        dd('test');
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $vendor_id = $request->vendor;
        $q = $request->q;

        $purchase_orders = PurchaseOrder::with('vendor')
            ->when($vendor_id != null, function ($query) use ($vendor_id) {
                return $query->where('vendor_id', $vendor_id);
            })->when($q != null, function ($query) use ($q) {
                return $query->where('purchase_order_number', 'like', '%' . $q . '%');
            })
            ->when($start_date != null && $end_date != null, function ($query) use ($start_date, $end_date) {
                $start_date = Carbon::parse($start_date)->toDateString();
                $end_date = Carbon::parse($end_date)->toDateString();
                return $query->whereBetween('purchase_order_date', [$start_date, $end_date]);
            })
            ->latest();
//        dd($purchase_orders->get()->toArray());
        $totalAmount = $purchase_orders->get()->sum('total');
        $totalDue = $purchase_orders->get()->sum('due');
        $totalPaid = $purchase_orders->get()->sum('paid');
//        dd($totalAmount);
        $purchase_orders = $purchase_orders->paginate(10);
        $cashAcId = Ledger::CASH_AC();
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $vendors = Vendor::all();
        return view('purchase_orders.index', compact('purchase_orders', 'cashAcId', 'depositAccounts', 'paymentMethods',
            'start_date', 'end_date', 'vendor_id', 'vendors', 'q', 'totalAmount', 'totalDue', 'totalPaid'));
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
        $extraFields = optional(PurchaseOrder::query()->latest()->first())->extra_fields ?? [];
        $bill_fields = optional(PurchaseOrder::query()->latest()->first())->purchase_order_extra ?? [];
        $next_invoice = PurchaseOrder::nextInvoiceNumber();

        return view('purchase_orders.create', compact('vendors', 'products', 'taxes', 'next_invoice', 'categories', 'extraFields', 'bill_fields', 'cashAcId', 'depositAccounts', 'paymentMethods'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
//        dd($data);
        $random = Str::random(40);
        $data['secret'] = $random;
        $purchase_order_items = $data['purchase_order_items'] ?? [];
        $extraFields = $data['additional'] ?? [];
        $additionalFields = $data['additional_fields'] ?? [];
        unset($data['purchase_order_items']);
        unset($data['additional']);
        unset($data['additional_fields']);

        $purchase_order = PurchaseOrder::create($data);

        $this->insertDataToOtherTable($purchase_order, $purchase_order_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
        return redirect()->route('purchase_orders.purchase_order.show', $purchase_order->id)
            ->with('success_message', 'Purchase Order was successfully added.');

    }

    public function insertDataToOtherTable($purchase_order, $bill_items, $extraFields, $additionalFields)
    {
//        dd($bill_items);
        foreach ($bill_items as $bill_item) {
            $product_id = $bill_item->product_id;
            if (!is_numeric($product_id)) {
                $product = Product::create(['product_type' => 'Service', 'name' => $bill_item->product_id, 'purchase_price' => $bill_item->price, 'sell_unit' => $bill_item->unit ?? '',
                    'description' => $bill_item->description]);
                $product_id = $product->id;
            }

            PurchaseOrderItem::create(['purchase_order_id' => $purchase_order->id, 'product_id' => $product_id,
                'description' => $bill_item->description, 'qnt' => $bill_item->qnt, 'unit' => $bill_item->unit ?? '',
                'price' => $bill_item->price, 'amount' => $bill_item->price * $bill_item->qnt, 'tax_id' => $bill_item->tax_id == '' ? 0 : $bill_item->tax_id, 'date' => $purchase_order->bill_date]);
        }
        foreach ($extraFields as $additional) {
            PurchaseOrderExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'purchase_order_id' => $purchase_order->id]);
        }

        foreach ($additionalFields as $additional) {
            ExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'type' => PurchaseOrder::class, 'type_id' => $purchase_order->id]);
        }

        $accounting = new AccountingFacade();
        $accounting->on_purchase_order_payment_delete($purchase_order);

        if (!$purchase_order->is_payment) return;

        $accounting->on_purchase_order_payment_create($purchase_order);


    }

    public function show($id)
    {


        $purchase_order = PurchaseOrder::with('vendor')->findOrFail($id);

        $purchase_order->taxes;
        return view('purchase_orders.show', compact('purchase_order'));
    }

    public function convert_to_bill($id)
    {


        $purchase_order = PurchaseOrder::with('vendor')->findOrFail($id);
        $purchase_order->taxes;
        $purchase_order->converted = true;
        $purchase_order->save();
        $random = Str::random(40);
        $accounting = new AccountingFacade();
        $accounting->on_purchase_order_payment_delete($purchase_order);
        $bill = Bill::create(['vendor_id' => $purchase_order->vendor_id,
            'bill_number' => Bill::nextInvoiceNumber(),
            'order_number' => $purchase_order->purchase_order_number,
            'bill_date' => $purchase_order->purchase_order_date,
            'due_date' => $purchase_order->delivery_date,
            'discount_type' => $purchase_order->discount_type,
            'discount_value' => $purchase_order->discount_value,
            'discount' => $purchase_order->discount,
            'sub_total' => $purchase_order->sub_total,
            'shipping_charge' => $purchase_order->shipping_charge,
            'total' => $purchase_order->total,
            'notes' => $purchase_order->notes,
            'attachment' => $purchase_order->attachment,
            'currency' => $purchase_order->currency,
            'is_payment' => $purchase_order->is_payment,
            'bill_payment_id' => null,
            'payment_method_id' => null,
            'deposit_to' => $purchase_order->deposit_to,
            'payment_amount' => $purchase_order->payment_amount,
            'secret' => $random]);

        $billsController = new BillsController();
        $bill_items = $purchase_order->purchase_order_items;
        $extraFields = $purchase_order->purchase_order_extra;
        $additonalFields = $purchase_order->extra_fields;

        $billsController->insertDataToOtherTable($bill, $bill_items, $extraFields, $additonalFields);

        return redirect()->route('bills.bill.edit', $bill->id);
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
        $purchase_order = PurchaseOrder::findOrFail($id);
//        $this->authorize('update', $purchase_order);
        $vendors = Vendor::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $bill_items = PurchaseOrderItem::query()->where('purchase_order_id', $purchase_order->id)->get()->map(function ($item) {
            $item->stock = optional(Product::find($item->product_id))->stock ?? 0;
            return $item;
        });
//        dd($bill_items,PurchaseOrderItem::all());
        $categories = Category::query()->latest()->get();
        $billExtraField = PurchaseOrderExtraField::query()->where('purchase_order_id', $purchase_order->id)->get();
        $extraFields = ExtraField::query()->where('type', PurchaseOrder::class)->where('type_id', $purchase_order->id)->get();
        $products = Product::query()->latest()->get();

        return view('purchase_orders.edit', compact('purchase_order', 'vendors', 'taxes', 'bill_items', 'billExtraField', 'products', 'extraFields', 'categories', 'cashAcId', 'depositAccounts', 'paymentMethods'));
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

        $purchase_order = PurchaseOrder::findOrFail($id);
//        $this->authorize('update', $purchase_order);

        BillExtraField::query()->where('bill_id', $purchase_order->id)->delete();
        BillItem::query()->where('bill_id', $purchase_order->id)->delete();
        ExtraField::query()->where('type', get_class($purchase_order))->where('type_id', $purchase_order->id)->delete();
        BillPayment::query()->where('id', $purchase_order->bill_payment_id)->delete();
        BillPaymentItem::query()->where('bill_payment_id', $purchase_order->bill_payment_id)->get()->each(function ($model) {
            $model->delete();
        });
        $purchase_order->update($data);


        $this->insertDataToOtherTable($purchase_order, $bill_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);


        return redirect()->route('bills.bill.show', $purchase_order->id)->with('success_message', 'Bill was successfully updated.');

    }


    public function destroy($id)
    {

        $purchase_order = PurchaseOrder::findOrFail($id);
//        $this->authorize('delete', $purchase_order);
        PurchaseOrderExtraField::query()->where('purchase_order_id', $purchase_order->id)->delete();
        PurchaseOrderItem::query()->where('purchase_order_id', $purchase_order->id)->delete();
        ExtraField::query()->where('type', get_class($purchase_order))->where('type_id', $purchase_order->id)->delete();
        $accounting = new AccountingFacade();
        $accounting->on_purchase_order_payment_delete($purchase_order);

        $purchase_order->delete();

        return redirect()->route('purchase_orders.purchase_order.index')->with('success_message', 'Purchase Order was successfully deleted.');

    }


    protected function getData(Request $request)
    {

        $rules = [
            'vendor_id' => 'nullable',
            'purchase_order_number' => 'required',
            'ref' => 'nullable|string|min:0',
            'purchase_order_date' => 'required',
            'delivery_date' => 'nullable',
            'discount_type' => 'nullable',
            'discount_value' => 'nullable',
            'discount' => 'nullable',
            'sub_total' => 'numeric',
            'shipping_charge' => 'numeric',
            'total' => 'numeric',
            'notes' => 'nullable|string|min:0',
            'attachment' => ['file', 'nullable'],
            'purchase_order_items' => 'nullable',
            'additional' => 'nullable',
            'additional_fields' => 'nullable',
            'currency' => 'nullable',
            'shipping_date' => 'nullable',
            'is_payment' => 'nullable',
            'bill_payment_id' => 'nullable',
            'payment_method_id' => 'nullable',
            'deposit_to' => 'nullable',
            'payment_amount' => 'nullable',
        ];

        $data = $request->validate($rules);

        $data['purchase_order_items'] = json_decode($data['purchase_order_items'] ?? '{}');
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
        $purchase_order = Bill::with('customer')->findOrFail($id);
        $title = "Send Bill - " . $purchase_order->bill_number;
        $this->settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

//        dd($purchase_order, $this->settings, auth()->user(), MetaSetting::query()->pluck('value', 'key')->toJson());
        $from = $this->settings->email ?? '';
        $to = null;
        if (optional($purchase_order->customer)->email) {
            $to = optional($purchase_order->customer)->email;
        }
        $customerName = optional($purchase_order->customer)->name ?? 'Customer';
        $subject = "Bill #" . ($purchase_order->bill_number ?? '') . ' from ' . ($this->settings->business_name ?? 'n/a');
        $businessName = $this->settings->business_name ?? 'Company Name';
        $businessEmail = $this->settings->email ?? '';
        $businessPhone = $this->settings->phone ?? '';
        $businessWebsite = $this->settings->website ?? '';
        $message = "Hi $customerName ,<br><br> I hope you’re well! Please see attached bill number [$purchase_order->bill_number] , due on [$purchase_order->due_date]. Don’t hesitate to reach out if you have any questions. <br> Bill#: $purchase_order->bill_number  <br>Date: $purchase_order->bill_date <br>Amount: $purchase_order->total <br> <br> Kind regards,  <br> $businessName <br> $businessEmail <br> $businessPhone <br> $businessWebsite";

//        dd($message);
        return view('bills.send', compact('bill', 'title', 'from', 'to', 'subject', 'message'));
    }

    public function sendBillMail(Request $request, Bill $purchase_order)
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

        $purchase_order->bill_status = "sent";
        $purchase_order->save();


        Mail::to($to)->queue(new BillSendMail($purchase_order, (object)$data, settings()));


        return redirect()->route('bills.bill.index')->with('success_message', 'Bill was sent successfully.');
    }

    public function share($secret)
    {
        $purchase_order = Bill::query()->with('vendor')->where('secret', $secret)->firstOrFail();
        $settings = json_decode(MetaSetting::query()->where('client_id', $purchase_order->client_id)->pluck('value', 'key')->toJson());
//        dd($purchase_order->client_id, $settings);
        return view('bills.share', compact('bill', 'settings'));
    }

}
