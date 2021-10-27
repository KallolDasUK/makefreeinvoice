<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Exception;

class VendorsController extends Controller
{
    use TransactionTrait;

    public function index(Request $request)
    {
        $q = $request->q;
        view()->share('title', 'Vendors/Suppliers');
        $vendors = Vendor::query()->when($q != null, function ($builder) use ($q) {
            return $builder->where('name', 'like', '%' . $q . '%')->orWhere('phone', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%');
        })->latest();
        $totalVendors = count($vendors->get());
        $totalAdvance = $vendors->get()->sum('advance');
        $totalPayables = $vendors->get()->sum('payables');
        $vendors = $vendors->paginate(25);
        return view('vendors.index', compact('vendors', 'q', 'totalVendors', 'totalAdvance', 'totalPayables'));
    }


    public function create()
    {


        return view('vendors.create');
    }

    public function createOrUpdateLedger($vendor)
    {
        $is_ledger_exits = Ledger::query()->where(['type' => Vendor::class, 'type_id' => $vendor->id])->exists();
        if ($is_ledger_exits) {
            Ledger::query()->where(['type' => Vendor::class, 'type_id' => $vendor->id])
                ->update(['ledger_name' => $vendor->name, 'opening' => $vendor->opening,
                    'opening_type' => $vendor->opening_type,
                    'ledger_group_id' => Ledger::ACCOUNTS_PAYABLE_GROUP()]);
            $ledger = Ledger::query()->firstWhere(['type' => Vendor::class, 'type_id' => $vendor->id]);
        } else {
            $ledger = Ledger::create([
                'ledger_name' => $vendor->name,
                'opening' => $vendor->opening,
                'opening_type' => $vendor->opening_type,
                'ledger_group_id' => Ledger::ACCOUNTS_PAYABLE_GROUP(),
                'active' => true,
                'is_default' => true,
                'type' => Vendor::class,
                'type_id' => $vendor->id]);
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

    public function store(Request $request)
    {


        $data = $this->getData($request);

        $vendor = Vendor::create($data);

        $this->createOrUpdateLedger($vendor);
        if ($request->ajax()) {
            return $vendor;
        }

        return redirect()->route('vendors.vendor.index')
            ->with('success_message', 'Vendor was successfully added.');

    }


    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);

        return view('vendors.show', compact('vendor'));
    }


    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);


        return view('vendors.edit', compact('vendor'));
    }
    public function advanceInfo($id)
    {
        $vendor = Vendor::findOrFail($id);
        return ['name' => $vendor->name, 'advance' => $vendor->advance];
    }

    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($data);
        $this->createOrUpdateLedger($vendor);

        return redirect()->route('vendors.vendor.index')
            ->with('success_message', 'Vendor was successfully updated.');

    }


    public function destroy($id)
    {

        $vendor = Vendor::findOrFail($id);
        $ledger = Ledger::query()->where('type', Vendor::class)
            ->where('type_id', $vendor->id)
            ->first();
        if ($ledger) {
            $ledger->delete();
            Transaction::where('type', Ledger::class)->where('type_id', $ledger->id)->delete();
            TransactionDetail::where('ledger_id', $ledger->id)->delete();
        }
        $vendor->delete();

        return redirect()->route('vendors.vendor.index')
            ->with('success_message', 'Vendor was successfully deleted.');

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
            'street_1' => 'string|min:1|nullable',
            'street_2' => 'string|min:1|nullable',
            'city' => 'string|min:1|nullable',
            'state' => 'string|min:1|nullable',
            'zip_post' => 'string|min:1|nullable',
            'address' => 'string|min:1|nullable',
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
