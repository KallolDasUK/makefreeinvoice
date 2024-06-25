@extends('acc::layouts.app')

@section('css')
    <style>
        .eaBhby {
            width: 140px;
            min-height: 136px;
            margin: 18px 10px 5px;
            padding: 8px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            position: relative;
            display: inline-block;
            background-color: initial;
            border: none;
            font-size: inherit;
        }

        .divider {
            float: left;
            height: 132px;
            margin: 18px 10px 5px;
            float: left;
            padding: 8px;
            text-align: center;

        }

        .image {
            background-color: rgb(226, 231, 233);
            background-size: 80px;
            background-position: center center;
            background-repeat: no-repeat;
            width: 80px;
            height: 80px;
            margin: 0px auto 8px;
            border-radius: 50%;
            border: 2px solid rgb(212, 215, 220);
        }

        .eaBhby:hover, .eaBhby:focus, .eaBhby:active {
            background-color: rgb(236, 238, 241);
        }

        .shortcuts-title {
            color: black;
            font-weight: bolder;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
            grid-gap: 5px;
        }


    </style>
@endsection
@section('content')

    <div>
        @if(!$has_invoice)

            <div class="d-flex align-items-center justify-content-between " style="min-height: 200px;">
                <div style="max-width: 320px;min-width: 320px;">
                    <span class="text-primary"><b>WELCOME,</b></span>
                    <hr>
                    <h1 class="text-black"> {{ auth()->user()->name??'Anonymous' }}!</h1>
                </div>

                @if(!($settings->business_name??false))
                    <div class="d-flex flex-row align-items-center mr-4 ">
                        <div class="d-block mr-4">
                            <span class="d-block " style="text-align: center;font-size: 20px;">Settings</span>

{{--                            <img height="30px"--}}
{{--                                 style="transform: rotate(180deg); "--}}
{{--                                 src="https://my.freshbooks.com/assets/images/onboarding/arrow-left-8a0848d364cd87602821c18e77cea9ce.png"--}}
{{--                                 alt="Arrow">--}}
                        </div>
                        <div style="max-width: 100%;vertical-align: middle">
                            <a href="{{ route('accounting.settings.edit') }}">
                                <div class="m-auto  text-center d-flex"
                                     style="width: 200px;height: 150px;border: 2px dashed gray;cursor: pointer">

                    <span style="text-align: center;font-size: 20px;" data-link-to="link"
                          class="m-auto text-black ">
                        <div>
                            <span class="fa fa-cogs"></span>
                            Configuration
                        </div>
                    </span>

                                </div>

                            </a>
                        </div>

                    </div>
                @endif
                <div class="d-flex flex-row align-items-center  ">
                    <div style="max-width: 100%;vertical-align: middle">
                        <a href="{{ route('invoices.invoice.create') }} "
                           class="">
                            <div class="m-auto  text-center d-flex"
                                 style="width: 200px;height: 150px;border: 2px dashed gray;cursor: pointer">

                    <span style="text-align: center;font-size: 20px;" data-link-to="link"
                          class="m-auto text-black ">
                        <div>
                            <span class="fa fa-plus"></span>
                            New Invoice
                        </div>
                    </span>

                            </div>

                        </a>
                    </div>

                    <div class="text-start ml-4">

