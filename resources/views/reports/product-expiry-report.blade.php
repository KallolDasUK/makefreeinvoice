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
                <form action="{{ route('reports.report.product_expiry_report') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

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
        <div id="invoice-container" class="container-fluid invoice-container">

            <!-- Header -->
{{--            <header>--}}
{{--                <div class="text-center">--}}

{{--                    @if($settings->business_name??false)--}}
{{--                        <h3>{{ $settings->business_name }}</h3>--}}
{{--                        <h5>{{ $settings->street_1 }} {{ $settings->street_2 }}</h5>--}}
{{--                        <h5>{{ $settings->email }}, {{ $settings->phone }}</h5>--}}
{{--                        <h1>Product Expiry Report</h1>--}}
{{--                        <span>Date {{ today()->format('d M Y') }}</span>--}}
{{--                    @endif--}}
{{--                </div>--}}

{{--                <hr>--}}
{{--            </header>--}}
        @include('reports.partials.report-header')

            <!-- Main Content -->
            <main>

                <hr>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="">
                            <table class="table mb-0 table-bordered">
                                <thead class="card-header">
                                <tr>
                                    <td class=" border-0"><strong>SL</strong></td>
                                    <td class=" border-0"><strong>Batch</strong></td>
                                    <td class=" border-0"><strong>Product Name</strong></td>
                                    <td class=" border-0"><strong>Expiry Date</strong></td>
                                    <td class=" border-0"><strong>Expires/Expired</strong></td>
                                    <td class=" border-0"><strong>Stock</strong></td>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($records as $record)
                                    <tr>
                                        <td class=" border-0">{{ $loop->iteration }}</td>
                                        <td class="text-start border-0">{{ $record->batch }}</td>
                                        <td class="text-start border-0" style="max-width: 300px">
                                            {{ optional($record->product)->name }}</td>
                                        <td class="text-start border-0 @if(\Carbon\Carbon::parse(\Carbon\Carbon::today())->greaterThan($record->exp_date)) text-danger @endif ">{{ $record->exp_date }}</td>
                                        <td class="text-start border-0  @if(\Carbon\Carbon::parse(\Carbon\Carbon::today())->greaterThan($record->exp_date)) text-danger @endif ">{{ \Carbon\Carbon::parse($record->exp_date)->diffForHumans() }}</td>
                                        <td class="text-start border-0"
                                            style="max-width: 300px"> {{ decent_format_dash($record->qnt) }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
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


    </script>
@endpush
