<!DOCTYPE html>

<html>

<head>
    <title>{{ $title ?? env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/favicon.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- plugin css -->
    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/flag-icon-css/css/flag-icon.css">


    <script src="https://use.fontawesome.com/715fc6bd34.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    {{--
    <link media="all" type="text/css" rel="stylesheet"
        href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/@mdi/font/css/materialdesignicons.min.css">
    --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/materialicon.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/perfect-scrollbar/perfect-scrollbar.css">
    <!-- end plugin css -->

    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/icheck/skins/all.css">
    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/select2/css/select2.min.css">

    <!-- common css -->
    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/css/app.css">
    <!-- end common css -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link media="all" type="text/css" rel="stylesheet"
          href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">


    <!-- end plugin css -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
          integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether-drop/1.4.2/js/drop.min.js"
            integrity="sha512-Lvy+Fbz3bTkUx6BrU0hmCh/paXCkl0sWDE4JVASkehxQlUcQtzOJHin6dsR+zy+RYlMAy5wdY3mGyFTgENQaBA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('css')
    @stack('css')
    <livewire:styles/>
    <style>

        table.dataTable thead .sorting {
            background-image: none !important;
        }

        table.dataTable thead .sorting_asc {
            background-image: none !important;

        }


        div.dataTables_wrapper div.dataTables_length select {
            width: auto;
            display: inline-block;
            height: 25px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            height: 30px !important;
            background-color: transparent;
            margin-left: 3px;
        }


        table.dataTable.no-footer {
            border-bottom: 0px solid #111;
        }

        .select2-results__option[aria-selected=true] {
            display: none;
        }

        .select2-selection--multiple {
            overflow: hidden !important;
            height: auto !important;
        }

        .select2-selection__rendered {
            line-height: 42px !important;
        }

        .select2-container--open {
            z-index: 9999999
        }

        .select2-container .select2-selection--single {
            height: 42px !important;

            border: 1px solid rgba(151, 151, 151, 0.3) !important;
        }

        .select2-selection__arrow {
            height: 42px !important;
        }

        .scrollbar {
            margin-left: 30px;
            float: left;
            height: 300px;
            width: 65px;
            background: #fff;
            overflow-y: scroll;
            margin-bottom: 25px;
        }

        .force-overflow {
            min-height: 450px;
        }

        .scrollbar-primary::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .scrollbar-primary::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #4285F4;
        }

        .scrollbar-primary {
            scrollbar-color: #4285F4 #F5F5F5;
        }

        .scrollbar-danger::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        .scrollbar-danger::-webkit-scrollbar {
            width: 5px;
            background-color: #F5F5F5;
        }

        .scrollbar-danger::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #ff3547;
        }

        .scrollbar-danger {
            scrollbar-color: #ff3547 #F5F5F5;
        }

        .scrollbar-warning::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        .scrollbar-warning::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .scrollbar-warning::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #FF8800;
        }

        .scrollbar-warning {
            scrollbar-color: #FF8800 #F5F5F5;
        }

        .scrollbar-success::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        .scrollbar-success::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .scrollbar-success::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #00C851;
        }

        .scrollbar-success {
            scrollbar-color: #00C851 #F5F5F5;
        }

        .scrollbar-info::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        .scrollbar-info::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .scrollbar-info::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #33b5e5;
        }

        .scrollbar-info {
            scrollbar-color: #33b5e5 #F5F5F5;
        }

        .scrollbar-default::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        .scrollbar-default::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .scrollbar-default::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #2BBBAD;
        }

        .scrollbar-default {
            scrollbar-color: #2BBBAD #F5F5F5;
        }

        .scrollbar-secondary::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        .scrollbar-secondary::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .scrollbar-secondary::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #aa66cc;
        }

        .scrollbar-secondary {
            scrollbar-color: #aa66cc #F5F5F5;
        }

    </style>
</head>

<body>

