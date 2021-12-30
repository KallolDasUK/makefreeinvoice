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


            </div>

        </div>


        <div class="card mb-2">
            <div class="card-body">
                <form action="{{ route('reports.report.loss_profit_report') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-2"></div>

                                <div class="input-daterange input-group" id="start_date">

                                    <select name="branch_id" class="col-2 form-control mr-2" title="Branch">
                                        <option> All</option>
                                        @foreach($branches as $id => $text)
                                            <option value="{{ $id }}"
                                                    @if($id == $branch_id) selected @endif>{{ $text }}</option>
                                        @endforeach
                                    </select>
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
        <div class="float-right">
            <div class="btn-group btn-group-lg float-right bg-white" role="group" aria-label="Large button group">
                <button id="printBtn" type="button" class="btn btn-outline-secondary">
                    <i class="fa fa-print text-danger"></i>
                    <b>Print Receipt</b>
                </button>
                <button id="downloadBtn" type="button" class="btn btn-outline-secondary">
                    <i class="fa fa-download text-primary"></i>

                    <b>Download</b>
                </button>
            </div>

        </div>

        <p class="clearfix"></p>
        <div id="invoice-container" class="container-fluid invoice-container">

            <!-- Header -->
            <header>
                <div class="text-center">

                    @if($settings->business_name??false)
                        <h3>{{ $settings->business_name }}</h3>
                        <h3> {{ $branch_id == 'All'?'All':optional(\Enam\Acc\Models\Branch::find($branch_id))->name }}
                            Branch </h3>
                        <h1>Loss Profit Report</h1>
                        <span>From {{ $start_date??'-' }} to {{ $end_date??'-' }}</span>
                    @endif
                </div>

                <hr>
            </header>

            <!-- Main Content -->
            <main>

                <hr>

                <div class="row">


                    <table class="col table mb-0  table-head-custom table-vertical-center ">
                        <thead>
                        <tr>
                            <th>Particulars</th>
                            <th style="text-align: center">Amount</th>
                        </tr>
                        </thead>
                        @php($amount = 0)
                        @foreach($incomeLedgers as $group_name=> $record)
                            <tr>
                                <td style="font-weight: bolder"> {{ $group_name }}</td>
                                <td></td>
                            </tr>
                            @foreach($record as $ledger)
                                <tr>
                                    <td>
                                        <span class="text-primary font-weight-bolder">→</span> <a
                                            href="{{ route('reports.report.ledger_report',['ledger_id'=>$ledger['id']]) }}"> {{ $ledger['ledger_name'] }}
                                    </td>
                                    <td style="text-align: center"> {{ decent_format_dash($ledger['amount']) }}</td>
                                </tr>
                                @php($amount = $amount + floatval($ledger['amount']))

                            @endforeach
                        @endforeach
                        <tr>
                            <td><b>GROSS PROFIT</b></td>
                            <td style="text-align: center"><b>{{ decent_format_dash($amount) }}</b></td>
                        </tr>
                    </table>

                    <table class="col table mb-0  table-head-custom table-vertical-center ">

                        <thead>
                        <tr>
                            <th>Particulars</th>
                            <th style="text-align: center">Amount</th>

                        </tr>
                        </thead>
                        @php($amount = 0)

                        @foreach($expenseLedgers as $group_name=> $record)
                            <tr>
                                <td style="font-weight: bolder"> {{ $group_name }}</td>
                            </tr>
                            @foreach($record as $ledger)
                                <tr style="margin:15px">
                                    <td> <span
                                            class="text-primary font-weight-bolder">→</span> <a
                                            href="{{ route('reports.report.ledger_report',['ledger_id'=>$ledger['id']]) }}"> {{ $ledger['ledger_name'] }}
                                    </td>
                                    <td style="text-align: center"> {{ decent_format_dash($ledger['amount']) }}</td>
                                </tr>
                                @php($amount = $amount + floatval($ledger['amount']))

                            @endforeach
                        @endforeach
                        <tr>
                            <td>TOTAL EXPENSE</td>
                            <td style="text-align: center">{{ decent_format_dash($amount) }}</td>
                        </tr>
                        <tr>
                            <td style="color: black!important;" class="font-weight-bolder"> NET PROFIT (GROSS PROFIT -
                                TOTAL EXPENSE)
                            </td>
                            <td style="text-align: center;color: black!important;">
                                <b>{{ decent_format_dash($totalIncome-$totalExpense) }}</b></td>
                        </tr>

                    </table>

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
            let invoice_number = "{{ $title ??'Report' }} {{ $start_date??today()->toDateString() }}_{{$end_date??today()->toDateString()}}"
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
