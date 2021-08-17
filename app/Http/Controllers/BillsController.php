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

class BillsController extends Controller
{
    use TransactionTrait, SettingsTrait;

    public $settings;

    public function __construct()
    {
//        dd($this->settings);
    }

    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $vendor_id = $request->vendor;
        $q = $request->q;
        $bills = Bill::with('vendor')
            ->when($vendor_id != null, function ($query) use ($vendor_id) {
                return $query->where('vendor_id', $vendor_id);
            })->when($q != null, function ($query) use ($q) {
                return $query->where('bill_number', 'like', '%' . $q . '%');
            })
            ->when($start_date != null && $end_date != null, function ($query) use ($start_date, $end_date) {
                $start_date = Carbon::parse($start_date)->toDateString();
                $end_date = Carbon::parse($end_date)->toDateString();
                return $query->whereBetween('bill_date', [$start_date, $end_date]);
            })
            ->latest()->paginate(10);
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $vendors = Vendor::all();
        return view('bills.index', compact('bills', 'cashAcId', 'depositAccounts', 'paymentMethods',
            'start_date', 'end_date', 'vendor_id', 'vendors', 'q'));
    }


    public function create()
    {
        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
        $depositAccounts = Ledger::find($this->getAssetLedgers())->sortBy('ledger_name');
        $paymentMethods = PaymentMethod::query()->get();
        $customers = Vendor::pluck('name', 'id')->all();
        $products = Product::query()->latest()->get();
        $categories = Category::query()->latest()->get();
        $taxes = Tax::query()->latest()->get()->toArray();
        $extraFields = optional(Bill::query()->latest()->first())->extra_fields ?? [];
        $bill_fields = optional(Bill::query()->latest()->first())->bill_extra ?? [];
        $next_invoice = Bill::nextInvoiceNumber();

        return view('bills.create', compact('customers', 'products', 'taxes', 'next_invoice', 'categories', 'extraFields', 'bill_fields', 'cashAcId', 'depositAccounts', 'paymentMethods'));
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

        $bill = Bill::create($data);

        $this->insertDataToOtherTable($bill, $bill_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);
        return redirect()->route('bills.bill.show', $bill->id)
            ->with('success_message', 'Bill was successfully added.');

    }

    public function insertDataToOtherTable($bill, $bill_items, $extraFields, $additionalFields)
    {
//        dd($bill_items);
        foreach ($bill_items as $bill_item) {
            $product_id = $bill_item->product_id;
            if (!is_numeric($product_id)) {
                $product = Product::create(['product_type' => 'Service', 'name' => $bill_item->product_id, 'sell_price' => $bill_item->price, 'sell_unit' => $bill_item->unit ?? '',
                    'description' => $bill_item->description]);
                $product_id = $product->id;
            }

            BillItem::create(['bill_id' => $bill->id, 'product_id' => $product_id,
                'description' => $bill_item->description, 'qnt' => $bill_item->qnt, 'unit' => $bill_item->unit ?? '',
                'price' => $bill_item->price, 'amount' => $bill_item->price * $bill_item->qnt, 'tax_id' => $bill_item->tax_id == '' ? 0 : $bill_item->tax_id, 'date' => $bill->bill_date]);
        }
        foreach ($extraFields as $additional) {
            BillExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'bill_id' => $bill->id]);
        }

        foreach ($additionalFields as $additional) {
            ExtraField::create(['name' => $additional->name, 'value' => $additional->value, 'type' => Bill::class, 'type_id' => $bill->id]);
        }


        if (!$bill->is_payment) return;
        $paymentSerial = 'BPM' . str_pad(BillPayment::query()->count(), 3, '0', STR_PAD_LEFT);

        $billPayment = BillPayment::create([
            'payment_date' => $bill->payment_date,
            'bill_id' => $bill->id,
            'vendor_id' => $bill->vendor_id,
            'payment_method_id' => $bill->payment_method_id,
            'ledger_id' => $bill->ledger_id,
            'payment_sl' => $paymentSerial,
            'note' => $bill->notes
        ]);

        BillPaymentItem::create(['bill_payment_id' => $billPayment->id, 'bill_id' => $bill->id, 'amount' => $bill->payment_amount]);
        $bill->bill_payment_id = $billPayment->id;
        $bill->save();

    }

    public function show($id)
    {
        $bill = Bill::with('vendor')->findOrFail($id);

        $bill->taxes;
        return view('bills.show', compact('bill'));
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
        $bill = Bill::findOrFail($id);
        $customers = Customer::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        $bill_items = BillItem::query()->where('bill_id', $bill->id)->get();
        $categories = Category::query()->latest()->get();
        $billExtraField = BillExtraField::query()->where('bill_id', $bill->id)->get();
        $extraFields = ExtraField::query()->where('type', Bill::class)->where('type_id', $bill->id)->get();
        $products = Product::query()->latest()->get();

        return view('bills.edit', compact('bill', 'customers', 'taxes', 'bill_items', 'billExtraField', 'products', 'extraFields', 'categories', 'cashAcId', 'depositAccounts', 'paymentMethods'));
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

        $bill = Bill::findOrFail($id);
        $bill->update($data);
        BillExtraField::query()->where('bill_id', $bill->id)->delete();
        BillItem::query()->where('bill_id', $bill->id)->delete();
        ExtraField::query()->where('type', get_class($bill))->where('type_id', $bill->id)->delete();
        BillPayment::query()->where('id', $bill->bill_payment_id)->delete();
        BillPaymentItem::query()->where('bill_payment_id', $bill->bill_payment_id)->delete();

        $this->insertDataToOtherTable($bill, $bill_items, $extraFields, $additionalFields);
        $this->saveTermsNDNote($data);


        return redirect()->route('bills.bill.show', $bill->id)->with('success_message', 'Bill was successfully updated.');

    }


    public function destroy($id)
    {

        $bill = Bill::findOrFail($id);
        BillExtraField::query()->where('bill_id', $bill->id)->delete();
        BillItem::query()->where('bill_id', $bill->id)->delete();
        ExtraField::query()->where('type', get_class($bill))->where('type_id', $bill->id)->delete();

        BillPayment::query()->where('id', $bill->bill_payment_id)->delete();
        BillPaymentItem::query()->where('bill_payment_id', $bill->bill_payment_id)->get()->each(function ($model) {
            $model->delete();
        });
        $bill->delete();

        return redirect()->route('bills.bill.index')->with('success_message', 'Bill was successfully deleted.');

    }


    protected function getData(Request $request)
    {

        $rules = [
            'vendor_id' => 'nullable',
            'bill_number' => 'required',
            'order_number' => 'nullable|string|min:0',
            'bill_date' => 'required',
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
            'deposit_to' => 'nullable',
            'payment_amount' => 'nullable',
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