{{--                        <img height="30px"--}}
{{--                             src="https://my.freshbooks.com/assets/images/onboarding/arrow-left-8a0848d364cd87602821c18e77cea9ce.png"--}}
{{--                             alt="Arrow">--}}
                        <span class="d-block "
                              style="text-align: center;font-size: 20px;">Create your first invoice !</span>

                    </div>

                </div>


            </div>

        @endif

        <p class="clearfix"></p>
        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    QUICK SHORTCUTS
                </div>
                <div class="float-right">
                    <button class="btn btn-outline-info  font-weight-bolder" id="todays_report"><span
                            class="fa fa-file mr-2"></span> Today's Report
                    </button>
                    <a class="btn btn-outline-secondary text-primary btn-link font-weight-bolder"
                       href="{{ route('shortcuts.shortcut.index') }}"> <span class="fa fa-link mr-2"></span> Manage
                        Shortcuts</a>
                </div>
                <div class="clearfix"></div>
                <a href="{{ route('products.product.create') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::PRODUCT_CREATE) }}  @cannot('viewAny',\App\Models\Product::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/plus.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black mt-4">Add Products</div>
                </a>
                <a href="{{ route('products.product.index') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::PRODUCT_READ) }}  @cannot('viewAny',\App\Models\Product::class) pro-tag @endcannot">

                    <div class="sc-iRbamj image" style="background-image:url('images/list.svg') ">
                    </div>
                    <div class="shortcuts-title  text-black  mt-4">My Products</div>
                </a>
                <a href="{{ route('products.product.barcode') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::BARCODE_READ) }}  @cannot('print_barcode',\App\Models\Product::class) pro-tag @endcannot ">

                    <div class="sc-iRbamj image" style="background-image:url('images/barcode.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black  mt-4">Print Barcode</div>
                </a>

                @foreach($shortcuts as $shortcut)
                    <a href="{{ $shortcut->link }}"
                       target="_blank"
                       style="position:relative;"
                       class="sc-gPEVay eaBhby border rounded ">

                        <div class="sc-iRbamj image" style="background-image:url('images/link.svg') ">

                        </div>
                        <div class="shortcuts-title  text-black  mt-4">{{ $shortcut->name }}</div>
                    </a>
                @endforeach


            </div>
        </div>

        <div class="row card mt-4" style="margin-top: 20px">
            <div class="card-body">
                <div class="font-weight-bolder">
                    INVOICE SHORTCUTS
                </div>

                <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::INVOICE_CREATE) }} @cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                   style="position:relative;"
                   href="{{ route('invoices.invoice.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/invoice.svg') ">

                    </div>
                    <div class=" shortcuts-title sc-jlyJG gSoaLO">Add Invoice</div>
                </a>

                <a href="{{ route('invoices.invoice.index') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::INVOICE_READ) }} @cannot('viewAny',\App\Models\Invoice::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Invoices</div>
                </a>

                <a href="{{ route('customers.customer.create') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::CUSTOMER_CREATE) }} @cannot('create',\App\Models\Customer::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Add Customer</div>
                </a>

                <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::RECEIVE_PAYMENT_CREATE) }} @cannot('receive_payment',\App\Models\Customer::class) pro-tag @endcannot"
                   style="position:relative;"

                   href="{{ route('receive_payments.receive_payment.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/receive.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO">Receive Payment</div>
                </a>


                <a class="sc-gPEVay eaBhby  border rounded {{ ability_class(\App\Utils\Ability::ESTIMATE_CREATE) }} @cannot('create',\App\Models\Estimate::class) pro-tag @endcannot"
                   style="position:relative;"
                   href="{{ route('estimates.estimate.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO ">Add Proforma</div>
                </a>
                <a href="{{ route('estimates.estimate.index') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded  {{ ability_class(\App\Utils\Ability::ESTIMATE_READ) }} @cannot('viewAny',\App\Models\Estimate::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Proforma</div>
                </a>

            </div>
        </div>
        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    BILL SHORTCUTS
                </div>
                <a href="{{ route('bills.bill.index') }}"
                   style="position: relative"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::BILL_READ) }} @cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image"
                         style="background-image:url('images/manage_invoice.svg'); ">

                    </div>
                    <div class="shortcuts-title text-black">My Bills</div>
                </a>

                <a class="sc-gPEVay eaBhby border rounded  {{ ability_class(\App\Utils\Ability::BILL_CREATE) }} @cannot('create',\App\Models\Bill::class) pro-tag @endcannot"
                   href="{{ route('bills.bill.create') }}" style="position:relative;">
                    <div class="sc-iRbamj image" style="background-image:url('images/invoice.svg') ;">

                    </div>
                    <div class=" shortcuts-title sc-jlyJG gSoaLO">Add Bill</div>
                </a>
                <a href="{{ route('vendors.vendor.create') }}"
                   style="position:relative; "
                   class="sc-gPEVay eaBhby border rounded  {{ ability_class(\App\Utils\Ability::VENDOR_ADVANCE_CREATE) }} @cannot('create',\App\Models\Bill::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg');">

                    </div>
                    <div class="shortcuts-title  text-black">Add Vendors</div>
                </a>
                <a href="{{ route('bill_payments.bill_payment.create') }}"
                   style="position:relative; "
                   class="sc-gPEVay eaBhby border rounded  {{ ability_class(\App\Utils\Ability::PAY_BILL_CREATE) }} @cannot('bill_payment',\App\Models\Vendor::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/receive.svg');">

                    </div>
                    <div class="shortcuts-title  text-black">Pay Bill</div>
                </a>


                {{-- <a href="{{ route('expenses.expense.create') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::EXPENSE_CREATE) }} @cannot('create',\App\Models\Expense::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Add Expense</div>
                </a> --}}
                {{-- <a href="{{ route('expenses.expense.index') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::EXPENSE_READ) }} @cannot('viewAny',\App\Models\Expense::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Expenses</div>
                </a> --}}

            </div>
        </div>

        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    BANKING & EXPENDITURE SHORTCUTS
                </div>
                <a href="{{ route('accounting.settings.edit') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::GENERAL_SETTINGS_READ) }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/bank_account.svg'); background-size: unset !important">

                    </div>
                    <div class="shortcuts-title  text-black">Bank Accounts</div>
                </a>
                <a href="{{ route('accounting.settings.edit') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::GENERAL_SETTINGS_READ) }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/deposit.svg'); background-size: unset !important">

                    </div>
                    <div class="shortcuts-title  text-black">Bank Deposit</div>
                </a>
                <a href="{{ route('accounting.settings.edit') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::GENERAL_SETTINGS_READ) }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/transfer.svg'); background-size: unset !important">

                    </div>
                    <div class="shortcuts-title  text-black">Bank Withdraw</div>
                </a>
                <a href="{{ route('accounting.settings.edit') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::GENERAL_SETTINGS_READ) }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/withdraw.svg'); background-size: unset !important">

                    </div>
                    <div class="shortcuts-title  text-black">Bank Transfer</div>
                </a>
                <a href="{{ route('accounting.settings.edit') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::GENERAL_SETTINGS_READ) }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/my_expense.svg'); background-size: unset !important">

                    </div>
                    <div class="shortcuts-title  text-black">Add Expense</div>
                </a>
                <a href="{{ route('accounting.settings.edit') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::GENERAL_SETTINGS_READ) }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/expense3.svg'); background-size: unset !important">

                    </div>
                    <div class="shortcuts-title  text-black">My Expense</div>
                </a>
            </div>
        </div>

        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    ADJUSTMENT SHORTCUTS
                </div>
                <a href="{{ route('inventory_adjustments.inventory_adjustment.index') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::INVENTORY_ADJUSTMENT_READ) }} @cannot('viewAny',\App\Models\InventoryAdjustment::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Adjustment</div>
                </a>
                <a href="{{ route('inventory_adjustments.inventory_adjustment.create') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::INVENTORY_ADJUSTMENT_CREATE) }} @cannot('viewAny',\App\Models\InventoryAdjustment::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Add Adjustment</div>
                </a>

                <a href="{{ route('productions.production.index') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::PRODUCTION_READ) }}  @cannot('viewAny',\App\Models\Production::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/production.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Productions</div>
                </a>
                <a href="{{ route('stock_entries.stock_entry.create') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::STOCK_ENTRY_CREATE) }}  @cannot('viewAny',\App\Models\StockEntry::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/plus.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Stock Entry</div>
                </a>
                <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('product_report') pro-tag @endcannot"
                    href="{{ route('reports.report.product_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Stock Report</div>
                </a>
            </div>
        </div>

        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    SETTINGS SHORTCUTS
                </div>
                <a href="{{ route('accounting.settings.edit') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::GENERAL_SETTINGS_READ) }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/settings.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">General Settings</div>
                </a>
                <a href="{{ route('settings.update_password') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded ">
                    <div class="sc-iRbamj image" style="background-image:url('images/change.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Change Password</div>
                </a>

                <a href="{{ route('users.user.index') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::USER_READ) }}   @cannot('viewAny',\App\Models\User::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/users.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Users</div>
                </a>
                <a href="{{ route('user_roles.user_role.index') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::ROLE_READ) }}  @cannot('viewAny',\App\Models\UserRole::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/roles.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Roles</div>
                </a>
            </div>
        </div>
        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    REPORT SHORTCUTS
                </div>

                <div class="" style="display: flex; flex-wrap: wrap;">
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('stock_report') pro-tag @endcannot"
                       href="{{ route('reports.report.stock-report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Stock Report</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded   @cannot('stock_report') pro-tag @endcannot"
                       href="{{ route('reports.report.stock-report-details') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Stock Details</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('tax_summary') pro-tag @endcannot"
                       href="{{ route('reports.report.tax_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Tax Summary</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}   @cannot('ar_aging') pro-tag @endcannot"
                       href="{{ route('reports.report.ar_aging_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Receivable Aging</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('ap_aging') pro-tag @endcannot"
                       href="{{ route('reports.report.ap_aging_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Payable Aging</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}   @cannot('profit_loss') pro-tag @endcannot"
                       href="{{ route('reports.report.loss_profit_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Profit & Loss</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}   @cannot('cash_book') pro-tag @endcannot"
                       href="{{ route('reports.report.ledger_report',['ledger_id'=>\Enam\Acc\Models\Ledger::CASH_AC()]) }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Cashbook</div>
                    </a>
                     <a
                        class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }} @cannot('customer_report') pro-tag @endcannot"
                        href="{{ route('reports.report.customer_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Customer Report</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }} @cannot('vendor_report') pro-tag @endcannot"
                       href="{{ route('reports.report.vendor_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Vendor Report</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded justify-content-center {{ ability_class(\App\Utils\Ability::REPORT_READ) }} @cannot('customer_statement') pro-tag @endcannot"
                       style="position: relative"
                       href="{{ route('reports.report.customer_statement') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">C Statement</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('vendor_statement') pro-tag @endcannot"
                       style="position:relative;"
                       href="{{ route('reports.report.vendor_statement') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">V Statement</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}   @cannot('sales_report') pro-tag @endcannot"
                       style="position:relative;"
                       href="{{ route('reports.report.sales_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Sales Report</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('sales_report_details') pro-tag @endcannot"
                        style="position:relative;"
                        href="{{ route('reports.report.sales_report_details') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Sales <br> Report Details</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('purchase_report') pro-tag @endcannot"
                       style="position:relative;"
                       href="{{ route('reports.report.purchase_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Purchase <br> Report</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('purchase_report_details') pro-tag @endcannot"
                       style="position:relative;"
                       href="{{ route('reports.report.purchase_report_details') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Purchase <br> Report Details</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('due_collection') pro-tag @endcannot"
                       href="{{ route('reports.report.due_collection_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Due Collection</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}    @cannot('due_payment') pro-tag @endcannot"
                       href="{{ route('reports.report.due_payment_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Due Payment</div>
                    </a>
                     
                     <a class="sc-gPEVay eaBhby border rounded {{ ability_class(\App\Utils\Ability::REPORT_READ) }}  @cannot('ledger') pro-tag @endcannot"
                        href="{{ route('reports.report.ledger_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title" >Ledger Report</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded "
                       href="{{ route('reports.report.stock_alert') }}">
                        <div class="sc-iRbamj image"
                             style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Stock Alert</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded "
                       href="{{ route('reports.report.popular_products_report') }}">
                        <div class="sc-iRbamj image"
                             style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Most Popular Products</div>
                    </a>



                    <a class="sc-gPEVay eaBhby border rounded @cannot('receipt_payment') pro-tag @endcannot"
                       href="{{ route('reports.report.receipt_payment_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Receipt Payment</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded @cannot('ledger') pro-tag @endcannot "
                       style="display: none"
                       href="{{ route('reports.report.ledger_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Ledger Report</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded @cannot('voucher') pro-tag @endcannot"
                       style="display: none"
                       href="{{ route('reports.report.voucher_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Voucher Report</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded @cannot('balance_sheet') pro-tag @endcannot"
                       style="display: none"
                       href="{{ route('reports.report.balance_sheet_report') }}">
                        <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Balance Sheet</div>
                    </a>

                    <a class="sc-gPEVay eaBhby border rounded "
                       href="{{ route('reports.report.due_report') }}">
                        <div class="sc-iRbamj image"
                             style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Sales Due</div>
                    </a>
                    <a class="sc-gPEVay eaBhby border rounded "
                       href="{{ route('reports.report.purchase_due_report') }}">
                        <div class="sc-iRbamj image"
                             style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                        </div>
                        <div class="shortcuts-title sc-jlyJG gSoaLO title">Purchase Due</div>
                    </a>
                </div>
            </div>
        </div>
        

    </div>

    <div class="modal fade" id="todayReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="z-index: 99999;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="content px-2 py-0" id="content">

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script src="{{ asset('js/subscriptions/subscribe.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('.development').on('click', function () {
                swal.fire("Under Development!");
            })
            /* LOAD Today Report */
            $('#todays_report').on('click', function () {
                $('#todayReportModal').modal('show')
                $.ajax({
                    url: route('ajax.todayReport'),
                    type: 'get',
                    success: function (response) {
                        $('#content').html(response)
                    },

                });
            })


        })
    </script>

@endsection
