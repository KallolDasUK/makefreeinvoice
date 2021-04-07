<?php

namespace Enam\Acc\Http\Controllers;

use Enam\Acc\Http\Livewire\helpers\VoucherHelper;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\LedgerHelper;
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

class AccountingReportsController extends Controller
{
    use TransactionTrait;

    public function rpbFilter(Request $request)
    {
        $month = $request->month;
        $branches = Branch::pluck('name', 'id')->all();
        View::share('title', 'Receipt & Payment (Branch Wise)');
        return \view('acc::reports.receipt-payment-branch.filter', compact('month', 'branches'));
    }

    public function rpbPDF(Request $request)
    {
        list($records, $ledgers) = $this->getRPBReport($request);
//        dd($records,$ledgers);
        $month = $request->month;
        $branch_id = $request->branch_id;
        $totalRevenue = collect($records)->sum('revenue');
        $totalNetRevenue = collect($records)->sum('net_revenue');
//        dd($records);
        if ($branch_id) {
            $branch = Branch::findOrFail($branch_id);
            $record = collect($records)->firstWhere('branch', $branch->name);
            if (!$record) {
                return back()->with('message', 'No Matching Report Found With ' . $month . ' & ' . $branch->name)->with('month', $month);
            }

            return $this->rpbPDFByBranch($request, $record);
        }

        $pdf = PDF::loadView('acc::reports.receipt-payment-branch.pdf', [
            'records' => $records, 'month' => $month,
            'ledgers' => $ledgers,
            'totalRevenue' => $totalRevenue,
            'totalNetRevenue' => $totalNetRevenue]);

        return $pdf->stream('acc::reports.receipt-payment-branch.pdf');

    }

    public function rpbPDFByBranch(Request $request, $record)
    {

        $totalRevenue = 0;
        $totalNetRevenue = 0;

//        dd($record);
        $pdf = PDF::loadView('acc::reports.receipt-payment-branch.single-branch-pdf', [
            'record' => $record, 'month' => $request->month,
            'totalRevenue' => $totalRevenue,
            'totalNetRevenue' => $totalNetRevenue]);

        return $pdf->stream('acc::reports.receipt-payment-branch.single-branch-pdf');

    }


    public function trialBalanceFilter(Request $request)
    {
        $start_date = today()->startOfMonth()->toDateString();
        $end_date = today()->toDateString();
        $branches = Branch::pluck('name', 'id')->all();
        View::share('title', 'Trial Balance');
        return \view('acc::reports.trialbalance.filter', compact('branches', 'start_date', 'end_date'));
    }

    public function trialBalancePDF(Request $request)
    {
        list($records, $profit) = $this->getTrialBalanceReport($request);
//        dd($profit);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        $pdf = PDF::loadView('acc::reports.trialbalance.pdf', ['records' => $records, 'profit' => $profit, 'start_date' => $request->start_date, 'end_date' => $request->end_date, 'branch_name' => $branch_name]);
        return $pdf->stream('acc::pdf.transaction-print');

    }


    /* Profit Loss Statement */
    public function profitLossFilter(Request $request)
    {
        $start_date = today()->startOfMonth()->toDateString();
        $end_date = today()->toDateString();
        $branches = Branch::pluck('name', 'id')->all();
        View::share('title', 'Profit & Loss / Income Statement');
        return \view('acc::reports.profitloss.filter', compact('branches', 'start_date', 'end_date'));
    }

    public function profitLossPDF(Request $request)
    {
        $data = $this->getProfitLossReport($request);
        $pdf = PDF::loadView('acc::reports.profitloss.pdf', $data);
        return $pdf->stream('acc::pdf.transaction-print');

    }

    /* Profit Loss Statement */
    public function balanceSheetFilter(Request $request)
    {
        $start_date = today()->startOfMonth()->toDateString();
        $end_date = today()->toDateString();
        $branches = Branch::pluck('name', 'id')->all();
        View::share('title', 'Balance Sheet');
        return \view('acc::reports.balancesheet.filter', compact('branches', 'start_date', 'end_date'));
    }

