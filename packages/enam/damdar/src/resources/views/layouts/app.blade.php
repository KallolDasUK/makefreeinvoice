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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">

    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/perfect-scrollbar/perfect-scrollbar.css">
    <!-- end plugin css -->

    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/assets/plugins/icheck/skins/all.css">


    <!-- common css -->
    <link media="all" type="text/css" rel="stylesheet"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/css/app.css">
    <!-- end common css -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{--    <script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/jquery-form/form@4.3.0/dist/jquery.form.min.js"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link media="all" type="text/css" rel="stylesheet"
          href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css"/>


    @yield('css')
    @stack('css')

</head>

<body>

<div class="container-scroller">

    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row ">
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
                    <div class="container">
                        <ul class="mainnav">
                            <li class="{{ is_home(Route::current()->uri(),Route::currentRouteName()) }}"><a
                                    href="{{ route('acc.home') }}"><i
                                        class="fa fa-tachometer-alt"></i><span>Dashboard</span> </a></li>
                            <li class="dropdown subnavbar-open-center"><a href="javascript:;" class="dropdown-toggle"
                                                                          data-toggle="dropdown"><i
                                        class="fas fa-file-invoice-dollar"></i><span>My Invoices</span> </a>

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


    <script>
        $(document).ready(function () {

            $('.mainnav li').on('mouseover', function () {
                $('.mainnav li').removeClass('active')
                $(this).addClass('active')
                // console.log('Hovered', this)
            })
            Date.prototype.addDays = function (days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            }


        })
    </script>

    <!-- base js -->
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/ractive"></script>
    <script src="https://cdn.jsdelivr.net/npm/ractive-transitions-fade"></script>
    <script src="https://cdn.jsdelivr.net/npm/ractive-transitions-slide"></script>
    <script src="https://cdn.jsdelivr.net/npm/ractive-transitions-fly"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
            integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        Ractive.DEBUG = true;
        $.fn.select2.defaults.set("theme", "bootstrap");

    </script>
@yield('js')
@stack('js')

</body>

</html>
