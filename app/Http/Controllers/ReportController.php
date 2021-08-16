<?php

namespace App\Http\Controllers;

use App\Models\BillItem;
use App\Models\ExpenseItem;
use App\Models\InvoiceItem;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function taxReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfYear()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $report_type = $request->report_type ?? '';
        $title = "Tax Report Summary";

        $taxes = $this->getAccrualTaxReport($start_date, $end_date);

//    dd(getCashTaxReport($start_date, $end_date));

        return view('reports.tax-report', compact('title', 'start_date', 'end_date', 'report_type', 'taxes'));
    }

    function getCashTaxReport($start_date, $end_date)
    {

        $taxes = [];
        foreach (\App\Models\Invoice::all() as $invoice) {
            foreach ($invoice->taxes as $tax) {
                $taxes[] = $tax;
            }
        }
        $tax_id = [];

        $trimmedTax = [];
        foreach ($taxes as $tax) {

            if (in_array($tax['tax_id'], $tax_id)) {
                $trimmedTax[$tax['tax_id']]['tax_amount'] += $tax['tax_amount'];
                continue;
            }
            $trimmedTax[$tax['tax_id']] = ['tax_id' => $tax['tax_id'], 'tax_name' => $tax['tax_name'], 'tax_amount' => $tax['tax_amount']];
            $tax_id[] = $tax['tax_id'];
        }

        dump($trimmedTax);
        return $taxes;
    }

    function getAccrualTaxReport($start_date, $end_date)
    {
        $taxes = Tax::query()->get();
        $records = [];
        foreach ($taxes as $tax) {
            $record = ['tax_id' => $tax->id, 'tax_name' => $tax->name . '(' . $tax->value . '%)'];


            /* Sales/Invoice Tax */
            $invoice_tax_amount = 0;
            $invoice_taxable = 0;
            $invoice_items = InvoiceItem::query()
                ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
                ->where('tax_id', $tax->id)->get();

            foreach ($invoice_items as $invoice_item) {
                $invoice_taxable += $invoice_item->amount;
                $invoice_tax_amount += $invoice_item->tax_amount;
            }

            $record['invoice_taxable'] = $invoice_taxable;
            $record['invoice_tax_amount'] = $invoice_tax_amount;


            /* Expense Tax */
            $expense_tax_amount = 0;
            $expense_taxable = 0;
            $expense_items = ExpenseItem::query()
                ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
                ->where('tax_id', $tax->id)->get();
            foreach ($expense_items as $expense_item) {
                $expense_taxable += $expense_item->amount;
                $expense_tax_amount += $expense_item->tax_amount;
            }
            $record['expense_taxable'] = $expense_taxable;
            $record['expense_tax_amount'] = $expense_tax_amount;

            /* Bill Tax */
            $bill_tax_amount = 0;
            $bill_taxable = 0;
            $bill_items = BillItem::query()
                ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
                ->where('tax_id', $tax->id)->get();
            foreach ($bill_items as $bill_item) {
                $bill_taxable += $bill_item->amount;
                $bill_tax_amount += $bill_item->tax_amount;
            }
            $record['bill_taxable'] = $bill_taxable;
            $record['bill_tax_amount'] = $bill_tax_amount;


            $tax_amount = $invoice_tax_amount + $expense_tax_amount + $bill_tax_amount;
            if ($tax_amount) {
                $record['tax_amount'] = $invoice_tax_amount + $expense_tax_amount - $bill_tax_amount;
                $records[] = (object)$record;
            }


        }

        return $records;
    }
}
