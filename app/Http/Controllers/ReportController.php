<?php

namespace App\Http\Controllers;

use App\Http\Services\ReportService;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Customer;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PosItem;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\Product;
use App\Models\ReceivePaymentItem;
use App\Models\Report;
use App\Models\Tax;
use App\Models\Vendor;
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
        view()->share('title', 'Reports');
        return view('reports.index');
    }

    public function taxReport(Request $request)
    {

        $this->authorize('tax_summary');
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $report_type = $request->report_type ?? 'accrual';
        $title = "Tax Report Summary";

        $taxes = $this->getTaxReport($start_date, $end_date, $report_type);


        return view('reports.tax-report', compact('title', 'start_date', 'end_date', 'report_type', 'taxes'));
    }

    public function customerStatement(Request $request)
    {

        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $customer_id = $request->customer_id;
        $customers = Customer::all();


        $title = "Customer Statement";

        if ($customer_id) {
            $records = $this->getCustomerStatement($start_date, $end_date, $customer_id);
            $previous = $this->getCustomerOpeningBalance($start_date, $end_date, $customer_id);
            $opening = $previous->amount - $previous->payment + $previous->balance;
            $customer = Customer::find(intval($customer_id));
        } else {
            $records = [];
            $previous = 0;
            $opening = 0;
            $customer = null;
        }
        //        dd($customer,$customer_id,$customer->name);
        return view('reports.customer-statement', compact('title', 'start_date', 'end_date', 'customers', 'records', 'customer_id', 'customer', 'previous', 'opening'));
    }

    public function vendorStatement(Request $request)
    {

        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $vendor_id = $request->vendor_id;
        $vendors = Vendor::all();

        $vendor = Vendor::find($vendor_id);

        $title = "Vendor Statement";

        if ($vendor_id) {
            $records = $this->getVendorStatement($start_date, $end_date, $vendor_id);
            $previous = $this->getVendorOpeningBalance($start_date, $end_date, $vendor_id);
            $opening = $previous->amount - $previous->payment + $previous->balance;
        } else {
            $records = [];
            $previous = 0;
            $opening = 0;
        }

        return view('reports.vendor-statement', compact('title', 'start_date', 'end_date', 'vendors', 'records', 'vendor_id', 'vendor', 'previous', 'opening'));
    }

    public function stockReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $report_type = $request->report_type ?? 'accrual';
        $brand_id = $request->brand_id;
        $category_id = $request->category_id;
        $product_id = $request->product_id;
        $title = "Stock Report";

        $records = $this->getStockReport($start_date, $end_date, $brand_id, $category_id, $product_id);


        return view('reports.stock-report', compact('title', 'start_date', 'end_date', 'report_type', 'product_id', 'records', 'brand_id', 'category_id'));
    }

    public function stockReportDetails(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();


        $report_type = $request->report_type ?? 'accrual';
        $brand_id = $request->brand_id;
        $category_id = $request->category_id;
        $product_id = $request->product_id;
        $title = "Stock Report Details";
        $selected_product = Product::find($product_id);
        list($records, $opening_stock) = $this->getStockReportDetails($start_date, $end_date, $product_id);
        //        dd($product->sell_unit);

        return view('reports.stock-report-details', compact('title', 'selected_product', 'start_date', 'end_date', 'report_type', 'product_id', 'records', 'brand_id', 'category_id', 'opening_stock'));
    }


    public function arAgingReport(Request $request)
    {
        view()->share('title', 'Account Receivable Aging');
        $this->authorize('ar_aging');
        $q = $request->q;

        $records = $this->getArAgingReport($q);
        return view('reports.ar-aging-report', compact('records', 'q'));
    }

    public function apAgingReport(Request $request)
    {
        view()->share('title', 'Account payable Aging');
        $this->authorize('ap_aging', Report::class);
        $q = $request->q;
        $records = $this->getApAgingReport($q);
        return view('reports.ap-aging-report', compact('records', 'q'));
    }

    public function trialBalance(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
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
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
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
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $ledger_id = $request->ledger_id ?? null;
        $title = "Account/Ledger Reports";
        $branches = Branch::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $data = $this->getLedgerReport($branch_id, $ledger_id, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.ledger-report', compact(
            'title',
            'start_date',
            'end_date',
            'ledgers',
            'ledger_id',
            'data',
            'branches',
            'branch_name',
            'branch_id'
        ));
    }

    public function receiptPaymentReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $title = "Receipt & Payment Reports";
        $branches = Branch::pluck('name', 'id')->all();
        $receipts = $this->getReceiptReport($branch_id, $start_date, $end_date);
        $payments = $this->getPaymentReport($branch_id, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.receipt-payment-report', compact(
            'title',
            'start_date',
            'end_date',
            'receipts',
            'payments',
            'branches',
            'branch_name',
            'branch_id'
        ));
    }

    public function cashbookReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $ledger_id = Ledger::CASH_AC();
        $title = "Cash Book Reports";
        $branches = Branch::pluck('name', 'id')->all();
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $data = $this->getLedgerReport($branch_id, $ledger_id, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.cashbook-report', compact(
            'title',
            'start_date',
            'end_date',
            'ledgers',
            'ledger_id',
            'data',
            'branches',
            'branch_name',
            'branch_id'
        ));
    }


    public function balanceSheetReport(Request $request)
    {

        $this->authorize('balance_sheet');
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? null;
        $prevent_opening = boolval($request->prevent_opening ?? false);
        $assets = [];
        $asset_account = 'Asset';
        $totalAssetValue = 0;
        $totalLibValue = 0;

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
                    $closing_balance += $ledger->closingBalance($branch_id, $start_date, $end_date, $prevent_opening);
                }
                if ($closing_balance == 0) {
                    continue;
                }
                $totalAssetValue += $closing_balance;
                $record[] = (object)[
                    'account_name' => $g->group_name,
                    'amount' => $closing_balance, 'is_account' => false, 'id' => $g->id
                ];
            }
            foreach ($child_accounts as $account) {
                $closing_balance = $account->closingBalance($branch_id, $start_date, $end_date, $prevent_opening);
                if ($closing_balance == 0) {
                    continue;
                }
                $totalAssetValue += $closing_balance;

                $record[] = (object)[
                    'account_name' => $account->ledger_name,
                    'amount' => $closing_balance,
                    'is_account' => true, 'id' => $account->id
                ];
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
                $totalLibValue += $closing_balance;

                $record[] = (object)[
                    'account_name' => $g->group_name,
                    'amount' => $closing_balance, 'is_account' => false, 'id' => $g->id
                ];
            }
            foreach ($child_accounts as $account) {
                $closing_balance = $account->closingBalance($branch_id, $start_date, $end_date);
                if ($closing_balance == 0) {
                    continue;
                }
                $totalLibValue += $closing_balance;

                $record[] = (object)[
                    'account_name' => $account->ledger_name,
                    'amount' => $closing_balance,
                    'is_account' => true, 'id' => $account->id
                ];
            }
            if (count($record)) {
                $libs[$group->group_name] = $record;
            }
        }
        $lossProfitReport = $this->getProfitLossReport($start_date, $end_date, $branch_id);
        $profit = $lossProfitReport['totalIncome'] - $lossProfitReport['totalExpense'];
        $libs['Equity'][] = (object)['account_name' => 'Retained Earnings </br> <span class="ml-4"></span>(Profit between ' . Carbon::parse($start_date)->format('M d Y') . '-' . Carbon::parse($end_date)->format('M d Y') . ')', 'amount' => $profit, 'is_account' => false];
        $totalLibValue += $profit;

        $libs['Equity'][] = (object)['account_name' => 'Unearned Revenue', 'amount' => $totalAssetValue - $totalLibValue, 'is_account' => false];
        //        dd($libs);

        //        dd($totalAssetValue,$totalLibValue, 'Working');

        $title = "Balance Sheet Report";
        $branches = Branch::pluck('name', 'id')->all();
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";

        return view('reports.balance-sheet-report', compact('title', 'start_date', 'end_date', 'branch_name', 'branches', 'branch_id', 'assets', 'libs', 'prevent_opening'));
    }


    public function voucherReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $branch_id = $request->branch_id ?? 'All';
        $title = 'Voucher Reports';
        $voucher_type = $request->voucher_type;
        $branches = Branch::pluck('name', 'id')->all();

        $records = $this->getVoucherReport($branch_id, $voucher_type, $start_date, $end_date);
        $branch_name = optional(Branch::find($request->branch_id))->name ?? "All";


        return view('reports.voucher-report', compact(
            'title',
            'start_date',
            'end_date',
            'voucher_type',
            'branches',
            'branch_name',
            'records',
            'branch_id'
        ));
    }

    public function salesReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $customer_id = $request->customer_id;
        $invoice_id = $request->invoice_id;
        $user_id = $request->user_id;
        $payment_status = $request->payment_status;
        $records = $this->getSalesReport($start_date, $end_date, $customer_id, $invoice_id, $payment_status, $user_id);
        $title = 'Sales Report';

        $invoices = Invoice::all();
        $pos_sales = PosSale::all();
        $customers = Customer::all();
        return view('reports.sales-report', compact(
            'title',
            'pos_sales',
            'records',
            'invoices',
            'customers',
            'start_date',
            'end_date',
            'customer_id',
            'invoice_id',
            'payment_status',
            'user_id'
        ));
    }

    public function salesReportDetails(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $customer_id = $request->customer_id;
        $invoice_id = $request->invoice_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;
        $user_id = $request->user_id;
        $records = $this->getSalesReportDetails($start_date, $end_date, $customer_id, $invoice_id, $product_id, $brand_id, $category_id, $user_id);
        $title = 'Sales Report Details';

        $invoices = Invoice::query()->select('id', 'invoice_number')->get();
        $pos_sales = PosSale::query()->select('id', 'pos_number')->get();
        $customers = \DB::table('customers')
            ->where('client_id', auth()->user()->client_id)
            ->select('name', 'id', 'email', 'phone')
            ->get()->toArray();

        $users = \App\Models\User::query()
            ->where('client_id', auth()->user()->client_id)
            ->select('id', 'name')->get();

        //        dd(count($records));
        return view('reports.sales-report-details', compact(
            'title',
            'pos_sales',
            'records',
            'invoices',
            'customers',
            'start_date',
            'end_date',
            'customer_id',
            'invoice_id',
            'category_id',
            'brand_id',
            'product_id',
            'users',
            'user_id'
        ));
    }

    public function purchaseReport(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $vendor_id = $request->vendor;
        $bill_id = $request->bill_id;
        $user_id = $request->user_id;
        $payment_status = $request->payment_status;
        $records = $this->getPurchaseReport($start_date, $end_date, $vendor_id, $bill_id, $payment_status);
        $title = 'Purchase Report';

        $bills = Bill::all();
        $vendors = Vendor::all();
        return view('reports.purchase-report', compact('title', 'records', 'bills', 'vendors', 'start_date', 'end_date', 'vendor_id', 'bill_id', 'payment_status', 'user_id'));
    }

    public function purchaseReportDetails(Request $request)
    {
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $vendor_id = $request->vendor_id;
        $bill_id = $request->bill_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;
        $user_id = $request->user_id;
        $records = $this->getPurchaseReportDetails($start_date, $end_date, $vendor_id, $bill_id, $product_id, $brand_id, $category_id, $user_id);
        $title = 'Purchase Report Details';

        $bills = Bill::all();
        $vendors = Vendor::all();
        $products = \App\Models\Product::select('id', 'name')->get();
        $users = \App\Models\User::query()
            ->where('client_id', auth()->user()->client_id)
            ->select('id', 'name')->get();

        //        dd(count($records));
        return view('reports.purchase-report-details', compact(
            'title',
            'records',
            'bills',
            'vendors',
            'start_date',
            'end_date',
            'vendor_id',
            'bill_id',
            'category_id',
            'brand_id',
            'product_id',
            'user_id',
            'products',
            'users'
        ));
    }

    public function dueCollectionReport(Request $request)
    {
        $title = "Due Collection Report";
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $ref = $request->ref;
        $user_id = $request->user_id;

        $customer_id = $request->customer_id;
        $customers = Customer::query()->select('id','name')->get();
        $records = $this->getDueCollectionReport($start_date, $end_date, $customer_id, $user_id);
        $users = \App\Models\User::query()
            ->where('client_id', auth()->user()->client_id)
            ->select('id', 'name')->get();
        return view('reports.due-collection-report', compact('ref', 'start_date', 'end_date', 'customer_id', 'customers', 'records', 'title', 'user_id', 'users'));
    }

    public function duePaymentReport(Request $request)
    {

        $title = "Due Payment Report";
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $ref = $request->ref;
        $vendor_id = $request->vendor_id;
        $user_id = $request->user_id;
        $vendors = Vendor::query()->select('id', 'name')->get();
        $records = $this->getDuePaymentReport($start_date, $end_date, $vendor_id, $user_id);
        $users = \App\Models\User::query()
            ->where('client_id', auth()->user()->client_id)
            ->select('id', 'name')->get();
        return view('reports.due-payment-report', compact('ref', 'start_date', 'end_date', 'vendor_id', 'vendors', 'records', 'title', 'user_id', 'users'));
    }

    public function productReport()
    {
        view()->share('title', 'Product Report');
        $products = Product::all();
        return view('reports.product-report', compact('products'));
    }

    public function customerReport()
    {
        view()->share('title', 'Customer Report');
        $customers = Customer::all();
        return view('reports.customer-report', compact('customers'));
    }

    public function vendorReport()
    {
        view()->share('title', 'Vendor Report');
        $vendors = Vendor::all();
        return view('reports.vendor-report', compact('vendors'));
    }

    public function productExpiryReport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $records = [];
        $bill_items = BillItem::query()->whereNotNull('batch')->get();
        foreach ($bill_items as $bill_item) {
            $record = [];
            $sold_qnt_from_batch = InvoiceItem::query()->where(['product_id' => $bill_item->product_id, 'batch' => $bill_item->batch])->sum('qnt');
            $sold_qnt_from_batch_pos = PosItem::query()->where(['product_id' => $bill_item->product_id, 'batch' => $bill_item->batch])->sum('qnt');

            $remaining_qnt = $bill_item->qnt - ($sold_qnt_from_batch + $sold_qnt_from_batch_pos);
            if ($remaining_qnt > 0) {
                $record = [
                    'product' => Product::find($bill_item->product_id),
                    'exp_date' => $bill_item->exp_date,
                    'batch' => $bill_item->batch, 'qnt' => $remaining_qnt
                ];
                $records[] = (object)$record;
            }
        }
        return view('reports.product-expiry-report', compact('start_date', 'end_date', 'records'));
    }

    public function stockAlert(Request $request)
    {

        $records = [];
        $products = Product::all();
        foreach ($products as $product) {
            if ($product->stock <= $product->minimum_stock) {
                $record = [
                    'product' => $product,
                    'stock' => $product->stock,
                    'minimum_stock' => $product->minimum_stock
                ];
                $records[] = (object)$record;
            }
        }

        return view('reports.stock-alert-report', compact('records'));
    }

    public function stockAlertModal(Request $request)
    {
        view()->share('title', 'Stock Alert');
        $records = [];
        $products = Product::all();
        foreach ($products as $product) {
            if ($product->stock <= $product->minimum_stock) {
                $record = [
                    'product' => $product,
                    'stock' => $product->stock,
                    'minimum_stock' => $product->minimum_stock
                ];
                $records[] = (object)$record;
            }
        }

        return view('reports.partials.stock-alert-partial', compact('records'));
    }

    public function popularProductReport(Request $request)
    {
        view()->share('title', 'Popular Products');
        $start_date = $request->start_date ?? today()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? today()->toDateString();
        $records = [];
        $products = Product::all();
        foreach ($products as $product) {
            $invoice_items = InvoiceItem::query()
                ->where('product_id', $product->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->get();
            $sold = $invoice_items->sum('qnt');
            if ($sold == 0) continue;
            $record = ['product_name' => $product->name, 'stock' => $product->stock, 'sold' => $sold];
            $records[] = (object)$record;
        }
        $records = collect($records)->sortBy('sold', SORT_DESC, SORT_DESC);

        return view('reports.popular-products-report', compact('records', 'start_date', 'end_date'));
    }
}
