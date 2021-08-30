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
    <div class="" style="min-height: 100vh">

        @if(!\App\Models\Invoice::query()->exists())
            <div class="row mb-4" style="margin-bottom: 10px!important;">
                <div class="col ">
                    <div class="row" style="min-height: 100%;">
                        <div class="col-4">
                            <ul class="nav nav-tabs flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">
                                        <i class="fa fa-cog mr-4"></i>
                                        Business <i class="fa fa-check-circle ml-4 text-success"></i>
                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">
                                        <i class="fa fa-address-card mr-4"></i>
                                        Address <i class="fa fa-check-circle ml-4 text-secondary"></i>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="col-8 bg-white">
                            <div class="tab-content mt-5" id="myTabContent">
                                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel"
                                     aria-labelledby="kt_tab_pane_2">
                                    <div class="row">
                                        <div class="col-4">
                                            <div style="width: 80px;height: 80px">
                                                <div class="image-input image-input-outline" id="kt_image_1">
                                                    <div class="image-input-wrapper"
                                                         @if($settings->business_logo??false)
                                                         style="background-image: url({{ asset('storage/'.$settings->business_logo)}});width: 80px;height:80px;"></div>
                                                    @else
                                                        style="width: 80px;height:80px;background-image: url(
                                                        https://res.cloudinary.com/teepublic/image/private/s--lPknYmIq--/t_Resized%20Artwork/c_fit,g_north_west,h_954,w_954/co_000000,e_outline:48/co_000000,e_outline:inner_fill:48/co_ffffff,e_outline:48/co_ffffff,e_outline:inner_fill:48/co_bbbbbb,e_outline:3:1000/c_mpad,g_center,h_1260,w_1260/b_rgb:eeeeee/c_limit,f_auto,h_630,q_90,w_630/v1524123000/production/designs/2605867_0.jpg)">
                                                </div>
                                                @endif

                                                <label
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="change" data-toggle="tooltip" title=""
                                                    data-original-title="Change Logo">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="business_logo" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="profile_avatar_remove"/>
                                                </label>

                                                <span
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                  <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                 </span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col">

                                        <input type="text" class="form-control input-sm" placeholder="Business Name">
                                        <br>
                                        <input type="text" class="form-control input-sm" placeholder="Location">
                                        <br>
                                        <select class="input-sm form-control " id="currency" name="currency">
                                            <option value="" disabled selected> Currency</option>
                                            @foreach (currencies() as $currency)
                                                <option
                                                    value="{{ $currency['symbol'] }}" {{ ($settings->currency??'') == $currency['symbol'] ? 'selected' : '' }} >
                                                    {{ $currency['name'] ?? $currency['currencyname'] }}
                                                    - {{ $currency['symbol'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel"
                                 aria-labelledby="kt_tab_pane_2">


                            </div>

                        </div>
                    </div>
                </div>


            </div>
            <div class="col">
                <div class="d-flex align-items-center justify-content-center " style="min-height: 200px;">
                    <div style="min-width: 200px">
                        <span>Welcome,</span>
                        <h1 class="text-black"> {{ auth()->user()->name }}!</h1>
                    </div>
                    <div class="">
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
                    </div>
                    <div class="mx-4 d-none">
                        <img height="30px"
                             src="https://my.freshbooks.com/assets/images/onboarding/arrow-left-8a0848d364cd87602821c18e77cea9ce.png"
                             alt="Arrow">
                    </div>
                    <div class=" d-none">
                        <span style="text-align: center;font-size: 20px;">Create your first invoice!</span>
                    </div>

                </div>
            </div>
    </div>
    @endif

    <p class="clearfix"></p>
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
