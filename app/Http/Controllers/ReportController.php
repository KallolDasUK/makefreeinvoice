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

        $records = $this->getArAgingReport();
        return view('reports.ar-aging-report', compact('records'));
    }

    public function apAgingReport(Request $request)
    {
        $this->authorize('ap_aging', Report::class);

        $records = $this->getApAgingReport();
        return view('reports.ap-aging-report', compact('records'));
    }

    public function trialBalance(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? null;
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
        $branch_id = $request->branch_id ?? null;
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
        $branch_id = $request->branch_id ?? null;
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

    public function cashbookReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? null;
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

        $data = [];
        foreach (['Asset', 'Liabilities', 'Income', 'Expense'] as $acc) {

            $groups = LedgerGroup::query()->where('nature', $acc)->get();
            $nodes = [];
            foreach ($groups as $group) {
                $nodes[] = ['text' => $group->group_name, 'nodes' => $group->group_name];
            }
            $data[$acc][] = ['text' => $acc, 'nodes' => $nodes];
        }

        dd($data,'Working');
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? null;
        $title = "Balance Sheet Report";
        $branches = Branch::pluck('name', 'id')->all();

        $data = $this->getProfitLossReport($start_date, $end_date, $branch_id);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.balance-sheet-report', compact('title', 'start_date', 'end_date', 'branch_name', 'branches', 'branch_id') + $data);
    }
}
