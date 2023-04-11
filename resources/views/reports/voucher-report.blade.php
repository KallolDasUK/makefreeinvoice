@extends('acc::layouts.app')
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"
            integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>@endsection
@section('css')
    <style>
        .invoice-container {
            margin: 15px auto;
            padding: 20px;

            background-color: #fff;
            border: 1px solid #ccc;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            -o-border-radius: 6px;
            border-radius: 6px;
        }

        b, strong {
            font-weight: bolder;
        }

        .text-1 {
            font-size: 12px !important;
            font-size: 0.75rem !important;
        }

        .text-7 {
            font-size: 28px !important;
            font-size: 1.75rem !important;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #invoice-container, #invoice-container * {
                visibility: visible;
            }

            #invoice-container {
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
            }

            .tippy-tooltip.wv-popover-theme .wv-popover__content-wrapper {
                padding: 24px;
            }
        }
    </style>
@endsection
@section('content')

    <div class="">
        <div class="">
            @if(Session::has('success_message'))
                <div class="alert alert-success">
                    <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
                    {!! session('success_message') !!}

                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            @endif

            <div class="text-center">

                @if($settings->business_name??false)
                    <h3>{{ $settings->business_name }}</h3>
                    <p>{{ $settings->street_1 }} {{ $settings->street_2 }}, {{ $settings->city }}, {{ $settings->zip_post }}</p>
                    <p>{{ $settings->email }}, {{ $settings->phone }}</p>
                    {{--                        <h1>Accounts Payable Aging</h1>--}}
                    {{--                        <span>Date {{ today()->format('d M Y') }}</span>--}}
                    <a href="{{ $settings->website }}">{{ $settings->website }}</a>
                @endif
            </div>

        </div>


        <div class="card mb-2">
            <div class="card-body">
                <form action="{{ route('reports.report.voucher_report') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">
                        <div class="col-lg-3 col-xl-2">
                            <label for="voucher_type">Branch </label>
                            <select name="branch_id" class="form-control mr-2" title="Branch">
                                <option> All</option>
                                @foreach($branches as $id => $text)
                                    <option value="{{ $id }}"
                                            @if($id == $branch_id) selected @endif>{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 col-xl-2">
                            <label for="voucher_type">Voucher Type </label>
                            <select name="voucher_type" id="voucher_type" class="form-control form-control-select"
                                    required>
                                <option selected value="" disabled> Select Voucher Type</option>
                                <option
                                    value="{{ \Enam\Acc\Utils\VoucherType::$RECEIVE }}" {{ $voucher_type == \Enam\Acc\Utils\VoucherType::$RECEIVE?'selected':'' }}>{{ \Enam\Acc\Utils\VoucherType::$RECEIVE }}
                                </option>
                                <option
                                    value="{{ \Enam\Acc\Utils\VoucherType::$PAYMENT }}" {{ $voucher_type == \Enam\Acc\Utils\VoucherType::$PAYMENT?'selected':'' }}>{{ \Enam\Acc\Utils\VoucherType::$PAYMENT }}
                                </option>
                                <option
                                    value="{{ \Enam\Acc\Utils\VoucherType::$JOURNAL }}" {{ $voucher_type == \Enam\Acc\Utils\VoucherType::$JOURNAL?'selected':'' }}>{{ \Enam\Acc\Utils\VoucherType::$JOURNAL }}
                                </option>

                                <option
                                    value="{{ \Enam\Acc\Utils\VoucherType::$CONTRA }}" {{ $voucher_type == \Enam\Acc\Utils\VoucherType::$CONTRA?'selected':'' }}>{{ \Enam\Acc\Utils\VoucherType::$CONTRA }}
                                </option>
                                <option
                                    value="{{ \Enam\Acc\Utils\VoucherType::$CUSTOMER_PAYMENT }}" {{ $voucher_type == \Enam\Acc\Utils\VoucherType::$CUSTOMER_PAYMENT?'selected':'' }}>{{ \Enam\Acc\Utils\VoucherType::$CUSTOMER_PAYMENT }}
                                </option>
                                <option
                                    value="{{ \Enam\Acc\Utils\VoucherType::$VENDOR_PAYMENT }}" {{ $voucher_type == \Enam\Acc\Utils\VoucherType::$VENDOR_PAYMENT?'selected':'' }}>{{ \Enam\Acc\Utils\VoucherType::$VENDOR_PAYMENT }}
                                </option>

                            </select>

                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="input-daterange input-group" id="start_date">
                                    <input type="text" class="form-control col-2" name="start_date"
                                           value="{{ $start_date??'' }}"
                                           placeholder="Start">
                                    <div class="input-group-append">
									<span class="input-group-text">
										...
                                    </span>
                                    </div>
                                    <input type="text" class="form-control col-2" name="end_date" id="end_date"
                                           value="{{ $end_date??'' }}"

                                           placeholder="End">
                                    <button role="button" type="submit"
                                            class="btn btn-primary px-6 mx-2 col-3 font-weight-bold">
                                        <i class="fas fa-sliders-h"></i>
                                        Update Report
                                    </button>


                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        @include('reports.partials.print-download-export')


        <p class="clearfix"></p>
        <div id="invoice-container" class="container-fluid invoice-container @if($voucher_type == null) d-none @endif">

            <!-- Header -->
            <header>
                <div class="text-center">

                    @if($settings->business_name??false)
                        <h3>{{ $settings->business_name }}</h3>
                        <h1>Voucher Report</h1>
                        <h3> {{ $branch_id == 'All'?'All':optional(\Enam\Acc\Models\Branch::find($branch_id))->name }}
                            Branch </h3>
                        <span>{{ $voucher_type }}</span> <br>
                        <span>From {{ $start_date }} to {{ $end_date }}</span>
                    @endif
                </div>

                <hr>
            </header>

            <!-- Main Content -->
            <main>

                <hr>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="">

                            @if(count($records)>0)
                                <table class=" table mb-0  table-head-custom table-vertical-center ">
                                    <thead>

                                    <tr>
                                        <th>Date</th>
                                        <th>Voucher Number</th>
                                        <th>Particulars</th>
                                        <th style="text-align: center">Debit</th>
                                        <th style="text-align: center">Credit</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @php($cr=0)
                                    @php($dr=0)
                                    @foreach($records as $txn)
                                        <tr>
                                            <td></td>
                                            <td>{{ $txn->voucher_no }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
                                        @foreach($txn->transaction_details as $txnDetail)
                                            <tr>
                                                <td>{{ $txnDetail->date }}</td>
                                                <td></td>
                                                <td>{{ $txnDetail->ledger->ledger_name }}</td>

                                                @if($txnDetail->entry_type == \Enam\Acc\Utils\EntryType::$CR)
                                                    <td style="text-align: center">{{ decent_format_dash($txnDetail->amount) }}</td>
                                                    <td style="text-align: center">-</td>
                                                    @php($cr+=$txnDetail->amount)

                                                @else
                                                    <td style="text-align: center">-</td>
                                                    <td style="text-align: center">{{ decent_format_dash($txnDetail->amount) }}</td>
                                                    @php($dr+=$txnDetail->amount)

                                                @endif

                                            </tr>
                                        @endforeach
                                    @endforeach

                                    <tr style="font-weight: bolder;text-align: center">
                                        <td colspan="3" style="text-align: start">Grand Total</td>
                                        <td>{{ decent_format_dash($cr) }}</td>
                                        <td>{{ decent_format_dash($dr) }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center">
                                    <img style="text-align: center;margin: 0 auto;" src="https://1.bp.blogspot.com/-oFZuUJWkeVI/YU2wRxUt26I/AAAAAAAAFKw/tA92-qZCPksDCerRYqgANfzaeF8xtGTFQCLcBGAsYHQ/s320/norecord.png" alt="">

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
            <!-- Footer -->


        </div>


    </div>

@endsection

@push('js')

    <script>

        $('#printBtn').on('click', function () {
            window.print()
        })
        $('#downloadBtn').on('click', function () {
            var element = document.getElementById('invoice-container');
            let invoice_number = "TaxSummary"
            var opt = {
                filename: invoice_number + '.pdf',
                image: {type: 'jpeg', quality: 0.98},
                html2canvas: {scale: 2},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
            };
            html2pdf(element, opt);
        })
        var datepicker = $.fn.datepicker.noConflict();
        $.fn.bootstrapDP = datepicker;
        $("#start_date,#end_date").bootstrapDP({

            autoclose: true,
            format: "yyyy-mm-dd",
            immediateUpdates: true,
            todayBtn: true,
            todayHighlight: true,
            clearBtn: true

        });

        $('[data-toggle="popover"]').popover()


    </script>
@endpush
