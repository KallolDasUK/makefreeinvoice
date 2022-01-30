<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MetaSetting;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Exception;

class CustomersController extends Controller
{
    use TransactionTrait;


    public function index(Request $request)
    {
        view()->share('title', 'Customers');
        $q = $request->q;
        $customers = Customer::query()
            ->when($q != null, function ($builder) use ($q) {
                return $builder->where('name', 'like', '%' . $q . '%')
                    ->orWhere('phone', 'like', '%' . $q . '%')
                    ->orWhere('customer_ID', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%');
            })->latest()->paginate(10);

        $totalCustomers = 0;
        $totalAdvance = 0;
        $totalReceivables = 0;
//        $ctrs = Customer::query()->get();
//        foreach ($ctrs as $customer) {
////            dd($customer);
//            $totalAdvance += $customer->advance;
//            $totalReceivables += $customer->receivables;
//        }

        return view('customers.index', compact('customers', 'q', 'totalAdvance', 'totalCustomers', 'totalReceivables'));
    }


    public function create()
    {
        view()->share('title', 'Create Customer');

        return view('customers.create');
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
//        dd($data);
        $customer = Customer::create($data);
        $this->createOrUpdateLedger($customer);


        if ($request->ajax()) {
            return $customer;
        }

        return redirect()->route('customers.customer.index')->with('success_message', 'Customer was successfully added.');

    }


    public function createOrUpdateLedger($customer)
    {
        $is_ledger_exits = Ledger::query()->where(['type' => Customer::class, 'type_id' => $customer->id])->exists();
        if ($is_ledger_exits) {
            Ledger::query()->where(['type' => Customer::class, 'type_id' => $customer->id])
                ->update(['ledger_name' => $customer->name, 'opening' => $customer->opening,
                    'opening_type' => $customer->opening_type,
                    'ledger_group_id' => Ledger::ACCOUNTS_RECEIVABLE_GROUP()]);
            $ledger = Ledger::query()->firstWhere(['type' => Customer::class, 'type_id' => $customer->id]);
        } else {
            $ledger = Ledger::create([
                'ledger_name' => $customer->name,
                'opening' => $customer->opening,
                'opening_type' => $customer->opening_type,
                'ledger_group_id' => Ledger::ACCOUNTS_RECEIVABLE_GROUP(),
                'active' => true,
                'is_default' => true,
                'type' => Customer::class,
                'type_id' => $customer->id]);
        }
        if ($ledger->opening > 0) {
            $this->storeOpeningBalance($ledger, $ledger->opening, $ledger->opening_type);
        } else {
            $txn = Transaction::where('txn_type', 'OpeningBalance')->where('type', Ledger::class)->where('type_id', $ledger->id)->first();
            if ($txn) {
                TransactionDetail::query()->where('transaction_id', $txn->id)->delete();
            }
        }
        return $ledger;

    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);


        return view('customers.edit', compact('customer'));
    }

    public function advanceInfo($id)
    {
        $customer = Customer::findOrFail($id);
        $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());

        return ['name' => $customer->name, 'advance' => $customer->advance, 'customer' => $customer,
            'customer_id_feature' => $settings->customer_id_feature];
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request, $id);

        $customer = Customer::findOrFail($id);
        $customer->update($data);
        $this->createOrUpdateLedger($customer);


        return redirect()->route('customers.customer.index')
            ->with('success_message', 'Customer was successfully updated.');

    }


    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        $ledger = Ledger::query()->where('type', Customer::class)
            ->where('type_id', $customer->id)
            ->first();
        if ($ledger) {
            $ledger->delete();
            Transaction::where('type', Ledger::class)->where('type_id', $ledger->id)->delete();
            TransactionDetail::where('ledger_id', $ledger->id)->delete();
        }

        return redirect()->route('customers.customer.index')
            ->with('success_message', 'Customer was successfully deleted.');

    }


    protected function getData(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|nullable|string|min:1|max:255',
            'customer_ID' => 'nullable|unique_saas:customers,customer_ID',
//            'code' => 'nullable|string|unique_saas:products,code',

            'photo' => ['file', 'nullable'],
            'company_name' => 'string|min:1|nullable',
            'phone' => 'string|min:1|nullable',
            'email' => 'nullable',
            'reference_by' => 'nullable',
            'customer_type' => 'nullable',
            'credit_limit' => 'nullable',
            'country' => 'nullable',
            'address' => 'nullable',
            'street_1' => 'nullable',
            'street_2' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zip_post' => 'nullable',
            'website' => 'string|min:1|nullable',
            'opening' => 'nullable|numeric',
            'opening_type' => 'nullable',
            'sr_id' => 'nullable',
        ];

        if ($id) {
            $rules['customer_ID'] = 'nullable|string|unique_saas:customers,customer_ID,' . $id;

        }
        $data = $request->validate($rules, ['customer_ID.unique_saas' => 'Customer ID Already In Use']);
        if ($request->has('custom_delete_photo')) {
            $data['photo'] = null;
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->moveFile($request->file('photo'));
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
