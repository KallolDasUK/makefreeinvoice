@extends('acc::layouts.app')

@section('css')
    <style>
        .eaBhby {
            width: 140px;
            height: 132px;
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


    </style>
@endsection
@section('content')

    <div>
        @if(!\App\Models\Invoice::query()->exists())

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

                            <img height="30px"
                                 style="transform: rotate(180deg); "
                                 src="https://my.freshbooks.com/assets/images/onboarding/arrow-left-8a0848d364cd87602821c18e77cea9ce.png"
                                 alt="Arrow">
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
                        <a href="{{ route('invoices.invoice.create') }}">
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

                        <img height="30px"
                             src="https://my.freshbooks.com/assets/images/onboarding/arrow-left-8a0848d364cd87602821c18e77cea9ce.png"
                             alt="Arrow">
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
                        PRODUCT SHORTCUTS
                    </div>
                    <a href="{{ route('products.product.create') }}"
                       style="position:relative;"
                       class="sc-gPEVay eaBhby border rounded @cannot('viewAny',\App\Models\InventoryAdjustment::class) pro-tag @endcannot">
                        <div class="sc-iRbamj image" style="background-image:url('images/plus.svg') ">

                        </div>
                        <div class="shortcuts-title  text-black mt-4">Add Products</div>
                    </a>
                    <a href="{{ route('products.product.index') }}"
                       style="position:relative;"
                       class="sc-gPEVay eaBhby border rounded">

                        <div class="sc-iRbamj image" style="background-image:url('images/list.svg') ">

                        </div>                        <div class="shortcuts-title  text-black  mt-4">My Products</div>
                    </a> <a href="{{ route('products.product.barcode') }}"
                       style="position:relative;"
                       class="sc-gPEVay eaBhby border rounded">

                        <div class="sc-iRbamj image" style="background-image:url('images/barcode.svg') ">

                        </div>                           <div class="shortcuts-title  text-black  mt-4">Print Barcode</div>
                    </a>

                </div>
            </div>
        <div class="row card mt-4" style="margin-top: 20px">
            <div class="card-body">
                <div class="font-weight-bolder">
                    INVOICE SHORTCUTS
                </div>
                <a href="{{ route('invoices.invoice.index') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded @cannot('viewAny',\App\Models\Invoice::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Invoices</div>
                </a>
                <a href="{{ route('customers.customer.create') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded @cannot('create',\App\Models\Invoice::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Add Customer</div>
                </a>
                <a class="sc-gPEVay eaBhby border rounded @cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                   style="position:relative;"
                   href="{{ route('invoices.invoice.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/invoice.svg') ">

                    </div>
                    <div class=" shortcuts-title sc-jlyJG gSoaLO">Add Invoice</div>
                </a>

                <a class="sc-gPEVay eaBhby border rounded @cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                   style="position:relative;"

                   href="{{ route('receive_payments.receive_payment.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/receive.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO">Receive Payment</div>
                </a>


                <a class="sc-gPEVay eaBhby  border rounded @cannot('create',\App\Models\Estimate::class) pro-tag @endcannot"
                   style="position:relative;"
                   href="{{ route('estimates.estimate.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO ">Add Estimate</div>
                </a>
                <a href="{{ route('estimates.estimate.index') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded @cannot('viewAny',\App\Models\Estimate::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Estimates</div>
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
                   class="sc-gPEVay eaBhby border rounded @cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image"
                         style="background-image:url('images/manage_invoice.svg'); ">

                    </div>
                    <div class="shortcuts-title text-black">My Bills</div>
                </a>

                <a class="sc-gPEVay eaBhby border rounded @cannot('create',\App\Models\Bill::class) pro-tag @endcannot"
                   href="{{ route('bills.bill.create') }}" style="position:relative;">
                    <div class="sc-iRbamj image" style="background-image:url('images/invoice.svg') ;">

                    </div>
                    <div class=" shortcuts-title sc-jlyJG gSoaLO">Add Bill</div>
                </a>
                <a href="{{ route('vendors.vendor.create') }}"
                   style="position:relative; "
                   class="sc-gPEVay eaBhby border rounded @cannot('create',\App\Models\Bill::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg');">

                    </div>
                    <div class="shortcuts-title  text-black">Add Vendors</div>
                </a>
                <a href="{{ route('bill_payments.bill_payment.create') }}"
                   style="position:relative; "
                   class="sc-gPEVay eaBhby border rounded @cannot('create',\App\Models\Bill::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/receive.svg');">

                    </div>
                    <div class="shortcuts-title  text-black">Pay Bill</div>
                </a>


                <a href="{{ route('expenses.expense.create') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded @cannot('create',\App\Models\Expense::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Add Expense</div>
                </a>
                <a href="{{ route('expenses.expense.index') }}"
                   style="position:relative;"

                   class="sc-gPEVay eaBhby border rounded @cannot('viewAny',\App\Models\Expense::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Expenses</div>
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
                   class="sc-gPEVay eaBhby border rounded @cannot('viewAny',\App\Models\InventoryAdjustment::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Adjustment</div>
                </a>
                <a href="{{ route('inventory_adjustments.inventory_adjustment.create') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded @cannot('viewAny',\App\Models\InventoryAdjustment::class) pro-tag @endcannot">
                    <div class="sc-iRbamj image" style="background-image:url('images/manage_invoice.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">Add Adjustment</div>
                </a>

                <a href="{{ route('productions.production.index') }}"
                   style="position:relative;"
                   class="sc-gPEVay eaBhby border rounded ">
                    <div class="sc-iRbamj image" style="background-image:url('images/factory.svg') ">

                    </div>
                    <div class="shortcuts-title  text-black">My Productions</div>
                </a>
            </div>
        </div>

        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    REPORT SHORTCUTS
                </div>

                <a class="sc-gPEVay eaBhby   @cannot('stock_report') pro-tag @endcannot"
                   href="{{ route('reports.report.stock-report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Stock Report</div>
                </a>

                <a class="sc-gPEVay eaBhby @cannot('tax_summary') pro-tag @endcannot"
                   href="{{ route('reports.report.tax_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Tax Summary</div>
                </a>
                <a class="sc-gPEVay eaBhby   @cannot('ar_aging') pro-tag @endcannot"
                   href="{{ route('reports.report.ar_aging_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Receivable Aging</div>
                </a>
                <a class="sc-gPEVay eaBhby  @cannot('ap_aging') pro-tag @endcannot"
                   href="{{ route('reports.report.ap_aging_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Payable Aging</div>
                </a>
                <a class="sc-gPEVay eaBhby  @cannot('ap_aging') pro-tag @endcannot"
                   href="{{ route('reports.report.loss_profit_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Profit & Loss</div>
                </a>
                <a class="sc-gPEVay eaBhby  @cannot('ap_aging') pro-tag @endcannot"
                   href="{{ route('reports.report.cashbook') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Cashbook</div>
                </a>
                <a class="sc-gPEVay eaBhby  "
                   href="{{ route('reports.report.product_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Product Report</div>
                </a> <a class="sc-gPEVay eaBhby  "
                        href="{{ route('reports.report.customer_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Customer Report</div>
                </a>
                <a class="sc-gPEVay eaBhby  "
                   href="{{ route('reports.report.vendor_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Vendor Report</div>
                </a>

                <a class="sc-gPEVay eaBhby"
                   style="position: relative"
                   href="{{ route('reports.report.customer_statement') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Customer Statement</div>
                </a>
                <a class="sc-gPEVay eaBhby"
                   style="position:relative;"
                   href="{{ route('reports.report.vendor_statement') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Vendor <br> Statement</div>
                </a>

                <a class="sc-gPEVay eaBhby"
                   style="position:relative;"
                   href="{{ route('reports.report.sales_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Sales <br> Report</div>
                </a> <a class="sc-gPEVay eaBhby"
                        style="position:relative;"
                        href="{{ route('reports.report.sales_report_details') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Sales <br> Report Details</div>
                </a>
                <a class="sc-gPEVay eaBhby"
                   style="position:relative;"
                   href="{{ route('reports.report.purchase_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Purchase <br> Report</div>
                </a>
                <a class="sc-gPEVay eaBhby"
                   style="position:relative;"
                   href="{{ route('reports.report.purchase_report_details') }}">
                    <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Purchase <br> Report Details</div>
                </a>
                <a class="sc-gPEVay eaBhby  "
                   href="{{ route('reports.report.due_collection_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Due Collection</div>
                </a> <a class="sc-gPEVay eaBhby  "
                        href="{{ route('reports.report.due_payment_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('{{ asset('images/estimate.svg') }}') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Due Payment</div>
                </a>

            </div>
        </div>
    </div>



@endsection

@section('js')
    <script src="{{ asset('js/subscriptions/subscribe.js') }}"></script>

    <script>
        $(document).ready(function () {

            // $('input').focus()
            $('.development').on('click', function () {
                swal.fire("Under Development!");
            })


        })
    </script>

@endsection