<div class="container-scroller">

    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row ">
        <div class="text-center navbar-brand-wrapper d-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo text-success mt-4" href="{{ url('/') }}">

                <h2>{{ env('APP_NAME') }}</h2>
            </a>
            <a class="navbar-brand brand-logo-mini text-success" href="{{ url('/')  }}"><span
                    class="mdi mdi-arrow-left mr-2"></span></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <div class="subnavbar">
                <div class="subnavbar-inner">
                    <div class="container">
                        <ul class="mainnav">
                            <li class="{{ is_home(Route::current()->uri(),Route::currentRouteName()) }}"><a
                                    href="{{ route('acc.home') }}"><i
                                        class="fa fa-tachometer-alt"></i><span>Dashboard</span> </a></li>
                            <li><a href="reports.html"><i
                                        class="fas fa-file-invoice-dollar"></i><span>My Sales</span> </a></li>

                            <li class="dropdown subnavbar-open-center"><a href="javascript:;" class="dropdown-toggle"
                                                                          data-toggle="dropdown"> <i
                                        class="fa  fa-calculator"></i><span>Accounting</span> <b
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
                                                        class="fa fa-snowflake-o" aria-hidden="true"></i>Branches</a>
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
                                                    <a href="{{ route('accounting.report.trial-balance') }}">Trial
                                                        Balance</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accounting.report.receipt-payment-branch') }}">Receipt
                                                        & Payment </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accounting.report.profit-loss') }}">Profit &
                                                        Loss </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accounting.report.ledger') }}">Ledger</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accounting.report.voucher') }}">Voucher </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accounting.report.cashbook') }}">Cashbook</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accounting.report.daybook') }}">Daybook </a>
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
                                    href="{{ route('accounting.settings.edit') }}"><i class="fa fa-cog"></i><span>Settings</span>
                                </a></li>

                        </ul>
                    </div>
                    <!-- /container -->
                </div>
                <!-- /subnavbar-inner -->
            </div>


        </div>


    </nav>
    <div class="container-fluid page-body-wrapper">


        <nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled d-none" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-category">Accounting</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('acc.home') }}">
                        <span class="icon-bg"><i class="mdi mdi-home menu-icon"></i></span>
                        <span class="menu-title">Home</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#accountMaster"
                       aria-expanded="false"
                       aria-controls="accountMaster">
                        <span class="icon-bg"><i
                                class="mdi mdi-cart-plus menu-icon"></i></span>
                        <span class="menu-title">Master</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse " id="accountMaster">
                        <ul class="nav flex-column sub-menu ml-2">

                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('ledger_groups.ledger_group.create') }}">Ledger
                                    Group</a>
                            </li>
                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('ledgers.ledger.create') }}">Ledger</a>
                            </li>
                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link" href="{{ route('accounting.coa') }}">COA-
                                    Chart of Accounts</a>
                            </li>
                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('branches.branch.create') }}">Branches</a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#accountTransaction"
                       aria-expanded="false"
                       aria-controls="accountTransaction">
                     <span class="icon-bg"><i
                             class="mdi mdi-trackpad menu-icon"></i></span>
                        <span class="menu-title">Transaction </span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse " id="accountTransaction">
                        <ul class="nav flex-column sub-menu ml-2">

                            <li class="nav-item "><a
                                    class="nav-link"
                                    href="{{ route('transactions.transaction.create') }}">
                                    Receive </a>
                            </li>
                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('payments.payment.create') }}">
                                    Payment</a>
                            </li>
                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('journals.journal.create') }}">
                                    Journal</a>
                            </li>
                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('contras.contra.create') }}">
                                    Contra</a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#accountReport"
                       aria-expanded="false"
                       aria-controls="accountReport">
                         <span class="icon-bg"><i
                                 class="mdi mdi-paper-cut-vertical menu-icon"></i></span>
                        <span class="menu-title">Report</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse " id="accountReport">
                        <ul class="nav flex-column sub-menu ml-2">

                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.trial-balance') }}">
                                    Trial Balance Report</a>
                            </li>
                            <li class="nav-item " style="cursor: no-drop;"><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.receipt-payment-branch') }}">
                                    Receipt & Payment Report (Branch Wise)</a>
                            </li>
                            <li class="nav-item "><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.profit-loss') }}">
                                    Profit & Loss / Income Statement Report</a>
                            </li>
                            <li class="nav-item "><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.balance-sheet') }}">
                                    Balance Sheet Report</a>
                            </li>


                            <li class="nav-item "><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.ledger') }}">
                                    Ledger Report</a>
                            </li>
                            <li class="nav-item "><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.voucher') }}">
                                    Voucher Report </a>
                            </li>

                            <li class="nav-item "><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.cashbook') }}">
                                    Cash Book Report </a>
                            </li>
                            <li class="nav-item "><a
                                    class="nav-link"
                                    href="{{ route('accounting.report.daybook') }}">
                                    Day Book Report </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('accounting.settings.edit') }}">
                        <span class="icon-bg"><i class="mdi mdi-paper-cut-vertical menu-icon"></i></span>
                        <span class="menu-title">Settings</span>
                    </a>
                </li>


            </ul>
        </nav>


        <div class="p-4 main-panel">
            <b class="text-black font-weight-bold mb-2 mt-2"> {{ $title??'' }} </b>

            @yield('content')
            {{ $slot ?? '' }}

        </div>

    </div>


    <livewire:scripts/>

    <script>
        $(document).ready(function () {

            var url = window.location.href;     // Returns full URL (https://example.com/path/example.html)

            $('.nav-link').each(function (index, element) {
                let navLink = $(element).attr('href')
                if (url === navLink) {
                    let closetNavItem = $(element).closest('.nav-item');
                    closetNavItem.addClass('active')
                    let closetCollapsed = $(element).closest('.collapse');
                    closetCollapsed.addClass('show')
                    $(closetCollapsed).closest('div>ul').parent().addClass('show')

                }
            });
        })
    </script>

    <!-- base js -->
    <script src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/js/app.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/ractive"></script>
    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js">
    </script>
    <!-- end base js -->

    <!-- plugin js -->
    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/icheck/icheck.min.js">
    </script>
    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/select2/js/select2.min.js">
    </script>
    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/typeaheadjs/typeahead.bundle.min.js">
    </script>
    <!-- end plugin js -->

    <!-- common js -->
    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/off-canvas.js">
    </script>
    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/hoverable-collapse.js">
    </script>
    <script src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/misc.js">
    </script>
    <script src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/settings.js">
    </script>
    <script src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/todolist.js">
    </script>
    <!-- end common js -->

    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/file-upload.js">
    </script>
    <script src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/iCheck.js">
    </script>
    <script src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/select2.js">
    </script>
    <script
        src="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/js/typeahead.js">
    </script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/plugin.min.js') }}"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
        integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk="
        crossorigin="anonymous"></script>


    <script>
        Ractive.DEBUG = true;
        $(document).ready(function(){

        })

    </script>
@yield('js')
@stack('js')

</body>

</html>
