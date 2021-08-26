<?php

namespace Enam\Acc\Http\Controllers;

use Enam\Acc\Http\Controllers\Controller;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\View;

class LedgersController extends Controller
{
    use TransactionTrait;

    public function index()
    {
        View::share('title', 'Accounts');
        $ledgers = Ledger::with('ledgergroup')->latest()->get();

        return view('acc::ledgers.index', compact('ledgers'));
    }

    public function trash()
    {
        View::share('title', 'Trashed Ledgers');
        $ledgers = Ledger::onlyTrashed()->with('ledgergroup')->latest()->get();

        return view('acc::ledgers.trash', compact('ledgers'));
    }


    public function create()
    {
        $ledgerGroups = LedgerGroup::pluck('id', 'id')->all();
        View::share('title', 'Create New Ledger');

        return view('acc::ledgers.create', compact('ledgerGroups'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $ledger = Ledger::create($data);
        if ($request->opening > 0) {
            $this->storeOpeningBalance($ledger, $request->opening, $request->opening_type);
        }
        if ($request->ajax()) {
            return $ledger;
        }

        return redirect()->route('ledgers.ledger.index')
            ->with('success_message', 'Ledger was successfully added.');

    }

    protected function storeOpeningBalance(Ledger $ledger, $amount, $entry_type)
    {
        $txn = Transaction::where('txn_type', 'OpeningBalance')->where('type', Ledger::class)->where('type_id', $ledger->id)->first();
        if ($txn) {
            Transaction::where('txn_type', 'Opening')
                ->where('type', Ledger::class)
                ->where('type_id', $ledger->id)
                ->update(['amount' => $amount]);

            TransactionDetail::where('transaction_id', $txn->id)
                ->update(['entry_type' => $entry_type, 'amount' => $amount]);
        } else {
            $voucher_no = $this->getVoucherID();
            $txn = Transaction::create(['ledger_name' => $ledger->ledger_name, 'voucher_no' => $voucher_no,
                'amount' => $amount, 'note' => 'Ledger Opening', 'txn_type' => 'OpeningBalance', 'type' => Ledger::class,
                'type_id' => $ledger->id, 'date' => today()->toDateString()]);

            TransactionDetail::create(['transaction_id' => $txn->id, 'ledger_id' => $ledger->id, 'entry_type' => $entry_type, 'amount' => $amount,
                'voucher_no' => $voucher_no, 'date' => today()->toDateString(), 'note' => 'OpeningBalance']);

        }

    }


    public function show($id)
    {
        View::share('title', 'Show Ledger');
        $ledger = Ledger::with('ledgergroup')->findOrFail($id);

        return view('acc::ledgers.show', compact('ledger'));
    }


    public function edit($id)
    {
        View::share('title', 'Edit Ledger');
        $ledger = Ledger::findOrFail($id);
        $ledgerGroups = LedgerGroup::pluck('id', 'id')->all();

        return view('acc::ledgers.edit', compact('ledger', 'ledgerGroups'));
    }

    public function update($id, Request $request)
    {


        $data = $this->getData($request);
        $ledger = Ledger::findOrFail($id);
        $ledger->update($data);
        if ($request->opening > 0) {
            $this->storeOpeningBalance($ledger, $request->opening, $request->opening_type);
        }

        return redirect()->route('ledgers.ledger.index')
            ->with('success_message', 'Ledger was successfully updated.');

    }


    public function destroy($id)
    {

        $ledger = Ledger::findOrFail($id);
        $ledger->delete();
        Transaction::where('type', Ledger::class)->where('type_id', $id)->delete();
        TransactionDetail::where('ledger_id', $id)->delete();

        return redirect()->route('ledgers.ledger.index')
            ->with('success_message', 'Ledger was successfully deleted.');

    }

    public function restore($id)
    {
        $ledger = Ledger::withTrashed()->findOrFail($id);
        $ledger->restore();

        return redirect()->route('ledgers.ledger.trash')
            ->with('success_message', 'Ledger was successfully restored.');

    }


    public function getData(Request $request, $id = false)
    {
        $rules = [
            'ledger_name' => 'required',
            'ledger_group_id' => 'required',
            'opening' => 'nullable|numeric',
            'opening_type' => 'nullable',
            'active' => 'string|min:1|nullable',
        ];
        if ($request->opening > 0) {
            $rules['opening_type'] = 'required';
        }


        $data = $request->validate($rules);


        return $data;
    }

}
