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

        <div class="card">
            <div class="card-body" style="min-height: 500px">
                <div class="mx-auto" style="width: 50%">
                    <input type="text" id="search" placeholder="Search Reports" class="form-control text-center"
                           style="font-size: 25px">

                </div>

                <br>
                <h4 class="font-weight-bolder text-primary ml-4 p-4 rounded bg-secondary">General Reports</h4>
                <hr>
                <div class="clearfix"></div>
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
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Accounts Receivable Aging</div>
                </a>
                <a class="sc-gPEVay eaBhby  @cannot('ap_aging') pro-tag @endcannot"
                   href="{{ route('reports.report.ap_aging_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Accounts Payable Aging</div>
                </a>

                <div class="clearfix"></div>
                <br>
                <h4 class="font-weight-bolder text-primary ml-4 bg-secondary p-4 rounded">Accounting Report</h4>

                <div class="clearfix"></div>
                <a class="sc-gPEVay eaBhby @cannot('trial_balance') pro-tag @endcannot "
                   href="{{ route('reports.report.trial_balance') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Trial Balance</div>
                </a>
                <a class="sc-gPEVay eaBhby  @cannot('receipt_payment') pro-tag @endcannot"
                   href="{{ route('reports.report.receipt_payment_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Receipt Payment</div>
                </a>

                <a class="sc-gPEVay eaBhby  @cannot('ledger') pro-tag @endcannot"
                   href="{{ route('reports.report.ledger_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Ledger Report</div>
                </a>
                <a class="sc-gPEVay eaBhby  @cannot('profit_loss') pro-tag @endcannot"
                   href="{{ route('reports.report.loss_profit_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Profit Loss</div>
                </a>
                <a class="sc-gPEVay eaBhby @cannot('voucher') pro-tag @endcannot"
                   href="{{ route('reports.report.voucher_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Voucher Report</div>
                </a>

                <a class="sc-gPEVay eaBhby @cannot('cash_book') pro-tag @endcannot"
                   href="{{ route('reports.report.cashbook') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Cash Book</div>
                </a>

                <a class="sc-gPEVay eaBhby  @cannot('balance_sheet') pro-tag @endcannot"
                   href="{{ route('reports.report.balance_sheet_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Balance Sheet</div>
                </a><a class="sc-gPEVay eaBhby   @cannot('stock_report') pro-tag @endcannot"
                       href="{{ route('reports.report.stock-report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO title">Stock Report</div>
                </a>
            </div>

        </div>
    </div>

@endsection

@push('js')

    <script>

        $(document).ready(function () {
            $('#search').on('input', function () {
                let terms = $(this).val()
                let titles = $('.title').map(function (title) {
                    return $(this).text();
                }).toArray();
                let foundElement = titles.filter(item => item.toLowerCase().indexOf(terms) > -1);
                $('.title').each(function () {
                    $(this).parent('a').fadeOut(0)
                })
                for (let i = 0; i < foundElement.length; i++) {
                    var title = foundElement[i];
                    $(`div:contains('${title}')`).parent('a').fadeIn(50)
                }

            })
        })


    </script>
@endpush
