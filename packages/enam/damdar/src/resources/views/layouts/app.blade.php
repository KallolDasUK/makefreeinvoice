<!DOCTYPE html>

<html>

<head>
    <title>{{ $title ?? config('app.name')}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if($is_desktop)
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @else
        <meta name="viewport" content="width=1080px">
    @endif
    <link rel="shortcut icon"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/favicon.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- plugin css -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900'
          type='text/css'>
    @routes

    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-J35PC4G2SJ');
    </script>
    <script src="https://use.fontawesome.com/715fc6bd34.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/materialicon.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/css/style.bundle.css?v=7.2.8">
    <link media="all" type="text/css" rel="stylesheet"
          href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.css?v=7.2.8">

    {{--    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/bundle.min.css') }}">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">


    <!-- common css -->
    {{--    <link media="all" type="text/css" rel="stylesheet"--}}
    {{--          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/css/app.css">--}}
<!-- end common css -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js"--}}
    {{--            integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>--}}

    {{--    <script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link media="all" type="text/css" rel="stylesheet"
          href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css"/>
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css"/>
    <link href="https://ckeditor.com/docs/ckeditor5/latest/assets/snippet-styles.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}"/>
    @yield('css')
    @stack('css')

    <style>
        i:hover {
            color: white !important;
        }

        .select2-container--open {
            z-index: 9999999
        }

        i {
            color: inherit !important;
        }

        .center {
            text-align-last: center;
            border: 2px solid black;
        }

        .form-group {
            margin-bottom: 1.0rem;
        }

        label {
            font-weight: bolder !important;
        }

        input:focus {
            background-color: yellow !important;
        }

        .header-tabs {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
            height: 100px;
            -ms-flex-item-align: end !important;
            align-self: flex-end !important;
        }

        .header-tabs .nav-item {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            padding: 0;
            margin: 2px;
            position: relative;
            text-align: center;
        }


        .header-tabs .nav-item .nav-link {
            margin: 0;
            padding: 0.75rem 1.5rem;
            color: #ffffff;
            -webkit-transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, -webkit-box-shadow 0.15s ease;
            transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, -webkit-box-shadow 0.15s ease;
            transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
            transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease, -webkit-box-shadow 0.15s ease;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            background-color: #065a92;
            border-right: 1px solid #E4E6EF;
        }

        .header-tabs .nav-item .nav-link .nav-title {
            font-size: 1.25rem;
            color: #ffffff;
            font-weight: 600;
        }

        .nav-item .nav-link .nav-desc {
            font-size: 1rem;
            color: #ecebeb;
        }

        .header-tabs .dropdown-toggle::after {
            display: none !important;
        }

        .nav-link:hover {
            color: #065a92 !important;
            background-color: white !important;
            border: 1px solid #065a92;
        }


        .card {
        }

        .btn.btn-outline-primary {
            color: #065a92 !important;
            background-color: transparent !important;
            border-color: #065a92 !important;
        }

        .border-primary {

            border-color: #357294 !important;
        }

        .btn.btn-outline-primary:hover {
            background-color: #065a92 !important;
            color: white !important;
            border-color: #065a92 !important;
        }

        .btn.btn-primary {
            background-color: #065a92 !important;
            color: white !important;
            border-color: #065a92 !important;
        }

        .btn.btn-primary:hover {
            background-color: transparent !important;
            border-color: #065a92 !important;
            color: #065a92 !important;

        }

        .btn.btn-success {
            color: white !important;
            background-color: #065a92 !important;
            border-color: #065a92 !important;

        }

        .btn.btn-success:hover {
            background-color: transparent !important;
            color: #065a92 !important;
            border-color: #065a92 !important;
        }


        .btn.btn-info {
            color: white !important;
            background-color: #8950FC !important;
            border-color: #8950FC !important;

        }

        svg:hover {
            fill: #065a92;
        }

        .btn.btn-info:hover {
            background-color: transparent !important;
            color: #8950FC !important;
            border-color: #8950FC !important;
        }

        .rounded {
            border-color: #065a92a3 !important;
        }

        .vertical-divider::after {
            display: inline-block;
            content: "";
            height: 50px;
            border-right: 1px solid lightgrey;
            width: 1px;
        }

        .tooltip-inner {
            background-color: #065a92;
            color: white;
        }

        .tooltip.bs-tooltip-right .arrow:before {
            border-right-color: #065a92 !important;
        }

        .tooltip.bs-tooltip-left .arrow:before {
            border-left-color: #065a92 !important;
        }

        .tooltip.bs-tooltip-bottom .arrow:before {
            border-bottom-color: #065a92 !important;
        }

        .tooltip.bs-tooltip-top .arrow:before {
            border-top-color: #065a92 !important;
        }

        .form-control {
            border: 1px solid #065a926b !important;
        }

        .select2-selection {
            border: 1px solid #065a926b !important;
        }

        .pro-tag::before {
            content: "Pro";
            float: right;
            position: absolute;
            left: -5px;
            color: white;
            background: #8950fc;
            padding: 1px 5px;
            font-size: 10px;
            border-radius: 2px;
        }

        .new-tag::before {
            content: "New";
            float: right;
            position: absolute;
            left: -5px;
            color: white;
            background: #065a92;
            padding: 1px 5px;
            font-size: 10px;
            border-radius: 2px;
            -webkit-animation: BLINK 1s infinite; /* Safari 4+ */
            -moz-animation: BLINK 1s infinite; /* Fx 5+ */
            -o-animation: BLINK 1s infinite; /* Opera 12+ */
            animation: BLINK 1s infinite; /* IE 10+, Fx 29+ */
        }

        .pro-tag {
            cursor: no-drop;
            text-decoration: none;
            color: black;
        }


        @-webkit-keyframes BLINK {
            0%, 49% {
                background-color: #065a92;
            }
            50%, 100% {
                background-color: #e50000;
            }
        }

        .invoice-container[contenteditable=true]:hover {
            text-decoration: underline;
            text-decoration-style: dotted;
        }

        .dropdown-toggle:hover {
            color: #0d71bb !important;
        }

        svg:hover {
            color: #0d71bb !important;
        }

        .dropdown-toggle::before {
            content: "";

            border-right: 0em solid !important;

        }


    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J35PC4G2SJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-J35PC4G2SJ');
    </script>
</head>

<body class="">

<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="min-height: 400px">

            <div class="modal-body d-flex align-items-center justify-content-center" style="width: 100%;height: 100%"
                 id="modalContent">

                <img class="m-auto" style="text-align: center;height: 100%;"
                     src="https://cdn.website-editor.net/6c0e2b50d21d4c9eadf0308619dad381/dms3rep/multi/Geduld.gif"
                     alt="" width="100">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container">


    <ul class="header-tabs nav flex-column-auto mt-4" role="tablist">
        <!--begin::Item-->
        <li class="nav-item">
            <a href="{{ route('acc.home') }}" class="nav-link rounded">
                <span class="nav-title text-uppercase">Home</span>
                <span class="nav-desc">Dashboard &amp; Shortcuts</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="nav-item">
            <a href="#" class="nav-link dropdown-toggle rounded" data-toggle="dropdown">
                <span class="nav-title text-uppercase">Invoices</span>
                <span class="nav-desc">Sales &amp; Payments</span>
                <i class="fas fa-sort-down"></i>

            </a>
            <ul class="dropdown-menu">
                <div class="row m-0">

                    <div class="col" style="min-width: 500px">
                        <p class="text-info text--cap border-bottom d-inline-block">
                            Invoice Module</p>
                        <div class="menu-icon-grid font-weight-bolder p-0 ">
                            <a href="{{ route('invoices.invoice.create') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                New <br> Invoice</a>


                            <a href="{{ route('invoices.invoice.index') }}"
                               class="@cannot('viewAny',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i
                                    class="fa fa-list-alt" aria-hidden="true"></i>Manage <br>
                                Invoices</a>

                            <a href="{{ route('receive_payments.receive_payment.create') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;">
                                <i class="fa fa-money-bill" aria-hidden="true"></i>
                                Receive <br> Payment</a>

                            <a href="{{ route('products.product.index') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i class="fab fa-product-hunt"></i> Products
                            </a>

                            <a href="{{ route('categories.category.index') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i class="fab fa-product-hunt"></i>
                                Categories
                            </a>
                            <a href="{{ route('brands.brand.index') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i class="fab fa-product-hunt"></i>
                                Brands
                            </a>
                            <a href="{{ route('s_rs.s_r.index') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i
                                    class="fa fa-users" aria-hidden="true"></i>Sales Rep. (SR)</a>

                            <a href="{{ route('customers.customer.index') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i
                                    class="fa fa-users" aria-hidden="true"></i>Customers</a>

                            <a href="{{ route('sales_returns.sales_return.index') }}"
                               class=""
                               style="min-width: 100px;position:relative;"><i
                                    class="fa fa-list-alt" aria-hidden="true"></i>Sales <br>
                                Return</a>


                        </div>
                    </div>

                </div>
            </ul>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="nav-item">
            <a href="#" class="nav-link rounded dropdown-toggle" data-toggle="dropdown" data-target="#kt_header_tab_2"
               role="tab"
               aria-selected="false">
                <span class="nav-title text-uppercase">Bill</span>
                <span class="nav-desc">Purchase &amp; Pay</span>
                <i class="fas fa-sort-down"></i>
            </a>
            <ul class="dropdown-menu">
                <div class="row m-0">

                    <div class="col" style="min-width: 500px">
                        <p class="text-info text--cap border-bottom d-inline-block">
                            Bill/Purchase Module</p>
                        <div class="menu-icon-grid font-weight-bolder p-0">
                            <a href="{{ route('bills.bill.create') }}"
                               class="@cannot('create',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">

                                <i class="fa fa-plus" aria-hidden="true"></i>
                                New <br> Bill</a>
                            <a href="{{ route('bills.bill.index') }}"
                               class="@cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">
                                <i class="fa fa-list-alt ribbon" aria-hidden="true"></i>Manage <br>
                                Bills</a>

                            <a href="{{ route('purchase_orders.purchase_order.create') }}"
                               class="@cannot('create',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">

                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Purchase <br> Order</a>
                            <a href="{{ route('purchase_orders.purchase_order.index') }}"
                               class="@cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">
                                <i class="fa fa-list-alt ribbon" aria-hidden="true"></i>Manage <br>
                                Pur.. Order</a>

                            <a href="{{ route('bill_payments.bill_payment.create') }}"
                               class="@cannot('create',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">

                                <i class="fa fa-money-bill" aria-hidden="true"></i>
                                Pay <br> Bill</a>
                            <a href="{{ route('products.product.index') }}"
                               class="@cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">
                                <i class="fab fa-product-hunt"></i> Products
                            </a>
                            <a href="{{ route('categories.category.index') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i class="fab fa-product-hunt"></i>
                                Categories
                            </a>
                            <a href="{{ route('brands.brand.index') }}"
                               class="@cannot('create',\App\Models\Invoice::class) pro-tag @endcannot"
                               style="min-width: 100px;position:relative;"><i class="fab fa-product-hunt"></i>
                                Brands
                            </a>
                            <a href="{{ route('vendors.vendor.index') }}"
                               class="@cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">
                                <i class="fa fa-users" aria-hidden="true"></i>Vendors</a>

                            <a href="{{ route('vendor_advance_payments.vendor_advance_payment.index') }}"
                               class="@cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">
                                <i class="fa fa-money-bill-alt" aria-hidden="true"></i>Vendor Advance</a>


                            <a href="{{ route('purchase_returns.purchase_return.create') }}"
                               class=""
                               style="min-width: 100px;position: relative">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                New Purchase Ret..</a>
                            <a href="{{ route('purchase_returns.purchase_return.index') }}"
                               class="@cannot('viewAny',\App\Models\Bill::class) pro-tag @endcannot"
                               style="min-width: 100px;position: relative">
                                <i class="fa fa-list-alt ribbon" aria-hidden="true"></i>
                                Purchase Return</a>

                        </div>
                    </div>

                </div>
            </ul>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="nav-item">
            <a href="#" class="nav-link dropdown-toggle rounded" data-toggle="dropdown" data-target="#kt_header_tab_2"
               role="tab" aria-selected="false">
                <span class="nav-title text-uppercase">Accounting</span>
                <span class="nav-desc">Finance & Audit</span>
                <i class="fas fa-sort-down"></i>

            </a>
            <ul class="dropdown-menu">
                <div class="row m-0" style="width:500px">

                    <div class="col-md-12 p-4">
                        <p class="text-info text--cap border-bottom d-inline-block">
                            Master</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="{{ route('ledgers.ledger.index') }}">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                                Accounts</a>
                            <a href="{{ route('ledger_groups.ledger_group.index') }}"><i
                                    class="fa fa-users" aria-hidden="true"></i>Group</a>
                            <a href="{{ route('branches.branch.index') }}"><i
                                    class="fa fa-sitemap" aria-hidden="true"></i>Branches</a>
                            <a href="{{ route('accounting.coa') }}"><i class="fa fa-server"
                                                                       aria-hidden="true"></i>
                                COA</a>
                        </div>
                    </div>
                    <div class="col-md-12 p-4">
                        <p class="text-info text--cap border-bottom d-inline-block">
                            Transaction Vouchers</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="{{ route('payments.payment.index') }}"><i
                                    class="fab fa-amazon-pay"></i>Payment</a>
                            <a href="{{ route('transactions.transaction.index') }}"><i
                                    class="fab fa-get-pocket"></i>Receipt</a>
                            <a href="{{ route('journals.journal.index') }}"><i
                                    class="fas fa-journal-whills"></i>Journal</a>
                            <a href="{{ route('contras.contra.index') }}"><i
                                    class="fas fa-exchange-alt"></i>Contra</a>
                        </div>
                    </div>
                    <div class="col-md-12 p-4">
                        <p class="text-info border-bottom d-inline-block"
                           style="border-bottom:2px solid gray">
                            Reports</p>
                        <ul class="links">
                            <li>
                                <a href="{{ route('reports.report.trial_balance') }}">Trial
                                    Balance</a>
                            </li>
                            <li>
                                <a href="{{ route('reports.report.receipt_payment_report') }}">Receipt
                                    & Payment </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.report.loss_profit_report') }}">Profit &
                                    Loss </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.report.ledger_report') }}">Ledger</a>
                            </li>
                            <li>
                                <a href="{{ route('reports.report.voucher_report') }}">Voucher </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.report.cashbook') }}">Cashbook</a>
                            </li>

                            <li>
                                <a href="{{ route('reports.report.balance_sheet_report') }}">Balance
                                    Sheet </a>
                            </li>


                        </ul>
                    </div>
                </div>
            </ul>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="nav-item">
            <a href="{{ route('reports.report.index') }}" class="nav-link rounded">
                <span class="nav-title text-uppercase">Reports</span>
                <span class="nav-desc">Print, Send,  Save Reports</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('accounting.settings.edit') }}" class="nav-link rounded">
                <span class="nav-title text-uppercase">Settings</span>
                <span class="nav-desc">Customization &amp; Personalization</span>
            </a>
        </li>
        <!--end::Item-->
    </ul>
    <nav class=" header header-fixed " style="display: none">
        <div class="text-center navbar-brand-wrapper d-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo text-success mt-4" href="{{ url('/') }}">

                <h2>{{ env('APP_NAME') }}</h2>
            </a>
            <a class="navbar-brand brand-logo-mini text-success" href="{{ url('/')  }}"><span
                    class="mdi mdi-arrow-left mr-2"></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <div class="subnavbar">
                <div class="subnavbar-inner">
                    <div class="container" style="padding: 0px">
                        <ul class="mainnav">
                            <li class="{{ is_home(Route::current()->uri(),Route::currentRouteName()) }}"><a
                                    href="{{ route('acc.home') }}"><i
                                        class="fa fa-tachometer-alt" style="color: purple"></i><span
                                        style="color: purple">Dashboard</span> </a></li>
                            <li class="dropdown subnavbar-open-center"><a href="javascript:;" class="dropdown-toggle"
                                                                          data-toggle="dropdown"><i
                                        class="fas fa-file-invoice-dollar text-primary"></i><span class="text-primary">My Invoices</span>
                                </a>

                                <ul class="dropdown-menu">
                                    <div class="row m-0">

                                        <div class="col" style="min-width: 500px">
                                            <p class="text-info text--cap border-bottom d-inline-block">
                                                Invoice Module</p>
                                            <div class="menu-icon-grid font-weight-bolder p-0">
                                                <a href="{{ route('invoices.invoice.create') }}"
                                                   style="min-width: 100px">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    New <br> Invoice</a>
                                                <a href="{{ route('invoices.invoice.index') }}"
                                                   style="min-width: 100px"><i
                                                        class="fa fa-list-alt" aria-hidden="true"></i>Manage <br>
                                                    Invoices</a>

                                                <a href="{{ route('products.product.index') }}"
                                                   style="min-width: 100px"><i class="fab fa-product-hunt"></i> Products
                                                </a>

                                                <a href="{{ route('customers.customer.index') }}"
                                                   style="min-width: 100px"><i
                                                        class="fa fa-users" aria-hidden="true"></i>Customers</a>


                                            </div>
                                        </div>

                                    </div>
                                </ul>
                            </li>

                            <li class="dropdown subnavbar-open-center"><a href="javascript:;" class="dropdown-toggle"
                                                                          data-toggle="dropdown"> <i
                                        class="fa  fa-calculator text-info"></i><span
                                        class="text-info">Accounting</span> <b
                                        class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <div class="row m-0" style="width:1000px">

                                        <div class="col-md-4 p-4">
                                            <p class="text-info text--cap border-bottom d-inline-block">
                                                Master</p>
                                            <div class="menu-icon-grid w-auto p-0">
                                                <a href="{{ route('ledgers.ledger.index') }}">
                                                    <i class="fa fa-address-book" aria-hidden="true"></i>
                                                    Ledger</a>
                                                <a href="{{ route('ledger_groups.ledger_group.index') }}"><i
                                                        class="fa fa-users" aria-hidden="true"></i>Group</a>
                                                <a href="{{ route('branches.branch.index') }}"><i
                                                        class="fa fa-sitemap" aria-hidden="true"></i>Branches</a>
                                                <a href="{{ route('accounting.coa') }}"><i class="fa fa-server"
                                                                                           aria-hidden="true"></i>
                                                    COA</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-4">
                                            <p class="text-info text--cap border-bottom d-inline-block">
                                                Transaction Vouchers</p>
                                            <div class="menu-icon-grid w-auto p-0">
                                                <a href="{{ route('payments.payment.index') }}"><i
                                                        class="fab fa-amazon-pay"></i>Payment</a>
                                                <a href="{{ route('transactions.transaction.index') }}"><i
                                                        class="fab fa-get-pocket"></i>Receipt</a>
                                                <a href="{{ route('journals.journal.index') }}"><i
                                                        class="fas fa-journal-whills"></i>Journal</a>
                                                <a href="{{ route('contras.contra.index') }}"><i
                                                        class="fas fa-exchange-alt"></i>Contra</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-4">
                                            <p class="text-info border-bottom d-inline-block"
                                               style="border-bottom:2px solid gray">
                                                Reports</p>
                                            <ul class="links">
                                                <li>
                                                    <a href="{{ route('reports.report.trial_balance') }}">Trial
                                                        Balance</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('reports.report.receipt_payment_report') }}">Receipt
                                                        & Payment </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accounting.report.profit-loss') }}">Profit &
                                                        Loss </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('reports.report.ledger_report') }}">Ledger</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('reports.report.voucher_report') }}">Voucher </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('reports.report.cashbook') }}">Cashbook</a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('accounting.report.voucher') }}">Balance
                                                        Sheet </a>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </ul>
                            </li>

                            <li class="{{ is_settings(Route::current()->uri(),Route::currentRouteName()) }}"><a
                                    href="{{ route('accounting.settings.edit') }}"><i
                                        class="fa fa-cog" style="color: black"></i><span
                                        style="color: black">Settings</span>
                                </a></li>

                        </ul>
                    </div>
                    <!-- /container -->
                </div>
                <!-- /subnavbar-inner -->
            </div>


        </div>
    </nav>


    <div id="main" class="mt-4" style="min-height: 70vh">

        <div class="d-flex justify-content-between mb-2">
            <b class="text-black font-weight-bolder mb-2 mt-2" style="font-size: 20px">
                @if($title??'')
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"

                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 206.089 206.089" style="width: 30px"
                         fill="#065a92"
                         xml:space="preserve">
