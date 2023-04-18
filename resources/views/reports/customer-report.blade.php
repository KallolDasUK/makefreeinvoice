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
                        <div class="">
                            <table class="table mb-0 table-bordered">
                                <thead class="card-header">
                                <tr>
                                    <td class=" border-0"><strong>SL</strong></td>
                                    @if($settings->customer_id_feature??'0')
                                        <td class="text-center"><strong>Customer ID</strong></td>
                                    @endif
                                    <td class=" border-0"><strong>Customer Name</strong></td>

                                    <td class=" border-0"><strong>Phone</strong></td>
                                    <td class=" border-0"><strong>Address</strong></td>

                                    <td class="text-start border-0">Email</td>
                                    <td class="text-right border-0 bg-secondary">Receivable</td>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class=" border-0">{{ $loop->iteration }}</td>
                                        @if($settings->customer_id_feature??'0')
                                            <td class="text-center">{{ $customer->customer_ID??'-' }}</td>
                                        @endif
                                        <td class="text-start border-0" style="max-width: 300px">
                                            <b>{{ $customer->name }}</b></td>
                                        <td class="text-start border-0">{{ $customer->phone??'-' }}</td>
                                        <td class="text-start border-0"
                                            style="max-width: 300px">{{ $customer->street_1 . ' '.$customer->street_2 }} @if($customer->street_1 == null && $customer->street_2 == null)
                                                - @endif</td>
                                        <td class="text-start border-0">{{ $customer->email??'-' }}</td>
                                        <td class="text-right border-0 bg-secondary">{{ decent_format_dash_if_zero($customer->receivables) }}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="card-footer">

                                <tr>
                                    <td colspan="5" class="text-right border-0"><strong>Total Receivable</strong></td>
                                    <td class="text-right border-0 font-weight-bolder bg-secondary">{{ decent_format_dash_if_zero(collect($customers)->sum('receivables')) }}</td>

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


    </script>
@endpush
