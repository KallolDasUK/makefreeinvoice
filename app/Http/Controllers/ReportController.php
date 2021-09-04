<?php

namespace App\Http\Controllers;

use App\Http\Services\ReportService;
use App\Models\BillItem;
use App\Models\ExpenseItem;
use App\Models\InvoiceItem;
use App\Models\Report;
use App\Models\Tax;
use Carbon\Carbon;
use Enam\Acc\Http\Controllers\AccountingReportsController;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Illuminate\Http\Request;

class ReportController extends AccountingReportsController
{

    use ReportService;


    public function index()
    {
        return view('reports.index');
    }

    public function taxReport(Request $request)
    {

        $this->authorize('tax_summary');
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $report_type = $request->report_type ?? 'accrual';
        $title = "Tax Report Summary";

        $taxes = $this->getTaxReport($start_date, $end_date, $report_type);


        return view('reports.tax-report', compact('title', 'start_date', 'end_date', 'report_type', 'taxes'));
    }

    public function stockReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $report_type = $request->report_type ?? 'accrual';
        $title = "Stock Report Summary";

        $records = $this->getStockReport($start_date, $end_date);


        return view('reports.stock-report', compact('title', 'start_date', 'end_date', 'report_type', 'records'));
    }


    public function arAgingReport(Request $request)
    {
        $this->authorize('ar_aging');
        $q = $request->q;

        $records = $this->getArAgingReport($q);
        return view('reports.ar-aging-report', compact('records', 'q'));
    }

    public function apAgingReport(Request $request)
    {
        $this->authorize('ap_aging', Report::class);
        $q = $request->q;
        $records = $this->getApAgingReport($q);
        return view('reports.ap-aging-report', compact('records', 'q'));
    }

    public function trialBalance(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $title = "Trial Balance";
        $branches = Branch::pluck('name', 'id')->all();

        list($records) = $this->getTrialBalanceReport($start_date, $end_date, $branch_id);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.trial-balance', compact('title', 'start_date', 'end_date', 'branch_name', 'records', 'branches', 'branch_id'));
    }

    public function lossProfitReport(Request $request)
    {

        $this->authorize('profit_loss');
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $title = "Loss Profit Report";
        $branches = Branch::pluck('name', 'id')->all();

        $data = $this->getProfitLossReport($start_date, $end_date, $branch_id);
//        dd($data);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.loss-profit', compact('title', 'start_date', 'end_date', 'branch_name', 'branches', 'branch_id') + $data);
    }


    public function ledgerReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $ledger_id = $request->ledger_id ?? null;
        $title = "Account/Ledger Reports";
        $branches = Branch::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $data = $this->getLedgerReport($branch_id, $ledger_id, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.ledger-report', compact('title', 'start_date',
            'end_date', 'ledgers', 'ledger_id', 'data', 'branches', 'branch_name',
            'branch_id'));
    }

    public function receiptPaymentReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $title = "Receipt & Payment Reports";
        $branches = Branch::pluck('name', 'id')->all();
        $receipts = $this->getReceiptReport($branch_id, $start_date, $end_date);
        $payments = $this->getPaymentReport($branch_id, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.receipt-payment-report', compact('title', 'start_date',
            'end_date', 'receipts', 'payments', 'branches', 'branch_name',
            'branch_id'));
    }

    public function cashbookReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $ledger_id = Ledger::CASH_AC();
        $title = "Cash Book Reports";
        $branches = Branch::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $data = $this->getLedgerReport($branch_id, $ledger_id, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.cashbook-report', compact('title', 'start_date',
            'end_date', 'ledgers', 'ledger_id', 'data', 'branches', 'branch_name',
            'branch_id'));
    }


    public function balanceSheetReport(Request $request)
    {

        $this->authorize('balance_sheet');
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? null;
        $prevent_opening = boolval($request->prevent_opening?? false) ;
        $assets = [];
        $asset_account = 'Asset';

//        dd($prevent_opening);
        $groups = LedgerGroup::query()->where('nature', $asset_account)->get();
        foreach ($groups as $group) {
            $record = [];
            $child_groups = LedgerGroup::query()->where('parent', $group->id)->get();
            $child_accounts = Ledger::query()->where('ledger_group_id', $group->id)->get();
            foreach ($child_groups as $g) {
                $closing_balance = 0;
                $ledgers = Ledger::query()->where('ledger_group_id', $g->id)->get();
                foreach ($ledgers as $ledger) {
                    $closing_balance += $ledger->closingBalance($branch_id, $start_date, $end_date,$prevent_opening);
                }
                if ($closing_balance == 0) {
                    continue;
                }

                $record[] = (object)['account_name' => $g->group_name,
                    'amount' => $closing_balance, 'is_account' => false, 'id' => $g->id];
            }
            foreach ($child_accounts as $account) {
                $closing_balance = $account->closingBalance($branch_id, $start_date, $end_date,$prevent_opening);
                if ($closing_balance == 0) {
                    continue;
                }
                $record[] = (object)['account_name' => $account->ledger_name,
                    'amount' => $closing_balance,
                    'is_account' => true, 'id' => $account->id];
            }
            if (count($record)) {
                $assets[$group->group_name] = $record;
            }

        }


        $libs = [];
        $lib_accounts = 'Liabilities';


        $groups = LedgerGroup::query()->where('nature', $lib_accounts)->get();
        foreach ($groups as $group) {
            $record = [];
            $child_groups = LedgerGroup::query()->where('parent', $group->id)->get();
            $child_accounts = Ledger::query()->where('ledger_group_id', $group->id)->get();
            foreach ($child_groups as $g) {
                $closing_balance = 0;
                $ledgers = Ledger::query()->where('ledger_group_id', $g->id)->get();
                foreach ($ledgers as $ledger) {
                    $closing_balance += $ledger->closingBalance($branch_id, $start_date, $end_date);
                }
                if ($closing_balance == 0) {
                    continue;
                }

                $record[] = (object)['account_name' => $g->group_name,
                    'amount' => $closing_balance, 'is_account' => false, 'id' => $g->id];
            }
            foreach ($child_accounts as $account) {
                $closing_balance = $account->closingBalance($branch_id, $start_date, $end_date);
                if ($closing_balance == 0) {
                    continue;
                }
                $record[] = (object)['account_name' => $account->ledger_name,
                    'amount' => $closing_balance,
                    'is_account' => true, 'id' => $account->id];
            }
            if (count($record)) {
                $libs[$group->group_name] = $record;
            }
        }
        $lossProfitReport = $this->getProfitLossReport($start_date, $end_date, $branch_id);
        $profit = $lossProfitReport['totalIncome'] - $lossProfitReport['totalExpense'];
        $libs['Equity'][] = (object)['account_name' => 'Retained Earnings </br> <span class="ml-4"></span>(Profit between ' . Carbon::parse($start_date)->format('M d Y') . '-' . Carbon::parse($end_date)->format('M d Y') . ')', 'amount' => $profit, 'is_account' => false];
//        dd($libs);

//        dd($assets, 'Working');

        $title = "Balance Sheet Report";
        $branches = Branch::pluck('name', 'id')->all();
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.balance-sheet-report', compact('title', 'start_date', 'end_date', 'branch_name', 'branches', 'branch_id', 'assets', 'libs','prevent_opening'));
    }


    public function voucherReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $title = 'Voucher Reports';
        $voucher_type = $request->voucher_type;
        $branches = Branch::pluck('name', 'id')->all();

        $records = $this->getVoucherReport($branch_id, $voucher_type, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";
        return view('reports.voucher-report', compact('title', 'start_date',
            'end_date', 'voucher_type', 'branches', 'branch_name', 'records',
            'branch_id'));
    }
}