<path d="M142.236,166.897l-10.607-10.606l53.247-53.247l-53.247-53.247l10.607-10.606l63.853,63.853L142.236,166.897z
	 M163.663,103.044L123.32,62.702H0v80.686h123.32L163.663,103.044z"/>
                </svg>
                @endif
                {{ $title??'' }} </b>

            @if(!optional(auth()->user())->subscribed('default'))
                <div><p class="text-center">
                        <strong><a href="javascript:;"
                                   class="subscribeModal btn btn-sm btn-info">Upgrade to Pro</a> & unlock the
                            treasure</strong></p></div>
            @else
                <div class="">&nbsp;</div>
            @endif
            @if($country == "Bangladesh")
                <div class="text-center">For any help or enquiry please call at <h2>
                        <a href="tel:+8801680852026"><i class="fa fa-phone"></i> +88 016 8085 2026</a>
                    </h2>
                </div>
            @else
                <div class="">&nbsp;</div>

            @endif
            <div>

                @if(auth()->user()->role == 'master')
                    <a href="{{ route('master.users') }}"
                       class="btn btn-danger btn-lg font-weight-bolder font-size-sm " style="font-size: 16px">
                        <i class="fas fa-faucet" aria-hidden="true"></i>
                        </span>Admin Panel</a>
                @endif
                <a href="{{ route('pos_sales.pos_sale.create') }}"
                   class="btn btn-info btn-lg font-weight-bolder font-size-sm " style="font-size: 16px">
                    <i class="fas fa-cash-register" aria-hidden="true"></i>

                    </span>POS Sale</a>
            </div>

        </div>


        @yield('content')
        {{ $slot ?? '' }}

    </div>
    <div class=" card rounded mb-4 mt-4">
        <div class="row card-body">

            <div class="col">
                <div class="d-flex">
                    <div class="text-center text-sm-left  mb-sm-0 mr-4">
                        @if($settings->business_logo??false)
                            <img
                                class="rounded"
                                src="{{ asset('storage/'.$settings->business_logo) }}"
                                width="50"
                                alt="">
                        @endif
                    </div>
                    <div>
                        <h4>{{ optional(auth()->user())->name }}</h4>
                        @if(optional(auth()->user())->subscribed('default'))
                            <strong>{{ $settings->plan_name??'' }} ({{ $settings->plan_price??'' }}
                                / {{ $settings->plan_interval??'' }} <span
                                    class="subscribeModal text-primary">view details</span>)</strong>
                            <br>
                        @else

                            <strong> Free Plan <a class="font-weight-bolder subscribeModal" href="javascript:;">Upgrade
                                    Now</a>

                            </strong>
                            <br>


                        @endif
                        <strong class="mb-2">{{ optional(auth()->user())->email }}</strong>

                        <h5><a href="{{ route('accounting.settings.edit') }}"><i class="fa fa-cog"></i> Account Settings</a>
                        </h5>
                    </div>
                </div>

            </div>

            <div class="col text-right">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-outline-danger" onclick="return confirm('Confirm Logout??')"><i
                            class="fa fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>


    </div>


    <!-- Modal-->
    <div class="modal fade" id="proModal" tabindex="-1" role="dialog" aria-labelledby="proModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="proModal">Upgrade required</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    This is a pro feature. Upgrade to unlock the feature.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-primary font-weight-bold subscribeModal" data-dismiss="modal">
                        Upgrade Pro
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>

