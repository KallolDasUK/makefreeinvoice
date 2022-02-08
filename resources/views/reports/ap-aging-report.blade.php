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

        <div class="row">
            <div class="col">
                <form action="{{ route('reports.report.ap_aging_report') }}">
                    <div class="row align-items-center mb-4" style="min-width: 200px">

                        <div class="col-6">
                            <input name="q" type="text" class="form-control" placeholder="Name, Phone, Email"
                                   value="{{ $q }}" >
                        </div>
                        <div class="col-6">

                            <button role="button" type="submit" class="btn btn-primary ">
                                <i class="fas fa-sliders-h"></i>
                                Filter
                            </button>

                            @if( $q != null)
                                <a href="{{ route('reports.report.ap_aging_report') }}" title="Clear Filter"
                                   class="btn btn-icon btn-light-danger"> X</a>
                            @endif


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
                        <h3>{{ $settings->business_name }}</h3>
                        <h1>Accounts Payable Aging</h1>
                        <span>As of {{ today()->format('M d, Y') }}</span>
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
                                    <td class=" border-0"><strong>Vendor</strong></td>
                                    <td class="text-right border-0">0-30 Days</td>
                                    <td class="text-right border-0">31-60 Days</td>
                                    <td class="text-right border-0">60-90 Days</td>
                                    <td class="text-right border-0">90+ Days</td>
                                    <td class="text-right border-0">Total</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($records  as $record)
                                    <tr>
                                        <td class=" border-0 font-weight-bolder">{{ $record->name }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($record->_0_30) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($record->_31_60) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($record->_61_90) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($record->_90) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash_if_zero($record->total) }}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="card-footer">

                                <tr>
                                    <td class="text-right border-0"></td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($records)->sum('_0_30')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($records)->sum('_31_60')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($records)->sum('_61_90')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($records)->sum('_90')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash_if_zero(collect($records)->sum('total')) }}</td>


                                </tr>
                                </tfoot>
                            </table>
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
            let invoice_number = "PayableAgingReport" + Date.now().toString();
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
