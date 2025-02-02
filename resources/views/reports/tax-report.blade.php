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
                <form action="{{ route('reports.report.tax_report') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col-lg-3 col-xl-2">
                            <label for="report_type">Report Type <span id="report_type_help" data-toggle="popover"
                                                                       data-html="true"
                                                                       data-content='<div class="wv-popover__content" style="padding: 24px;"><span class="wv-text wv-text--body"><div class="sales-tax-report-filters__filter-controls__report-type-popover-paragraph"><strong class="wv-text--strong">Accrual (Paid &amp; Unpaid)</strong></div><div>Reflects all transactions, including unpaid invoices and bills.</div><div class="sales-tax-report-filters__filter-controls__report-type-popover-paragraph"><strong class="wv-text--strong">Cash Basis (Paid)</strong></div><div>Reflects all transactions except unpaid invoices and bills.</div><div class="sales-tax-report-filters__filter-controls__report-type-popover-paragraph"><a class="wv-text--link-external" href="https://www.google.com/search?q=Accrual+vs.+Cash-Basis+Reporting&oq=Accrual+vs.+Cash-Basis+Reporting" rel="noopener noreferrer" target="_blank">Learn more</a></div></span></div>'
                                                                       class="fa fa-question rounded-full border p-2 text-primary "></span>
                            </label>
                            <select name="report_type" id="report_type" class="form-control form-control-select">

                                <option value="accrual" {{ $report_type == 'accrual'?'selected':'' }}>Accrual (Paid &
                                    Unpaid)
                                </option>
                                <option value="cash" {{ $report_type == 'cash'?'selected':'' }}>Cash Basis (Paid)
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



{{--        <p class="clearfix"></p>--}}
{{--        <div id="invoice-container" class="container-fluid invoice-container">--}}

            <!-- Header -->
        @include('reports.partials.print-download-export')

        <p class="clearfix"></p>
        <div id="invoice-container" class="container-fluid invoice-container">

            <!-- Header -->


            <!-- Main Content -->
            <main>

                <header>
                    <div class="text-center">

                        @if($settings->business_name??false)
                            @include('reports.partials.report-header')
                            <h1>Tax Summary</h1>
                            <span>Basis: {{ $report_type??'' }}</span> <br>
                            <span>From {{ $start_date??'-' }} to {{ $end_date??'-' }}</span><br>

                        @endif
                    </div>
                </header>
                <hr>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="">
                            <table class="table mb-0 table-bordered">
                                <thead class="card-header">
                                <tr>
                                    <td class=" border-0"><strong>SL</strong></td>
                                    <td class=" border-0"><strong>Tax</strong></td>
                                    <td class="text-right  border-0"> Sales <br>
                                        Subject to Tax
                                    </td>

                                    <td class="text-right border-0">Tax Amount on <br> Sales</td>
                                    <td class="text-right border-0">Expenses <br> Subject to Tax</td>
                                    <td class="text-right border-0 ">Tax Amount on <br> Expenses</td>

                                    <td class="text-right border-0  bg-secondary">Purchases <br> Subject to Tax</td>

                                    <td class="text-right border-0  bg-secondary">Tax Amount on <br> Purchases</td>
                                    <td class="text-right border-0">Net Tax Owing</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($taxes as $tax)
                                    <tr>
                                        <td class="text-right border-0">{{ $loop->iteration }}</td>
                                        <td class="text-start border-0">{{ $tax->tax_name }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($tax->invoice_taxable) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($tax->invoice_tax_amount) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($tax->expense_taxable) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($tax->expense_tax_amount) }}</td>
                                        <td class="text-right border-0  bg-secondary">{{ decent_format_dash_if_zero($tax->bill_taxable) }}</td>
                                        <td class="text-right border-0  bg-secondary">{{ decent_format_dash_if_zero($tax->bill_tax_amount) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($tax->tax_amount) }}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="card-footer">

                                <tr>
                                    <td class="text-right border-0"></td>
                                    <td class="text-start border-0"></td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($taxes)->sum('invoice_taxable')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($taxes)->sum('invoice_tax_amount')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($taxes)->sum('expense_taxable')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($taxes)->sum('expense_tax_amount')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder  bg-secondary">{{ decent_format_dash_if_zero(collect($taxes)->sum('bill_taxable')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder  bg-secondary">{{ decent_format_dash_if_zero(collect($taxes)->sum('bill_tax_amount')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($taxes)->sum('tax_amount')) }}</td>


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
