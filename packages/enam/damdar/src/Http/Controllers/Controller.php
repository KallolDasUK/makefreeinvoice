<?php

namespace Enam\Acc\Http\Controllers;

use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getTxns()
    {
        if (session()->has('txns')) {
            $txns = session('txns');
        } else {
            $txns = [
                [
                    "entry_type" => "Dr",
                    "note" => "",
                ],
                [
                    "entry_type" => "Cr",
                    "note" => ""
                ],
            ];

        }
        return $txns;
    }

    public function saveTransaction(Request $request)
    {
        $txns = json_decode($request->txns, true);
        session()->flash('txns', $txns);
        $data = $this->getData($request);
        $vno = $request->input('vno');
        $data['amount'] = collect($txns)->where('entry_type', EntryType::$DR)->sum('amount');
        $data['ledger_name'] = Ledger::find(collect($txns)->first()['ledger_id'])->ledger_name;
        $txn = Transaction::create($data);

        foreach ($txns as $txnData) {
            $txnData['transaction_id'] = $txn->id;
            $txnData['voucher_no'] = $txn->voucher_no;
            $txnData['cheque_date'] = $txnData['cheque_date'] ?? null;
            if (isset($txnData['cheque_date'])) {
                if ($txnData['cheque_date'] == '') {
                    $txnData['cheque_date'] = null;
                }
            }
            TransactionDetail::create($txnData);
        }

    }

    protected function getData(Request $request, $id = null)
    {

        $rules = [
            'voucher_no' => 'required',
            'branch_id' => 'nullable',
            'date' => 'required',
            'txn_type' => 'nullable',
            'note' => 'nullable'
        ];

        if ($id) {
            $rules = [
                'branch_id' => 'nullable',
//                'voucher_no' => 'required|unique:transactions,voucher_no,' . $id,
                'voucher_no' => 'required',
                'date' => 'required',
                'txn_type' => 'nullable',
                'note' => 'nullable'
            ];
        }


        $data = $request->validate($rules);


        return $data;
    }

    public function restoreTransaction($id)
    {
        $transaction = Transaction::withTrashed()->findOrFail($id);
        TransactionDetail::withTrashed()->where('transaction_id', $id)->get()->map(function ($td) {
            $td->restore();
        });
        $transaction->restore();
    }

    public function updateTransaction($id, Request $request)
    {
//        dd($request->all());
        $txns = json_decode($request->txns, true);
        $data = $this->getData($request, $id);
        $vno = $request->input('vno');
        $data['amount'] = collect($txns)->where('entry_type', EntryType::$DR)->sum('amount');

        $data['ledger_name'] = Ledger::find(collect($txns)->first()['ledger_id'])->ledger_name;
        Transaction::query()->where('id', $id)->update($data);
        $txn = Transaction::find($id);
        TransactionDetail::query()->where('transaction_id', $id)->delete();

        foreach ($txns as $txnData) {
            $txnData['transaction_id'] = $txn->id;
            $txnData['voucher_no'] = $txn->voucher_no;
            $txnData['cheque_date'] = $txnData['cheque_date'] ?? null;
            if (isset($txnData['cheque_date'])) {
                if ($txnData['cheque_date'] == '') {
                    $txnData['cheque_date'] = null;
                }
            }
            unset($txnData['id']);
            TransactionDetail::create($txnData);
        }
    }
    public function getNode($group_id)
    {
        $g = LedgerGroup::find($group_id);

        $groups = LedgerGroup::query()->where('parent', $group_id)->get();
        $ledger = Ledger::query()->where('ledger_group_id', $g->id)->get()->map(function ($ledger) {
            return ['text' => $ledger->ledger_name, 'href' => route('ledgers.ledger.edit', $ledger->id)];
        })->toArray();
        $nodes = $ledger;

        foreach ($groups as $group) {
            $ledger = Ledger::query()->where('ledger_group_id', $group->id)->get()->map(function ($ledger) {
                return ['text' => $ledger->ledger_name, 'href' => route('ledgers.ledger.edit', $ledger->id)];
            })->toArray();
            $nodes[] = ['text' => $group->group_name, 'nodes' => $ledger + $this->getNode($group->id)];
        }
        return $nodes;
    }
}
