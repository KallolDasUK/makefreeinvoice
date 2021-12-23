<?php


namespace App\Http\Services;


use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Customer;
use App\Models\CustomerAdvancePayment;
use App\Models\ExpenseItem;
use App\Models\IngredientItem;
use App\Models\InventoryAdjustmentItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PosItem;
use App\Models\Product;
use App\Models\ProductionItem;
use App\Models\PurchaseReturnItem;
use App\Models\SalesReturnItem;
use App\Models\StockEntryItem;
use App\Models\Tax;
use App\Models\Vendor;
use App\Models\VendorAdvancePayment;
use Carbon\Carbon;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;

trait ReportService
{

    public function getCustomerOpeningBalance($start_date, $end_date, $customer_id)
    {
        $records = [];
        $invoices = Invoice::query()
            ->where('customer_id', $customer_id)
            ->where('invoice_date', '<', $start_date)
            ->get();
        foreach ($invoices as $invoice) {
            $record = ['date' => $invoice->invoice_date, 'invoice' => $invoice->invoice_number, 'description' => 'New Invoice Created', 'payment' => 0, 'amount' => $invoice->total];
            $records[] = (object)$record;
            if ($invoice->payments()->sum('amount') > 0) {
                foreach ($invoice->payments as $payment) {
                    if ($payment->receive_payment->payment_date < $start_date) {
                        $record = ['date' => $payment->receive_payment->payment_date, 'invoice' => $invoice->invoice_number, 'description' => 'Payment Received', 'payment' => $payment->amount, 'amount' => 0];
                        $records[] = (object)$record;
                    }
                }
            }
        }
        $amount = collect($records)->sum('amount');
        $payment = collect($records)->sum('payment');
        $balance = $amount - $payment;
        $customer = Customer::find($customer_id);
        $balance += floatval(optional($customer)->opening);
//        dd($balance);
        return (object)['amount' => $amount, 'payment' => $payment, 'balance' => $balance];

    }

    public function getVendorOpeningBalance($start_date, $end_date, $vendor_id)
    {
        $records = [];
        $bills = Bill::query()
            ->where('vendor_id', $vendor_id)
            ->where('bill_date', '<', $start_date)
            ->get();
        foreach ($bills as $bill) {
            $record = ['date' => $bill->bill_date, 'bill' => $bill->bill_number, 'description' => 'New Bill Created', 'payment' => 0, 'amount' => $bill->total];
            $records[] = (object)$record;
            if ($bill->payments()->sum('amount') > 0) {
                foreach ($bill->payments as $payment) {
                    if ($payment->bill_payment->payment_date < $start_date) {
                        $record = ['date' => $payment->bill_payment->payment_date, 'bill' => $bill->bill_number, 'description' => 'Paid', 'payment' => $payment->amount, 'amount' => 0];
                        $records[] = (object)$record;
                    }
                }
            }
        }
        $amount = collect($records)->sum('amount');
        $payment = collect($records)->sum('payment');
        $balance = $amount - $payment;
        $vendor = Vendor::find($vendor_id);
        $balance += floatval(optional($vendor)->opening ?? 0);
        return (object)['amount' => $amount, 'payment' => $payment, 'balance' => $balance];

    }

    public function getCustomerStatement($start_date, $end_date, $customer_id)
    {
        $records = [];
        $previous = $this->getCustomerOpeningBalance($start_date, $end_date, $customer_id);
        $record = ['date' => 'As on ' . $start_date, 'invoice' => '', 'description' => 'Balance Forward', 'payment' => 0, 'amount' => 0];
        $records[] = (object)$record;


        $invoices = Invoice::query()
            ->where('customer_id', $customer_id)
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->get();
        $customer = Customer::find($customer_id);

        $opening_payments = TransactionDetail::query()
            ->where('type', Ledger::class)
            ->where('type_id', $customer->ledger->id)
            ->where('ledger_id', $customer->ledger->id)
            ->where('entry_type', EntryType::$CR)->get();

        foreach ($opening_payments as $opening_payment) {
            $record = ['date' => $opening_payment->date,
                'invoice' => "-",
                'description' => 'Previous Due Payment',
                'amount' => 0, 'payment' => $opening_payment->amount];
            $records[] = (object)$record;
        }

        foreach (CustomerAdvancePayment::query()->where('customer_id', $customer_id)->get() as $customerAdvancePayment) {
            $record = ['date' => $customerAdvancePayment->date, 'invoice' => "-", 'description' => 'Advance Payment', 'amount' => 0, 'payment' => $customerAdvancePayment->amount];
            $records[] = (object)$record;
        }


        foreach ($invoices as $invoice) {
            $record = ['date' => $invoice->invoice_date, 'invoice' => $invoice->invoice_number, 'description' => 'New Invoice Created', 'payment' => 0, 'amount' => $invoice->total];
            $records[] = (object)$record;
            if ($invoice->payments()->sum('amount') > 0) {
                foreach ($invoice->payments as $payment) {
                    if ($payment->receive_payment->payment_date > $start_date && $payment->receive_payment->payment_date <= $end_date) {
                        $record = ['date' => $payment->receive_payment->payment_date, 'invoice' => $invoice->invoice_number, 'description' => 'Payment By ' . optional(optional($payment->receive_payment)->ledger)->ledger_name . '<br>' . optional($payment->receive_payment)->note, 'payment' => $payment->amount, 'amount' => 0];
                        $records[] = (object)$record;
                    }

                }
            }
        }


        return $records;
    }