    public function balanceSheetPDF(Request $request)
    {
        $data = $this->getBalanceSheetReport($request);
//        dd($data);
        $pdf = PDF::loadView('acc::reports.balancesheet.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('acc::reports.balancesheet.pdf');

    }


    /* Ledger Report */
    public function ledgerFilter(Request $request)
    {

        $start_date = today()->startOfMonth()->toDateString();
        $end_date = today()->toDateString();
        $branches = Branch::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        View::share('title', 'Ledger Report');
        return \view('acc::reports.ledger.filter', compact('branches', 'start_date', 'end_date', 'ledgers'));
    }

    public function ledgerPDF(Request $request)
    {
        $request->validate([
            'ledger_id' => 'required',
        ]);
        $data = $this->getLedgerReport($request->branch_id, $request->ledger_id, $request->start_date, $request->end_date);
//        dd($data);
        $pdf = PDF::loadView('acc::reports.ledger.pdf', $data);
        return $pdf->stream('acc::reports.ledger.pdf');

    }


    /* Ledger Report */
    public function voucherFilter(Request $request)
    {

        $start_date = today()->startOfMonth()->toDateString();
        $end_date = today()->toDateString();
        $branches = Branch::pluck('name', 'id')->all();
        $txns = Transaction::pluck('voucher_no', 'id')->all();
        View::share('title', 'Voucher Report');
        return \view('acc::reports.voucher.filter', compact('branches', 'start_date', 'end_date', 'txns'));
    }

    public function voucherPDF(Request $request)
    {
        $filter = $request->filter;
        if ($filter == 'Individual') {
            return redirect(route('transactions.transaction.pdf', $request->txn_id));
        }

        $data = $this->getVoucherReport($request);
        $pdf = PDF::loadView('acc::reports.voucher.pdf', $data);
        return $pdf->stream('acc::reports.voucher.pdf');

    }


    public function getPDF($id)
    {

        $transaction = Transaction::findOrFail($id);
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $in_word = $f->format($transaction->amount);

        $pdf = PDF::loadView('acc::pdf.transaction-print', ['transaction' => $transaction, 'in_word' => $in_word]);
        return $pdf->stream('acc::pdf.transaction-print');
//        return "sdjhdk";

    }


    /* Ledger Report */
    public function cashbookFilter(Request $request)
    {

        $start_date = today()->startOfMonth()->toDateString();
        $end_date = today()->toDateString();
        $branches = Branch::pluck('name', 'id')->all();
        $txns = Transaction::pluck('voucher_no', 'id')->all();
        View::share('title', 'Cash Book Report');
        return \view('acc::reports.cashbook.filter', compact('branches', 'start_date', 'end_date', 'txns'));
    }

    public function cashbookPDF(Request $request)
    {

        $data = $this->getCashBookReport($request);
//        dd($data);
        $cashAc = optional(GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first())->value;

        foreach ($data['txn_details'] as $index => $record) {
            $ledgersName = $record->transaction->transaction_details->where('ledger_id', '!=', $cashAc)->map(function ($item) {
                return $item->ledger->ledger_name;
            });
            $ledgersName = $ledgersName->implode(',');
            $record->ledgersName = $ledgersName;
//            dd($ops);
        }
//        dd($data);
        $pdf = PDF::loadView('acc::reports.cashbook.pdf', $data);
        return $pdf->stream('acc::reports.cashbook.pdf');

    }

    public function daybookFilter(Request $request)
    {

        $start_date = today()->startOfMonth()->toDateString();
        $end_date = today()->toDateString();
        $branches = Branch::pluck('name', 'id')->all();
        $txns = Transaction::pluck('voucher_no', 'id')->all();
        View::share('title', 'Day Book Report');
        return \view('acc::reports.daybook.filter', compact('branches', 'start_date', 'end_date', 'txns'));
    }

    public function daybookPDF(Request $request)
    {

        $data = $this->getDayBookReport($request);
//        dd($data);
//        $cashAc = optional(GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first())->value;
//
//        foreach ($data['txn_details'] as $index => $record) {
//            $ledgersName = $record->transaction->transaction_details->map(function ($item) {
//                return $item->ledger->ledger_name;
//            });
//            $ledgersName = $ledgersName->implode(',');
//            $record->ledgersName = $ledgersName;
////            dd($ops);
//        }
//        dd($data);
        $pdf = PDF::loadView('acc::reports.daybook.pdf', $data);
        return $pdf->stream('acc::reports.daybook.pdf');

    }


//$pdf = \App::make('dompdf.wrapper');
//$pdf->loadHTML('<h1>Test</h1>');
//return $pdf->stream();
}
