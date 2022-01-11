@extends('master.master-layout')

@section('css')
    <link href="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link rel="stylesheet/less"
          href="https://raw.githack.com/kosmikko/bootstrap-checkbox-tree/master/css/bootstrap-checkbox-tree.less"
          type="text/css"/>
    <style>
        ul {
            list-style-type: none;
        }

        ul li {
            list-style-type: none;
            display: inline-block;

        }

        .col > label {
            font-weight: bolder;
        }

    </style>
@endsection
@section('content')
    <h2>Subscription Configurations</h2>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    {{-- Free Plan --}}
    <div class="card">
        <div class="card-header">
            <strong>Free Plan</strong>
        </div>
        <div class="">


            <form action="{{ route('master.subscriptions.free_plan') }}" method="post" class="well">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <ul class="checkbox-tree root">
                            <li>
                                <input type="checkbox"/>
                                <label> <b>Invoices/Sale</b></label>
                                <ul class="manu ">
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.viewAny" {{ $global_settings->free_invoices_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.view" {{ $global_settings->free_invoices_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.create" {{ $global_settings->free_invoices_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.update" {{ $global_settings->free_invoices_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.delete" {{ $global_settings->free_invoices_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.share"{{ $global_settings->free_invoices_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.email"{{ $global_settings->free_invoices_email??false?'checked':''}}/>
                                        <label>Email</label>
                                    </li>
                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Estimates/Quotation</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.viewAny" {{ $global_settings->free_estimates_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.view" {{ $global_settings->free_estimates_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.create" {{ $global_settings->free_estimates_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.update" {{ $global_settings->free_estimates_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.delete" {{ $global_settings->free_estimates_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.share" {{ $global_settings->free_estimates_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Bills/Purchase</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="bills.viewAny" {{ $global_settings->free_bills_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.view" {{ $global_settings->free_bills_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.create" {{ $global_settings->free_bills_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.update" {{ $global_settings->free_bills_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.delete" {{ $global_settings->free_bills_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.share" {{ $global_settings->free_bills_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Expenses</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.viewAny" {{ $global_settings->free_expenses_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.view" {{ $global_settings->free_expenses_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.create" {{ $global_settings->free_expenses_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.update" {{ $global_settings->free_expenses_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.delete" {{ $global_settings->free_expenses_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Stock Adjustment</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.viewAny" {{ $global_settings->free_inventory_adjustment_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.view" {{ $global_settings->free_inventory_adjustment_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.create" {{ $global_settings->free_inventory_adjustment_create??false?'checked':''}} />
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.update" {{ $global_settings->free_inventory_adjustment_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.delete" {{ $global_settings->free_inventory_adjustment_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="col">
                        <ul class="checkbox-tree root ">
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Accounts/Ledger</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.viewAny" {{ $global_settings->free_ledgers_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.view" {{ $global_settings->free_ledgers_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.create" {{ $global_settings->free_ledgers_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.update" {{ $global_settings->free_ledgers_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.delete" {{ $global_settings->free_ledgers_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Account Group</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.viewAny" {{ $global_settings->free_ledger_groups_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.view" {{ $global_settings->free_ledger_groups_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.create" {{ $global_settings->free_ledger_groups_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.update" {{ $global_settings->free_ledger_groups_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.delete" {{ $global_settings->free_ledger_groups_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Branches</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="branches.viewAny" {{ $global_settings->free_branches_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.view" {{ $global_settings->free_branches_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.create" {{ $global_settings->free_branches_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.update" {{ $global_settings->free_branches_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.delete" {{ $global_settings->free_branches_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>


                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Vouchers</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.payment" {{ $global_settings->free_vouchers_payment??false?'checked':''}}/>
                                        <label>Payment (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.receipt" {{ $global_settings->free_vouchers_receipt??false?'checked':''}}/>
                                        <label>Receipt (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.journal" {{ $global_settings->free_vouchers_journal??false?'checked':''}}/>
                                        <label>Journal (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.contra" {{ $global_settings->free_vouchers_contra??false?'checked':''}}/>
                                        <label>Contra (CRUD)</label>
                                    </li>


                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Reports</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="reports.tax_summary" {{ $global_settings->free_reports_tax_summary??false?'checked':''}}/>
                                        <label>Tax Summary</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ar_aging" {{ $global_settings->free_reports_ar_aging??false?'checked':''}}/>
                                        <label>AR Aging</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ap_aging" {{ $global_settings->free_reports_ap_aging??false?'checked':''}}/>
                                        <label>AP Aging</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.trial_balance" {{ $global_settings->free_reports_trial_balance??false?'checked':''}}/>
                                        <label>Trial Balance</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.receipt_payment" {{ $global_settings->free_reports_receipt_payment??false?'checked':''}}/>
                                        <label>Receipt Payment</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ledger" {{ $global_settings->free_reports_ledger??false?'checked':''}}/>
                                        <label>Ledger</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.profit_loss" {{ $global_settings->free_reports_profit_loss??false?'checked':''}}/>
                                        <label>Profit Loss</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.voucher" {{ $global_settings->free_reports_voucher??false?'checked':''}}/>
                                        <label>Voucher</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.cash_book" {{ $global_settings->free_reports_cash_book??false?'checked':''}}/>
                                        <label>Cash Book</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.day_book" {{ $global_settings->free_reports_day_book??false?'checked':''}}/>
                                        <label>Day Book</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.balance_sheet" {{ $global_settings->free_reports_balance_sheet??false?'checked':''}}/>
                                        <label>Balance Sheet</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.stock_report" {{ $global_settings->free_reports_stock_report??false?'checked':''}}/>
                                        <label>Stock Report</label>
                                    </li>


                                    <li>
                                        <input type="checkbox"
                                               name="reports.product_report" {{ $global_settings->free_reports_product_report??false?'checked':''}}/>
                                        <label>Product Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.customer_report" {{ $global_settings->free_reports_customer_report??false?'checked':''}}/>
                                        <label>Customer Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.vendor_report" {{ $global_settings->free_reports_vendor_report??false?'checked':''}}/>
                                        <label>Vendor Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.customer_statement" {{ $global_settings->free_reports_customer_statement??false?'checked':''}}/>
                                        <label>Customer Statement</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.vendor_statement" {{ $global_settings->free_reports_vendor_statement??false?'checked':''}}/>
                                        <label>Vendor Statement</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.sales_report" {{ $global_settings->free_reports_sales_report??false?'checked':''}}/>
                                        <label>Sales Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.sales_report_details" {{ $global_settings->free_reports_sales_report_details??false?'checked':''}}/>
                                        <label>Sales Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.purchase_report" {{ $global_settings->free_reports_purchase_report??false?'checked':''}}/>
                                        <label>Purchase Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.purchase_report_details" {{ $global_settings->free_reports_purchase_report_details??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.due_collection" {{ $global_settings->free_reports_due_collection??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.due_payment" {{ $global_settings->free_reports_due_payment??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>

                <ul class="checkbox-tree root row">
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_pos_sales_viewAny??false?'checked':''}}/>
                        <label>Pos Sales</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.viewAny" {{ $global_settings->free_pos_sales_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.view" {{ $global_settings->free_pos_sales_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.create" {{ $global_settings->free_pos_sales_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.update" {{ $global_settings->free_pos_sales_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.delete" {{ $global_settings->free_pos_sales_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.print_barcode" {{ $global_settings->free_pos_sales_print_barcode??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_products_viewAny??false?'checked':''}}/>
                        <label>Product</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="products.viewAny" {{ $global_settings->free_products_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.view" {{ $global_settings->free_products_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.create" {{ $global_settings->free_products_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.update" {{ $global_settings->free_products_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.delete" {{ $global_settings->free_products_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.print_barcode" {{ $global_settings->free_products_print_barcode??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_customers_viewAny??false?'checked':''}}/>
                        <label>Customers</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="customers.viewAny" {{ $global_settings->free_customers_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.view" {{ $global_settings->free_customers_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.create" {{ $global_settings->free_customers_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.update" {{ $global_settings->free_customers_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.delete" {{ $global_settings->free_customers_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.advance_payment" {{ $global_settings->free_customers_advance_payment??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_vendors_viewAny??false?'checked':''}}/>
                        <label>Vendors</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="vendors.viewAny" {{ $global_settings->free_vendors_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.view" {{ $global_settings->free_vendors_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.create" {{ $global_settings->free_vendors_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.update" {{ $global_settings->free_vendors_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.delete" {{ $global_settings->free_vendors_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.advance_payment" {{ $global_settings->free_vendors_advance_payment??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_sales_return_viewAny??false?'checked':''}}/>
                        <label>Sales Return</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="sales_return.viewAny" {{ $global_settings->free_sales_return_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.view" {{ $global_settings->free_sales_return_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.create" {{ $global_settings->free_sales_return_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.update" {{ $global_settings->free_sales_return_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.delete" {{ $global_settings->free_sales_return_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_productions_viewAny??false?'checked':''}}/>
                        <label>Production</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="productions.viewAny" {{ $global_settings->free_productions_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.view" {{ $global_settings->free_productions_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.create" {{ $global_settings->free_productions_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.update" {{ $global_settings->free_productions_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.delete" {{ $global_settings->free_productions_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_stock_entries_viewAny??false?'checked':''}}/>
                        <label>Stock Entry</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.viewAny" {{ $global_settings->free_stock_entries_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.view" {{ $global_settings->free_stock_entries_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.create" {{ $global_settings->free_stock_entries_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.update" {{ $global_settings->free_stock_entries_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.delete" {{ $global_settings->free_stock_entries_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_users_viewAny??false?'checked':''}}/>
                        <label>Multi User</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="users.viewAny" {{ $global_settings->free_users_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.view" {{ $global_settings->free_users_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.create" {{ $global_settings->free_users_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.update" {{ $global_settings->free_users_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.delete" {{ $global_settings->free_users_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->free_user_roles_viewAny??false?'checked':''}}/>
                        <label> User Roles</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="user_roles.viewAny" {{ $global_settings->free_user_roles_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.view" {{ $global_settings->free_user_roles_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.create" {{ $global_settings->free_user_roles_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.update" {{ $global_settings->free_user_roles_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.delete" {{ $global_settings->free_user_roles_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">

                        <label> <input type="checkbox"
                                       name="customers.receive_payment" {{ $global_settings->free_customers_receive_payment??false?'checked':''}}/>
                            Receive Payment</label>

                    </li>
                    <li class="col-3">
                        <label>
                            <input type="checkbox"
                                   name="vendors.bill_payment" {{ $global_settings->free_vendors_bill_payment??false?'checked':''}}/>
                            Bill Payment</label>

                    </li>


                </ul>


                <button class="btn btn-primary btn-sm float-right ">Save Settings</button>
            </form>

        </div>


    </div>
    <hr>
    {{-- Basic Plan --}}
    <div class="card">
        <div class="card-header">
            Basic Plan
        </div>
        <div class="card-body">
            <form action="{{ route('master.subscriptions.basic_plan') }}" method="post" class="well">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <ul class="checkbox-tree root">
                            <li>
                                <input type="checkbox"/>
                                <label> <b>Invoices/Sale</b></label>
                                <ul class="manu ">
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.viewAny" {{ $global_settings->basic_invoices_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.view" {{ $global_settings->basic_invoices_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.create" {{ $global_settings->basic_invoices_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.update" {{ $global_settings->basic_invoices_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.delete" {{ $global_settings->basic_invoices_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.share"{{ $global_settings->basic_invoices_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.email"{{ $global_settings->basic_invoices_email??false?'checked':''}}/>
                                        <label>Email</label>
                                    </li>
                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Estimates/Quotation</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.viewAny" {{ $global_settings->basic_estimates_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.view" {{ $global_settings->basic_estimates_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.create" {{ $global_settings->basic_estimates_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.update" {{ $global_settings->basic_estimates_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.delete" {{ $global_settings->basic_estimates_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.share" {{ $global_settings->basic_estimates_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Bills/Purchase</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="bills.viewAny" {{ $global_settings->basic_bills_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.view" {{ $global_settings->basic_bills_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.create" {{ $global_settings->basic_bills_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.update" {{ $global_settings->basic_bills_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.delete" {{ $global_settings->basic_bills_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.share" {{ $global_settings->basic_bills_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Expenses</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.viewAny" {{ $global_settings->basic_expenses_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.view" {{ $global_settings->basic_expenses_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.create" {{ $global_settings->basic_expenses_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.update" {{ $global_settings->basic_expenses_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.delete" {{ $global_settings->basic_expenses_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Stock Adjustment</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.viewAny" {{ $global_settings->basic_inventory_adjustment_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.view" {{ $global_settings->basic_inventory_adjustment_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.create" {{ $global_settings->basic_inventory_adjustment_create??false?'checked':''}} />
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.update" {{ $global_settings->basic_inventory_adjustment_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.delete" {{ $global_settings->basic_inventory_adjustment_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="col">
                        <ul class="checkbox-tree root ">
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Accounts/Ledger</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.viewAny" {{ $global_settings->basic_ledgers_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.view" {{ $global_settings->basic_ledgers_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.create" {{ $global_settings->basic_ledgers_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.update" {{ $global_settings->basic_ledgers_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.delete" {{ $global_settings->basic_ledgers_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Account Group</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.viewAny" {{ $global_settings->basic_ledger_groups_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.view" {{ $global_settings->basic_ledger_groups_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.create" {{ $global_settings->basic_ledger_groups_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.update" {{ $global_settings->basic_ledger_groups_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.delete" {{ $global_settings->basic_ledger_groups_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Branches</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="branches.viewAny" {{ $global_settings->basic_branches_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.view" {{ $global_settings->basic_branches_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.create" {{ $global_settings->basic_branches_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.update" {{ $global_settings->basic_branches_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.delete" {{ $global_settings->basic_branches_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>


                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Vouchers</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.payment" {{ $global_settings->basic_vouchers_payment??false?'checked':''}}/>
                                        <label>Payment (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.receipt" {{ $global_settings->basic_vouchers_receipt??false?'checked':''}}/>
                                        <label>Receipt (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.journal" {{ $global_settings->basic_vouchers_journal??false?'checked':''}}/>
                                        <label>Journal (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.contra" {{ $global_settings->basic_vouchers_contra??false?'checked':''}}/>
                                        <label>Contra (CRUD)</label>
                                    </li>


                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Reports</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="reports.tax_summary" {{ $global_settings->basic_reports_tax_summary??false?'checked':''}}/>
                                        <label>Tax Summary</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ar_aging" {{ $global_settings->basic_reports_ar_aging??false?'checked':''}}/>
                                        <label>AR Aging</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ap_aging" {{ $global_settings->basic_reports_ap_aging??false?'checked':''}}/>
                                        <label>AP Aging</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.trial_balance" {{ $global_settings->basic_reports_trial_balance??false?'checked':''}}/>
                                        <label>Trial Balance</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.receipt_payment" {{ $global_settings->basic_reports_receipt_payment??false?'checked':''}}/>
                                        <label>Receipt Payment</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ledger" {{ $global_settings->basic_reports_ledger??false?'checked':''}}/>
                                        <label>Ledger</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.profit_loss" {{ $global_settings->basic_reports_profit_loss??false?'checked':''}}/>
                                        <label>Profit Loss</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.voucher" {{ $global_settings->basic_reports_voucher??false?'checked':''}}/>
                                        <label>Voucher</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.cash_book" {{ $global_settings->basic_reports_cash_book??false?'checked':''}}/>
                                        <label>Cash Book</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.day_book" {{ $global_settings->basic_reports_day_book??false?'checked':''}}/>
                                        <label>Day Book</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.balance_sheet" {{ $global_settings->basic_reports_balance_sheet??false?'checked':''}}/>
                                        <label>Balance Sheet</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.stock_report" {{ $global_settings->basic_reports_stock_report??false?'checked':''}}/>
                                        <label>Stock Report</label>
                                    </li>


                                    <li>
                                        <input type="checkbox"
                                               name="reports.product_report" {{ $global_settings->basic_reports_product_report??false?'checked':''}}/>
                                        <label>Product Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.customer_report" {{ $global_settings->basic_reports_customer_report??false?'checked':''}}/>
                                        <label>Customer Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.vendor_report" {{ $global_settings->basic_reports_vendor_report??false?'checked':''}}/>
                                        <label>Vendor Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.customer_statement" {{ $global_settings->basic_reports_customer_statement??false?'checked':''}}/>
                                        <label>Customer Statement</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.vendor_statement" {{ $global_settings->basic_reports_vendor_statement??false?'checked':''}}/>
                                        <label>Vendor Statement</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.sales_report" {{ $global_settings->basic_reports_sales_report??false?'checked':''}}/>
                                        <label>Sales Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.sales_report_details" {{ $global_settings->basic_reports_sales_report_details??false?'checked':''}}/>
                                        <label>Sales Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.purchase_report" {{ $global_settings->basic_reports_purchase_report??false?'checked':''}}/>
                                        <label>Purchase Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.purchase_report_details" {{ $global_settings->basic_reports_purchase_report_details??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.due_collection" {{ $global_settings->basic_reports_due_collection??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.due_payment" {{ $global_settings->basic_reports_due_payment??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>

                <ul class="checkbox-tree root row">
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_pos_sales_viewAny??false?'checked':''}}/>
                        <label>Pos Sales</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.viewAny" {{ $global_settings->basic_pos_sales_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.view" {{ $global_settings->basic_pos_sales_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.create" {{ $global_settings->basic_pos_sales_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.update" {{ $global_settings->basic_pos_sales_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.delete" {{ $global_settings->basic_pos_sales_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.print_barcode" {{ $global_settings->basic_pos_sales_print_barcode??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_products_viewAny??false?'checked':''}}/>
                        <label>Product</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="products.viewAny" {{ $global_settings->basic_products_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.view" {{ $global_settings->basic_products_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.create" {{ $global_settings->basic_products_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.update" {{ $global_settings->basic_products_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.delete" {{ $global_settings->basic_products_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.print_barcode" {{ $global_settings->basic_products_print_barcode??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_customers_viewAny??false?'checked':''}}/>
                        <label>Customers</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="customers.viewAny" {{ $global_settings->basic_customers_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.view" {{ $global_settings->basic_customers_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.create" {{ $global_settings->basic_customers_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.update" {{ $global_settings->basic_customers_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.delete" {{ $global_settings->basic_customers_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.advance_payment" {{ $global_settings->basic_customers_advance_payment??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_vendors_viewAny??false?'checked':''}}/>
                        <label>Vendors</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="vendors.viewAny" {{ $global_settings->basic_vendors_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.view" {{ $global_settings->basic_vendors_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.create" {{ $global_settings->basic_vendors_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.update" {{ $global_settings->basic_vendors_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.delete" {{ $global_settings->basic_vendors_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.advance_payment" {{ $global_settings->basic_vendors_advance_payment??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_sales_return_viewAny??false?'checked':''}}/>
                        <label>Sales Return</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="sales_return.viewAny" {{ $global_settings->basic_sales_return_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.view" {{ $global_settings->basic_sales_return_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.create" {{ $global_settings->basic_sales_return_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.update" {{ $global_settings->basic_sales_return_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.delete" {{ $global_settings->basic_sales_return_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_productions_viewAny??false?'checked':''}}/>
                        <label>Production</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="productions.viewAny" {{ $global_settings->basic_productions_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.view" {{ $global_settings->basic_productions_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.create" {{ $global_settings->basic_productions_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.update" {{ $global_settings->basic_productions_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.delete" {{ $global_settings->basic_productions_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_stock_entries_viewAny??false?'checked':''}}/>
                        <label>Stock Entry</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.viewAny" {{ $global_settings->basic_stock_entries_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.view" {{ $global_settings->basic_stock_entries_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.create" {{ $global_settings->basic_stock_entries_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.update" {{ $global_settings->basic_stock_entries_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.delete" {{ $global_settings->basic_stock_entries_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_users_viewAny??false?'checked':''}}/>
                        <label>Multi User</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="users.viewAny" {{ $global_settings->basic_users_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.view" {{ $global_settings->basic_users_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.create" {{ $global_settings->basic_users_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.update" {{ $global_settings->basic_users_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.delete" {{ $global_settings->basic_users_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->basic_user_roles_viewAny??false?'checked':''}}/>
                        <label> User Roles</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="user_roles.viewAny" {{ $global_settings->basic_user_roles_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.view" {{ $global_settings->basic_user_roles_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.create" {{ $global_settings->basic_user_roles_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.update" {{ $global_settings->basic_user_roles_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.delete" {{ $global_settings->basic_user_roles_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">

                        <label> <input type="checkbox"
                                       name="customers.receive_payment" {{ $global_settings->basic_customers_receive_payment??false?'checked':''}}/>
                            Receive Payment</label>

                    </li>
                    <li class="col-3">
                        <label>
                            <input type="checkbox"
                                   name="vendors.bill_payment" {{ $global_settings->basic_vendors_bill_payment??false?'checked':''}}/>
                            Bill Payment</label>

                    </li>


                </ul>


                <button class="btn btn-primary btn-sm float-right ">Save Settings</button>
            </form>
        </div>
    </div>
    <hr>
    {{-- Premium Plan --}}
    <div class="card">
        <div class="card-header">
            Premium Plan
        </div>
        <div class="card-body">
            <form action="{{ route('master.subscriptions.premium_plan') }}" method="post" class="well">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <ul class="checkbox-tree root">
                            <li>
                                <input type="checkbox"/>
                                <label> <b>Invoices/Sale</b></label>
                                <ul class="manu ">
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.viewAny" {{ $global_settings->premium_invoices_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.view" {{ $global_settings->premium_invoices_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.create" {{ $global_settings->premium_invoices_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.update" {{ $global_settings->premium_invoices_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.delete" {{ $global_settings->premium_invoices_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.share"{{ $global_settings->premium_invoices_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="invoices.email"{{ $global_settings->premium_invoices_email??false?'checked':''}}/>
                                        <label>Email</label>
                                    </li>
                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Estimates/Quotation</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.viewAny" {{ $global_settings->premium_estimates_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.view" {{ $global_settings->premium_estimates_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.create" {{ $global_settings->premium_estimates_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.update" {{ $global_settings->premium_estimates_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.delete" {{ $global_settings->premium_estimates_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="estimates.share" {{ $global_settings->premium_estimates_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Bills/Purchase</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="bills.viewAny" {{ $global_settings->premium_bills_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.view" {{ $global_settings->premium_bills_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.create" {{ $global_settings->premium_bills_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.update" {{ $global_settings->premium_bills_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.delete" {{ $global_settings->premium_bills_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="bills.share" {{ $global_settings->premium_bills_share??false?'checked':''}}/>
                                        <label>Share</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Expenses</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.viewAny" {{ $global_settings->premium_expenses_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.view" {{ $global_settings->premium_expenses_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.create" {{ $global_settings->premium_expenses_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.update" {{ $global_settings->premium_expenses_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="expenses.delete" {{ $global_settings->premium_expenses_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Stock Adjustment</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.viewAny" {{ $global_settings->premium_inventory_adjustment_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.view" {{ $global_settings->premium_inventory_adjustment_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.create" {{ $global_settings->premium_inventory_adjustment_create??false?'checked':''}} />
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.update" {{ $global_settings->premium_inventory_adjustment_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="inventory_adjustment.delete" {{ $global_settings->premium_inventory_adjustment_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="col">
                        <ul class="checkbox-tree root ">
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Accounts/Ledger</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.viewAny" {{ $global_settings->premium_ledgers_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.view" {{ $global_settings->premium_ledgers_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.create" {{ $global_settings->premium_ledgers_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.update" {{ $global_settings->premium_ledgers_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledgers.delete" {{ $global_settings->premium_ledgers_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>

                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox"/>
                                <label>Account Group</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.viewAny" {{ $global_settings->premium_ledger_groups_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.view" {{ $global_settings->premium_ledger_groups_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.create" {{ $global_settings->premium_ledger_groups_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.update" {{ $global_settings->premium_ledger_groups_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="ledger_groups.delete" {{ $global_settings->premium_ledger_groups_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>
                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Branches</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="branches.viewAny" {{ $global_settings->premium_branches_viewAny??false?'checked':''}}/>
                                        <label>Show List</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.view" {{ $global_settings->premium_branches_view??false?'checked':''}}/>
                                        <label>View Single</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.create" {{ $global_settings->premium_branches_create??false?'checked':''}}/>
                                        <label>Create</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.update" {{ $global_settings->premium_branches_update??false?'checked':''}}/>
                                        <label>Edit</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="branches.delete" {{ $global_settings->premium_branches_delete??false?'checked':''}}/>
                                        <label>Delete</label>
                                    </li>


                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Vouchers</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.payment" {{ $global_settings->premium_vouchers_payment??false?'checked':''}}/>
                                        <label>Payment (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.receipt" {{ $global_settings->premium_vouchers_receipt??false?'checked':''}}/>
                                        <label>Receipt (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.journal" {{ $global_settings->premium_vouchers_journal??false?'checked':''}}/>
                                        <label>Journal (CRUD)</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="vouchers.contra" {{ $global_settings->premium_vouchers_contra??false?'checked':''}}/>
                                        <label>Contra (CRUD)</label>
                                    </li>


                                </ul>
                            </li>
                            <li class="col">
                                <input type="checkbox" name=""/>
                                <label>Reports</label>
                                <ul class="manu">
                                    <li>
                                        <input type="checkbox"
                                               name="reports.tax_summary" {{ $global_settings->premium_reports_tax_summary??false?'checked':''}}/>
                                        <label>Tax Summary</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ar_aging" {{ $global_settings->premium_reports_ar_aging??false?'checked':''}}/>
                                        <label>AR Aging</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ap_aging" {{ $global_settings->premium_reports_ap_aging??false?'checked':''}}/>
                                        <label>AP Aging</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.trial_balance" {{ $global_settings->premium_reports_trial_balance??false?'checked':''}}/>
                                        <label>Trial Balance</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.receipt_payment" {{ $global_settings->premium_reports_receipt_payment??false?'checked':''}}/>
                                        <label>Receipt Payment</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.ledger" {{ $global_settings->premium_reports_ledger??false?'checked':''}}/>
                                        <label>Ledger</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.profit_loss" {{ $global_settings->premium_reports_profit_loss??false?'checked':''}}/>
                                        <label>Profit Loss</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.voucher" {{ $global_settings->premium_reports_voucher??false?'checked':''}}/>
                                        <label>Voucher</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.cash_book" {{ $global_settings->premium_reports_cash_book??false?'checked':''}}/>
                                        <label>Cash Book</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.day_book" {{ $global_settings->premium_reports_day_book??false?'checked':''}}/>
                                        <label>Day Book</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.balance_sheet" {{ $global_settings->premium_reports_balance_sheet??false?'checked':''}}/>
                                        <label>Balance Sheet</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.stock_report" {{ $global_settings->premium_reports_stock_report??false?'checked':''}}/>
                                        <label>Stock Report</label>
                                    </li>


                                    <li>
                                        <input type="checkbox"
                                               name="reports.product_report" {{ $global_settings->premium_reports_product_report??false?'checked':''}}/>
                                        <label>Product Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.customer_report" {{ $global_settings->premium_reports_customer_report??false?'checked':''}}/>
                                        <label>Customer Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.vendor_report" {{ $global_settings->premium_reports_vendor_report??false?'checked':''}}/>
                                        <label>Vendor Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.customer_statement" {{ $global_settings->premium_reports_customer_statement??false?'checked':''}}/>
                                        <label>Customer Statement</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.vendor_statement" {{ $global_settings->premium_reports_vendor_statement??false?'checked':''}}/>
                                        <label>Vendor Statement</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.sales_report" {{ $global_settings->premium_reports_sales_report??false?'checked':''}}/>
                                        <label>Sales Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.sales_report_details" {{ $global_settings->premium_reports_sales_report_details??false?'checked':''}}/>
                                        <label>Sales Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.purchase_report" {{ $global_settings->premium_reports_purchase_report??false?'checked':''}}/>
                                        <label>Purchase Report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.purchase_report_details" {{ $global_settings->premium_reports_purchase_report_details??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.due_collection" {{ $global_settings->premium_reports_due_collection??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                    <li>
                                        <input type="checkbox"
                                               name="reports.due_payment" {{ $global_settings->premium_reports_due_payment??false?'checked':''}}/>
                                        <label>Purchase Report Details</label>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>

                <ul class="checkbox-tree root row">
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_pos_sales_viewAny??false?'checked':''}}/>
                        <label>Pos Sales</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.viewAny" {{ $global_settings->premium_pos_sales_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.view" {{ $global_settings->premium_pos_sales_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.create" {{ $global_settings->premium_pos_sales_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.update" {{ $global_settings->premium_pos_sales_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.delete" {{ $global_settings->premium_pos_sales_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="pos_sales.print_barcode" {{ $global_settings->premium_pos_sales_print_barcode??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_products_viewAny??false?'checked':''}}/>
                        <label>Product</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="products.viewAny" {{ $global_settings->premium_products_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.view" {{ $global_settings->premium_products_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.create" {{ $global_settings->premium_products_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.update" {{ $global_settings->premium_products_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.delete" {{ $global_settings->premium_products_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="products.print_barcode" {{ $global_settings->premium_products_print_barcode??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_customers_viewAny??false?'checked':''}}/>
                        <label>Customers</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="customers.viewAny" {{ $global_settings->premium_customers_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.view" {{ $global_settings->premium_customers_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.create" {{ $global_settings->premium_customers_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.update" {{ $global_settings->premium_customers_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.delete" {{ $global_settings->premium_customers_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="customers.advance_payment" {{ $global_settings->premium_customers_advance_payment??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_vendors_viewAny??false?'checked':''}}/>
                        <label>Vendors</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="vendors.viewAny" {{ $global_settings->premium_vendors_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.view" {{ $global_settings->premium_vendors_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.create" {{ $global_settings->premium_vendors_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.update" {{ $global_settings->premium_vendors_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.delete" {{ $global_settings->premium_vendors_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="vendors.advance_payment" {{ $global_settings->premium_vendors_advance_payment??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>

                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_sales_return_viewAny??false?'checked':''}}/>
                        <label>Sales Return</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="sales_return.viewAny" {{ $global_settings->premium_sales_return_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.view" {{ $global_settings->premium_sales_return_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.create" {{ $global_settings->premium_sales_return_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.update" {{ $global_settings->premium_sales_return_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="sales_return.delete" {{ $global_settings->premium_sales_return_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_productions_viewAny??false?'checked':''}}/>
                        <label>Production</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="productions.viewAny" {{ $global_settings->premium_productions_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.view" {{ $global_settings->premium_productions_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.create" {{ $global_settings->premium_productions_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.update" {{ $global_settings->premium_productions_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="productions.delete" {{ $global_settings->premium_productions_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input
                            type="checkbox" {{ $global_settings->premium_stock_entries_viewAny??false?'checked':''}}/>
                        <label>Stock Entry</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.viewAny" {{ $global_settings->premium_stock_entries_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.view" {{ $global_settings->premium_stock_entries_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.create" {{ $global_settings->premium_stock_entries_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.update" {{ $global_settings->premium_stock_entries_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="stock_entries.delete" {{ $global_settings->premium_stock_entries_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_users_viewAny??false?'checked':''}}/>
                        <label>Multi User</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="users.viewAny" {{ $global_settings->premium_users_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.view" {{ $global_settings->premium_users_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.create" {{ $global_settings->premium_users_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.update" {{ $global_settings->premium_users_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="users.delete" {{ $global_settings->premium_users_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_user_roles_viewAny??false?'checked':''}}/>
                        <label> User Roles</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="user_roles.viewAny" {{ $global_settings->premium_user_roles_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.view" {{ $global_settings->premium_user_roles_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.create" {{ $global_settings->premium_user_roles_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.update" {{ $global_settings->premium_user_roles_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.delete" {{ $global_settings->premium_user_roles_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>
                    <li class="col-3">
                        <input type="checkbox" {{ $global_settings->premium_user_roles_viewAny??false?'checked':''}}/>
                        <label> Pos Sales</label>
                        <ul class="manu d-none">
                            <li>
                                <input type="checkbox"
                                       name="user_roles.viewAny" {{ $global_settings->premium_user_roles_viewAny??false?'checked':''}}/>
                                <label>Show List</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.view" {{ $global_settings->premium_user_roles_view??false?'checked':''}}/>
                                <label>View Single</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.create" {{ $global_settings->premium_user_roles_create??false?'checked':''}}/>
                                <label>Create</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.update" {{ $global_settings->premium_user_roles_update??false?'checked':''}}/>
                                <label>Edit</label>
                            </li>
                            <li>
                                <input type="checkbox"
                                       name="user_roles.delete" {{ $global_settings->premium_user_roles_delete??false?'checked':''}}/>
                                <label>Delete</label>
                            </li>


                        </ul>
                    </li>

                    <li class="col-3">

                        <label> <input type="checkbox"
                                       name="customers.receive_payment" {{ $global_settings->premium_customers_receive_payment??false?'checked':''}}/>
                            Receive Payment</label>

                    </li>
                    <li class="col-3">
                        <label>
                            <input type="checkbox"
                                   name="vendors.bill_payment" {{ $global_settings->premium_vendors_bill_payment??false?'checked':''}}/>
                            Bill Payment</label>

                    </li>


                </ul>


                <button class="btn btn-primary btn-sm float-right ">Save Settings</button>

            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript"
            src="https://raw.githack.com/kosmikko/bootstrap-checkbox-tree/master/js/bootstrap-checkbox-tree.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script>

    <script type="text/javascript">

        jQuery(document).ready(function () {
            var cbTree = $('.checkbox-tree').checkboxTree({
                checkChildren: true,
                singleBranchOpen: true,
                openBranches: ['.liverpool', '.chelsea']
            });
            $('#tree-expand').on('click', function (e) {
                cbTree.expandAll();
            });
            $('#tree-collapse').on('click', function (e) {
                cbTree.collapseAll();
            });
            $('#tree-default').on('click', function (e) {
                cbTree.defaultExpand();
            });
            $('#tree-select-all').on('click', function (e) {
                cbTree.checkAll();
            });
            $('#tree-deselect-all').on('click', function (e) {
                cbTree.uncheckAll();
            });
            $('.checkbox-tree').on('checkboxTicked', function (e) {
                var checkedCbs = $(e.currentTarget).find("input[type='checkbox']:checked");
                console.log('checkbox tick', checkedCbs.length);
            });
        });

    </script>
@endsection
