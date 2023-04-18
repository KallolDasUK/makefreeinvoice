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
                <form action="{{ route('reports.report.receipt_payment_report') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col">
                            <div class="row align-items-center">

                                <div class="input-daterange input-group" id="start_date">

                                    <select name="branch_id" class="col-2 form-control mx-2" title="Branch">
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
        @include('reports.partials.print-download-export')

        <p class="clearfix"></p>
        <div id="invoice-container" class="container-fluid invoice-container">

            <!-- Header -->
        @include('reports.partials.report-header')


        <!-- Main Content -->
            <main>

                <hr>

                <div class="card">

                    <div class="card-body p-0">
                        <table class="table mb-0  table-head-custom table-vertical-center text-center">
                            <thead>

                            <tr>
                                <th class="text-left">SL</th>
                                <th class="text-left">Date</th>
                                <th class="text-left">Details</th>
                                <th class="text-left">Type</th>
                                <th class="text-left">REF</th>
                                <th style="text-align: center">Amount</th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr style="font-weight: bolder;text-align: center">
                                <td></td>
                                <td colspan="3" class="text-left">Receipt/Received Summary</td>

                            </tr>
                            @php($amount = 0)
                            @foreach($receipts ?? [] as $txn)
                                <tr>
                                    <td class="text-left">{{ $loop->iteration }} </td>
                                    <td class="text-left">{{ \Carbon\Carbon::parse($txn->date)->toDateString() }}</td>
                                    <td class="text-left">{{ optional($txn->transaction_details->first())->transaction_details }}</td>
                                    <td class="text-left">{{ $txn->txn_type }}</td>
                                    <td class="text-left">{{ optional($txn->transaction_details->first())->ref ?? $txn->voucher_no }}</td>
                                    <td style="text-align: center">{{ decent_format_dash($txn->amount )}}</td>
                                    @php($amount += $txn->amount )
                                </tr>
                            @endforeach
                            <tr style="font-weight: bolder;text-align: center">
                                <td></td>
                                <td colspan="4" class="text-right">TOTAL RECEIPT/RECEIVED</td>
                                <td>{{ decent_format_dash($amount) }}</td>

                            </tr>
                            <tr style="font-weight: bolder;text-align: center">
                                <td></td>
                                <td colspan="3" class="text-left">Payments Summary</td>

                            </tr>
                            @php($amount = 0)
                            @foreach($payments ?? [] as $txn)
                                <tr>
                                    <td class="text-left">{{ $loop->iteration }} </td>
                                    <td class="text-left">{{ $txn->date}}</td>
                                    <td class="text-left">{{ optional($txn->transaction_details->first())->transaction_details }}</td>
                                    <td class="text-left">{{ $txn->txn_type }}</td>
                                    <td class="text-left">{{ optional($txn->transaction_details->first())->ref ?? $txn->voucher_no }}</td>
                                    <td style="text-align: center">{{ decent_format_dash($txn->amount )}}</td>
                                    @php($amount += $txn->amount )
                                </tr>
                            @endforeach
                            <tr style="font-weight: bolder;text-align: center">
                                <td></td>
                                <td colspan="4" class="text-right">TOTAL PAYMENT</td>
                                <td>{{ decent_format_dash($amount) }}</td>

                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </main>
        @include('reports.partials.powered-by')
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


        $(document).ready(function () {
            $('#ledger_id').select2({placeholder: 'Select Account/Ledger'})
        })
    </script>
@endpush
