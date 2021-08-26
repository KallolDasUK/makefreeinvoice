<?php


namespace App\Http\Services;


use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Customer;
use App\Models\ExpenseItem;
use App\Models\InventoryAdjustmentItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Vendor;
use Carbon\Carbon;

trait ReportService
{

    function getTaxReport($start_date, $end_date, $report_type)
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
            if ($report_type == 'cash') {
                $invoice_items = $invoice_items->filter(function ($invoice_item) {
                    if ($invoice_item->invoice->payment_status == Invoice::Paid) {
                        return true;
                    }
                    return false;
                });
            }

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

            if ($report_type == 'cash') {
                $bill_items = $bill_items->filter(function ($bill_item) {
                    if ($bill_item->bill->payment_status == Bill::Paid) {
                        return true;
                    }
                    return false;
                });
            }

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

    public function openingStock($product, $start_date, $end_date)
    {
        $enteredOpening = $product->opening_stock ?? 0;
        $sold = InvoiceItem::query()
            ->where('product_id', $product->id)
            ->whereDate('date', '<', $start_date)
            ->sum('qnt');

        $purchase = BillItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('qnt');

        $added = InventoryAdjustmentItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('add_qnt');

        $removed = InventoryAdjustmentItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('sub_qnt');


        $opening_stock = ($enteredOpening + $purchase + $added) - ($sold + $removed);
        return $opening_stock;
    }

    public function getStockReport($start_date, $end_date)
    {
        $records = [];

        $products = Product::all();
        foreach ($products as $product) {
            $record = ['name' => $product->name, 'opening_stock' => 0, 'purchase' => 0, 'sold' => 0, 'added' => 0, 'removed' => 0, 'stock' => 0];

            $opening_stock = $this->openingStock($product, $start_date, $end_date);


            $record['opening_stock'] = $opening_stock;

            $sold = InvoiceItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');

            $purchase = BillItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');

            $added = InventoryAdjustmentItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('add_qnt');

            $removed = InventoryAdjustmentItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('sub_qnt');

            $record['sold'] = $sold;
            $record['purchase'] = $purchase;
            $record['added'] = $added;
            $record['removed'] = $removed;
            $record['stock'] = ($opening_stock + $purchase + $added) - ($sold + $removed);

            $records[] = (object)$record;
        }

        return $records;

    }

    public function getArAgingReport()
    {
        $records = [];
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $record = ['name' => $customer->name, '_0_30' => 0, '_31_60' => 0, '_61_90' => 0, '_90' => 0, 'total' => 0];
            $invoices = Invoice::query()
                ->where('customer_id', $customer->id)
                ->where('payment_status', '!=', Invoice::Paid)
                ->get();

            foreach ($invoices as $invoice) {
                $age = $invoice->age;
                if ($age >= 0 && $age <= 30) {
                    $record['_0_30'] += $invoice->due;
                } else if ($age >= 31 && $age <= 60) {
                    $record['_31_60'] += $invoice->due;
                } else if ($age >= 61 && $age <= 90) {
                    $record['_61_90'] += $invoice->due;
                } else {
                    $record['_90'] += $invoice->due;
                }
                $record['total'] += $invoice->due;
            }
            if ($record['total'] > 0) {
                $records[] = (object)$record;
            }

        }
        return $records;
    }

    public function getApAgingReport()
    {
        $records = [];
        $vendors = Vendor::all();
        foreach ($vendors as $vendor) {
            $record = ['name' => $vendor->name, '_0_30' => 0, '_31_60' => 0, '_61_90' => 0, '_90' => 0, 'total' => 0];
            $bills = Bill::query()
                ->where('vendor_id', $vendor->id)
                ->where('payment_status', '!=', Invoice::Paid)
                ->get();

            foreach ($bills as $bill) {
                $age = $bill->age;
                if ($age >= 0 && $age <= 30) {
                    $record['_0_30'] += $bill->due;
                } else if ($age >= 31 && $age <= 60) {
                    $record['_31_60'] += $bill->due;
                } else if ($age >= 61 && $age <= 90) {
                    $record['_61_90'] += $bill->due;
                } else {
                    $record['_90'] += $bill->due;
                }
                $record['total'] += $bill->due;
            }
            if ($record['total'] > 0) {
                $records[] = (object)$record;
            }
        }
        return $records;
    }
}
