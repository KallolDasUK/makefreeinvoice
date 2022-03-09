<?php

namespace Enam\Acc\Http\Controllers;

use Enam\Acc\Http\Livewire\helpers\VoucherHelper;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\VoucherType;
use NumberFormatter;
use \PDF;
use Enam\Acc\Http\Controllers\Controller;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\View;

class   TransactionsController extends Controller
{
    use TransactionTrait;


    public function index()
    {
        View::share('title', 'Receive Voucher');
        $transactions = Transaction::with('branch')->where('txn_type', VoucherType::$RECEIVE)->orderBy('date')->get();
        return view('acc::transactions.index', compact('transactions'));
    }

    public function trash()
    {
        View::share('title', 'Trashed Received Voucher');
        $transactions = Transaction::onlyTrashed()->with('branch')->where('txn_type', VoucherType::$RECEIVE)->latest('voucher_no')->get();
        return view('acc::transactions.trash', compact('transactions'));
    }


    public function create()
    {
        $branches = Branch::pluck('name', 'id')->all();
        $ledgers = Ledger::query()->select('ledger_name','id')->get()->toArray();
        $bank_ledger = $this->getBankLedgers();
        $txns = $this->getTxns();
        $voucher_no = $this->getVoucherID(VoucherType::$RECEIVE);
        View::share('title', 'Create New Receive');

        return view('acc::transactions.create', compact('branches', 'ledgers', 'voucher_no', 'bank_ledger', 'txns'));
    }


    public function store(Request $request)
    {
        $this->saveTransaction($request);

        return redirect()->route('transactions.transaction.index')
            ->with('success_message', 'Transaction was successfully added.');

    }


    public function show($id)
    {
        View::share('title', 'Show Receive');
        $transaction = Transaction::with('branch')->findOrFail($id);

        return view('acc::transactions.show', compact('transaction'));
    }


    public function edit($id)
    {
        $ledgers = Ledger::query()->select('ledger_name','id')->get()->toArray();
        $bank_ledger = $this->getBankLedgers();
        View::share('title', 'Edit Receive');
        $transaction = Transaction::findOrFail($id);
        $branches = Branch::pluck('name', 'id')->all();
        $txns = $transaction->transaction_details;

        return view('acc::transactions.edit', compact('transaction', 'branches', 'ledgers', 'txns', 'bank_ledger'));
    }


    public function update($id, Request $request)
    {
        $this->updateTransaction($id, $request);

        return redirect()->route('transactions.transaction.index')
            ->with('success_message', 'Transaction was successfully Updated.');

    }


    public function destroy($id)
    {

        $transaction = Transaction::findOrFail($id);
        TransactionDetail::query()->where('transaction_id', $id)->delete();
        $transaction->delete();

        return redirect()->route('transactions.transaction.index')
            ->with('success_message', 'Transaction was successfully deleted.');

    }

    public function restore($id)
    {
        $this->restoreTransaction($id);
        return redirect()->route('transactions.transaction.trash')
            ->with('success_message', 'Transaction was successfully restored.');

    }

    public function getPDF($id)
    {

        $transaction = Transaction::findOrFail($id);
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $in_word = $f->format($transaction->amount);
        $pdf = PDF::loadView('acc::pdf.transaction-print', ['transaction' => $transaction, 'in_word' => $in_word]);

        return $pdf->stream('acc::pdf.transaction-print');
    }


}
