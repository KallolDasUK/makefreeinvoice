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
                <form action="{{ route('reports.report.due_report') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col">
                            <div class="row align-items-center">

                                <div class="mx-2">
                                    <select id="customer_id" name="customer_id" class=" form-control m-2"

                                            style="max-width: 130px"
                                    >
                                        <option></option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                    @if($customer->id == $customer_id) selected @endif>{{ $customer->name }}{{ $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 row">
                                    <div class="input-daterange input-group" id="start_date">


                                        <input type="text" class="form-control " name="start_date"
                                               value="{{ $start_date ?? '' }}"
                                               placeholder="Start">
                                        <div class="input-group-append">
									<span class="input-group-text">
										...
                                    </span>
                                        </div>
                                        <input type="text" class="form-control" name="end_date" id="end_date"
                                               value="{{ $end_date??'' }}"

                                               placeholder="End">


                                    </div>

                                </div>
                                <div class="col">
                                    <button role="button" type="submit"
                                            class="btn btn-primary px-6 mx-2  font-weight-bold">
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
            <header>
                <div class="text-center">

                    @if($settings->business_name??false)
                        @include('reports.partials.report-header')
                        <h1>Due Report </h1>
                        <span>From {{ $start_date??'-' }} to {{ $end_date??'-' }}</span>
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
                            <table class="table mb-0 table-bordered">
                                <thead class="card-header">
                                <tr>
                                    <td class=" border-0"><strong>Invoice Number</strong></td>
{{--                                    @if($settings->customer_id_feature??'0')--}}
{{--                                        <td class="text-center"><strong>Customer ID</strong></td>--}}
{{--                                    @endif--}}
                                    <td class=" border-0"><strong>Customer Name</strong></td>

                                    <td class=" border-0"><strong>Invoice Date</strong></td>

                                    <td class="text-right border-0 bg-secondary">Due Amount</td>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td class=" border-0">{{ $invoice->invoice_number }}</td>
{{--                                        @if($settings->customer_id_feature??'0')--}}
{{--                                            <td class="text-center">{{ $customer->customer_ID??'-' }}</td>--}}
{{--                                        @endif--}}
                                        <td class="text-start border-0" style="max-width: 300px">
                                            <b>{{ optional($invoice->customer)->name }}</b></td>
                                        <td class="text-start border-0">{{ $invoice->invoice_date??'-' }}</td>

                                        <td class="text-right border-0 bg-secondary">{{ decent_format_dash_if_zero($invoice->due) }}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="card-footer">

                                <tr>
                                    <td colspan="3" class="text-right border-0"><strong>Total Due</strong></td>
                                    <td class="text-right border-0 font-weight-bolder bg-secondary">{{ decent_format_dash_if_zero(collect($invoices)->sum('due')) }}</td>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
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
            let invoice_number = "Report_" + "{{ today()->toDateString() }}"
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
            $('#customer_id').select2({placeholder: 'Customer', allowClear: true})
        })
    </script>
@endpush
