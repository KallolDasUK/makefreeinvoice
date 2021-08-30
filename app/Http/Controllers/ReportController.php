<?php

namespace App\Http\Controllers;

use App\Http\Services\ReportService;
use App\Models\BillItem;
use App\Models\ExpenseItem;
use App\Models\InvoiceItem;
use App\Models\Report;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
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


}
