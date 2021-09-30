<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
        $q = $request->q;
        $customers = Customer::query()
            ->when($q != null, function ($builder) use ($q) {
                return $builder->where('name', 'like', '%' . $q . '%')->orWhere('phone', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%');
            })
            ->latest()
            ->paginate(10);
        return view('customers.index', compact('customers', 'q'));
    }


    public function create()
    {
        return view('customers.create');
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);
//        dd($data);
        $customer = Customer::create($data);
        $ledger = Ledger::create([
            'ledger_name' => $customer->name,
            'ledger_group_id' => LedgerGroup::ASSETS(),
            'opening' => $customer->opening,
            'opening_type' => $customer->opening_type,
            'active' => true,
            'is_default' => true,
            'type' => Customer::class,
            'type_id' => $customer->id,
        ]);
        if ($request->opening > 0) {
            $this->storeOpeningBalance($ledger, $request->opening, $request->opening_type);
        }

        if ($request->ajax()) {
            return $customer;
        }

        return redirect()->route('customers.customer.index')->with('success_message', 'Customer was successfully added.');

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


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $customer = Customer::findOrFail($id);
        $customer->update($data);

        $ledger = Ledger::query()
            ->where('type', Customer::class)
            ->where('type_id', $customer->id)
            ->first();
        if ($ledger == null) {
            $ledger = Ledger::create([
                'ledger_name' => $customer->name,
                'ledger_group_id' => LedgerGroup::ASSETS(),
                'opening' => $customer->opening,
                'opening_type' => $customer->opening_type,
                'active' => true,
                'is_default' => true,
                'type' => Customer::class,
                'type_id' => $customer->id,
            ]);
        } else {
            $ledger->update([
                'ledger_name' => $customer->name,
                'opening' => $customer->opening,
                'opening_type' => $customer->opening_type
            ]);
        }

        if ($request->opening > 0) {
            $this->storeOpeningBalance($ledger, $request->opening, $request->opening_type);
        } else {
            $txn = Transaction::where('txn_type', 'OpeningBalance')->where('type', Ledger::class)->where('type_id', $ledger->id)->first();
            if ($txn) {
                TransactionDetail::query()->where('transaction_id', $txn->id)->delete();
            }
        }

        return redirect()->route('customers.customer.index')
            ->with('success_message', 'Customer was successfully updated.');

    }


    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.customer.index')
            ->with('success_message', 'Customer was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|nullable|string|min:1|max:255',
            'photo' => ['file', 'nullable'],
            'company_name' => 'string|min:1|nullable',
            'phone' => 'string|min:1|nullable',
            'email' => 'nullable',
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
        ];

        $data = $request->validate($rules);
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