@include('partials.ajax-phone-number')
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#065a92",
                    "secondary": "#E5EAEE",
                    "success": "#065a92",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>


<!-- base js -->
<!-- JavaScript Bundle with Popper -->


<script src="https://cdn.jsdelivr.net/npm/ractive"></script>
<script src="https://cdn.jsdelivr.net/npm/ractive-transitions-fade"></script>
<script src="https://cdn.jsdelivr.net/npm/ractive-transitions-slide"></script>
<script src="https://cdn.jsdelivr.net/npm/ractive-transitions-fly"></script>


{{--<script src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.js?v=7.2.8"></script>--}}
<script
    src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/js/scripts.bundle.js?v=7.2.8"></script>


<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/jquery-form/form@4.3.0/dist/jquery.form.min.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"
        integrity="sha512-vCgNjt5lPWUyLz/tC5GbiUanXtLX1tlPXVFaX5KAQrUHjwPcCwwPOLn34YBFqws7a7+62h7FRvQ1T0i/yFqANA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css"
      integrity="sha512-rQESClU96g/m7xFESOEisIKXZapchOd6+HfUTaMzGXtBFfF837IDR0utlmq58hgoAqGUWQn9LeZbw2DtOgaWYg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {


        Date.prototype.addDays = function (days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }
        let settings = @json($settings);
        console.log(settings)
        if (!settings.phone) {
            $('#phoneModal').modal({backdrop: 'static', keyboard: false})

        }
        /* Creating Tax Via Ajax With Validation */
        $('#phoneForm').validate({
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    beforeSend: () => {
                        $('#storeTax').prop('disabled', true)
                        $('.spinner').removeClass('d-none')
                    },
                    success: function (response) {
                        $('#phoneModal').modal('hide');

                    },

                });
            },
            rules: {
                phone: {required: true},
            },
            messages: {
                phone: {required: "Please give your phone number",},
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });


    })