    public function getVendorStatement($start_date, $end_date, $vendor_id)
    {
        $records = [];
        $previous = $this->getVendorOpeningBalance($start_date, $end_date, $vendor_id);
        $record = ['date' => 'As on ' . $start_date, 'bill' => '', 'description' => 'Balance Forward', 'payment' => 0, 'amount' => 0];
        $records[] = (object)$record;


        $bills = Bill::query()
            ->where('vendor_id', $vendor_id)
            ->whereBetween('bill_date', [$start_date, $end_date])
            ->get();
        $vendor = Vendor::find($vendor_id);

        $opening_payments = TransactionDetail::query()
            ->where('type', Ledger::class)
            ->where('type_id', $vendor->ledger->id)
            ->where('entry_type', EntryType::$DR)->get();

        foreach ($opening_payments as $opening_payment) {
            $record = ['date' => $opening_payment->date, 'bill' => "-",
                'description' => 'Previous Due Payment', 'amount' => 0,
                'payment' => $opening_payment->amount];
            $records[] = (object)$record;
        }
        foreach (VendorAdvancePayment::query()->where('vendor_id', $vendor_id)->get() as $customerAdvancePayment) {
            $record = ['date' => $customerAdvancePayment->date, 'bill' => "-", 'description' => 'Advance Payment', 'amount' => 0, 'payment' => $customerAdvancePayment->amount];
            $records[] = (object)$record;
        }

        foreach ($bills as $bill) {
            $record = ['date' => $bill->bill_date, 'bill' => $bill->bill_number, 'description' => 'New Bill Created', 'payment' => 0, 'amount' => $bill->total];
            $records[] = (object)$record;
            if ($bill->payments()->sum('amount') > 0) {
                foreach ($bill->payments as $payment) {
                    if ((optional($payment->bill_payment)->payment_date > $start_date && optional($payment->bill_payment)->payment_date <= $end_date)) {
                        $record = ['date' => optional($payment->bill_payment)->payment_date, 'bill' => $bill->bill_number, 'description' => 'Payment by ' . optional(optional($payment->bill_payment)->ledger)->ledger_name . '<br>' . optional($payment->bill_payment)->note, 'payment' => $payment->amount, 'amount' => 0];
                        $records[] = (object)$record;
                    }

                }
            }
        }


        return $records;
    }

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
        $sold += PosItem::query()
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
        $purchase_return = PurchaseReturnItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('qnt');

        $sales_return = SalesReturnItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('qnt');
        $stock_entry = StockEntryItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('qnt');
        $used_in_production = IngredientItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('qnt');
        $produced_in_production = ProductionItem::query()
            ->where('product_id', $product->id)
            ->where('date', '<', $start_date)
            ->sum('qnt');

        $opening_stock = ($enteredOpening + $purchase + $added + $sales_return + $produced_in_production + $stock_entry) - ($sold + $removed + $purchase_return + $used_in_production);
        return $opening_stock;
    }

    public function getStockReport($start_date, $end_date, $brand_id, $category_id, $product_id)
    {
        $records = [];

        $products = Product::query()
            ->when($brand_id != null, function ($query) use ($brand_id) {
                return $query->where('brand_id', $brand_id);
            })
            ->when($category_id != null, function ($query) use ($category_id) {
                return $query->where('category_id', $category_id);
            })
            ->when($product_id != null, function ($query) use ($product_id) {
                return $query->where('id', $product_id);
            })
            ->get();
        foreach ($products as $product) {
            $record = ['name' => $product->name, 'price' => $product->price, 'opening_stock' => 0, 'purchase' => 0, 'sold' => 0, 'added' => 0, 'removed' => 0, 'stock' => 0, 'stockValue' => 0];

            $opening_stock = $this->openingStock($product, $start_date, $end_date);
            $record['opening_stock'] = $opening_stock;

            $sold = InvoiceItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');
            $sold += PosItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');

            $purchase = BillItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');

            $purchase_return = PurchaseReturnItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');
            $sales_return = SalesReturnItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');
            $added = InventoryAdjustmentItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('add_qnt');

            $stock_entry = StockEntryItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');

            $removed = InventoryAdjustmentItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('sub_qnt');

            $used_in_production = IngredientItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');
            $produced_in_production = ProductionItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('qnt');
            $record['sold'] = $sold;
            $record['sales_return'] = $sales_return;
            $record['purchase'] = $purchase;
            $record['purchase_return'] = $purchase_return;
            $record['added'] = $added;
            $record['removed'] = $removed;
            $record['stock_entry'] = $stock_entry;
            $record['used_in_production'] = $used_in_production;
            $record['produced_in_production'] = $produced_in_production;
            $record['stock'] = ($opening_stock + $purchase + $added + $sales_return + $produced_in_production + $stock_entry) - ($sold + $removed + $purchase_return + $used_in_production);
            $record['stockValue'] = $record['price'] * $record['stock'];

            $records[] = (object)$record;
        }

        return $records;

    }

    public function getArAgingReport($q)
    {
        $records = [];
        $customers = Customer::query()
            ->when($q != null, function ($builder) use ($q) {
                return $builder->where('name', 'like', '%' . $q . '%')->orWhere('phone', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%');
            })
            ->get();
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

    public function getApAgingReport($q)
    {
        $records = [];
        $vendors = Vendor::query()->when($q != null, function ($builder) use ($q) {
            return $builder->where('name', 'like', '%' . $q . '%')->orWhere('phone', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%');
        })->get();
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

    public function getStockReportDetails($start_date, $end_date, $product_id)
    {
        
    }
}