</script>
<script>
    Ractive.DEBUG = true;
    $.fn.select2.defaults.set("theme", "bootstrap");
    var csrf = $('meta[name=csrf-token]').attr('content');
    $(document).ready(function () {

        $('.nav-item').mouseenter(function () {
            $(this).find('.nav-title').css('color', '#065a92')
            $(this).find('.nav-desc').css('color', '#065a92')
            // $('#main').css("opacity","0.2")
        })
        $('.nav-item').mouseleave(function () {

            $(this).find('.nav-title').css('color', 'white')
            $(this).find('.nav-desc').css('color', 'white')
            // $('#main').css("opacity","1")


        })

        $('.subscribeModal').on('click', function (e) {
            $('#subscribeModal').modal('show')
            $.ajax({
                url: "{{ route('subscriptions.modal') }}",
                success: function (result) {

                    $("#modalContent").removeClass('d-flex align-items-center justify-content-center');
                    $("#modalContent").html(result);
                    $.getScript('https://js.stripe.com/v3/', function () {
                        $.getScript("{{ asset('js/subscriptions/subscribe.js') }}")
                    })

                }
            });
        })

        $('.pro-tag').attr('href', 'javascript:;')
        $('.pro-tag').on('click', function () {
            $('#proModal').modal('show')
        })

    })

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://raw.githack.com/jasonday/printThis/master/printThis.js"></script>

@yield('js')
@stack('js')

<script>
    function onReceiptPrint() {
        $('#blankModal').modal('hide')
        $('#printable').printThis()

    }

    function showCustomerPaymentReceipt(id) {
        $.ajax({
            accepts: {
                text: "application/json"
            },
            url: route('ajax.customerPaymentReceipt', id),
            type: "get",

            success: function (response) {
                $('#blankModal').modal('show')
                $('#content').html(response)
                // $('#printable').printThis()
            }
        });
    }

    $(document).ready(function () {
        $('.searchable').select2({placeholder: '-- Choose --', allowClear: true})


        $('.invoice-container[contenteditable=true]').tooltip({'title': 'Click to EDIT'});
        $('.invoice-container').hover(function () {

        });


    })
</script>
<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "108404041579131");
    chatbox.setAttribute("attribution", "biz_inbox");

    window.fbAsyncInit = function () {
        FB.init({
            xfbml: true,
            version: 'v11.0'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    $('#ledger_group_id').select2({dropdownParent: $("#ledgerModal")})
</script>

</body>

</html>
