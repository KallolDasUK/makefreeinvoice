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


        @media print {
            body * {
                visibility: hidden;
                font-size: 1.5rem;
                color: #181818 !important;
                margin: 0px;
            }

            h1 {
                font-size: 4rem;
            }

            h2 {
                font-size: 3rem;
            }

            h2 {
                font-size: 2rem;
            }

            .invoice-container {
                margin: 0px;
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
                <form action="{{ route('reports.report.vendor_statement') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col-lg-3 col-xl-2">

                            <select name="vendor_id" id="vendor_id" class="form-control form-control-select"
                                    required>
                                <option></option>
                                @foreach($vendors as $v)
                                    <option
                                        value="{{ $v->id }}" {{ $vendor_id == $v->id?'selected':'' }}>
                                        {{ $v->name }}
                                    </option>
                                @endforeach
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

                                    @if( $vendor_id !=null)
                                        <a href="{{ route('reports.report.vendor_statement') }}" title="Clear Filter"
                                           class="btn btn-icon btn-light-danger"> X</a>
                                    @endif


                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="float-right {{ $vendor_id == null?'d-none':'' }}">
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
        @if($vendor_id)
            <div id="invoice-container" class=" invoice-container ">

                <!-- Header -->
                <header>
                    <div class="mt-8">
                        @if($settings->business_name??false)
                            <h1 class="float-left">
                                {{ $settings->business_name }}
                                <br>
                                @if($settings->business_logo??false)
                                    <img
                                        class="rounded text-left"
                                        src="{{ asset('storage/'.$settings->business_logo) }}"
                                        width="100"
                                        alt="">
                                @endif
                            </h1>
                            <h1 class="float-right">
                                Vendor Statement
                            </h1>

                        @endif
                        <span class="clearfix"></span>
                        <div class="row align-items-baseline justify-content-around">
                            <div class="col"> Bill From:
                                <address style="max-width: 300px;margin-left: 35px">
                                    <b>{{ $vendor->name ??'N/A' }} {{ $vendor->company_name }} </b>
                                    <br>
                                    @if($vendor->street_1)
                                        {{ $vendor->street_1??'' }} <br>
                                    @endif

                                    @if($vendor->street_2)
                                        {{ $vendor->street_2??'' }}<br>
                                    @endif
                                    {{ $vendor->state??'' }} {{ $vendor->zip_post??'' }}
                                    @if($vendor->email)
                                        <br> {{ $vendor->email??'' }}
                                    @endif
                                    @if($vendor->phone)
                                        <br> {{ $vendor->phone??'' }}
                                    @endif
                                </address>
                            </div>
                            <div class="col">
                            <span>
                                <div class="mt-8 text-right">
                                    Statement Start Date : {{ $start_date }}
                                <br>
                                Statement End Date : {{ $end_date }}
                                    <br>
                                    <span>
                                        Statement ID: <input type="text" style="max-width: 100px">
                                    </span>
                                     <br>
                                    <span>
                                        Vendor ID : <input type="text" style="max-width: 100px"
                                                           value="[{{$vendor->id}}]">
                                    </span>
                                </div>

                            </span>
                                <br>
                                <div class="ml-8">

                                    <div class="bg-secondary p-2">
                                        <b>Account Summary</b>
                                    </div>
                                    <span>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Previous Balance</td>
                                        <td class="">{{ decent_format_dash_if_zero($opening) }} </td>
                                    </tr>
                                    <tr>
                                        <td>New Charges</td>
                                      <td class="">{{ decent_format_dash_if_zero(collect($records)->sum('amount')) }} </td>
                                    </tr>
                                    <tr>
                                        <td>Payments</td>
                                      <td class="">{{ decent_format_dash_if_zero(collect($records)->sum('payment')) }} </td>
                                    </tr>

                                      <tr>
                                        <td>Total Balance Due</td>
                                        <td>{{ decent_format_dash_if_zero(($opening + collect($records)->sum('amount')) - collect($records)->sum('payment')) }}</td>
                                    </tr>
                                </table>
                            </span>

                                </div>
                            </div>
                        </div>


                    </div>

                    <hr>
                </header>

                <!-- Main Content -->
                <main>

                    <hr>

                    <div class="card" style="min-height: 300px">
                        <div class="card-body p-0">
                            <div class="">
                                <table class="table mb-0 table-bordered">
                                    <thead class="card-header">
                                    <tr>
                                        <td class=" border-0"><strong>SL</strong></td>
                                        <td class=" border-0"><strong>Date</strong></td>
                                        <td class="text-right  border-0">Bill</td>
                                        <td class="text-right border-0">Description</td>
                                        <td class="text-right border-0">Payment</td>
                                        <td class="text-right border-0 ">Amount</td>
                                        <td class="text-right border-0  bg-secondary">Balance</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($balance = $opening??0)
                                    @foreach($records as $record)
                                        @php($balance = ($balance + $record->amount) - $record->payment)

                                        <tr>
                                            <td class=" border-0">{{ $loop->iteration }}</td>
                                            <td class="text-start border-0">{{ $record->date }}</td>
                                            <td class="text-right border-0">{{ $record->bill }}</td>
                                            <td class="text-right border-0">{!! $record->description !!}</td>
                                            <td class="text-right border-0">{{ decent_format_dash_if_zero($record->payment) }}</td>
                                            <td class="text-right border-0">{{ decent_format_dash_if_zero($record->amount) }}</td>
                                            <td class="text-right border-0  bg-secondary font-weight-bolder">{{ decent_format_dash_if_zero($balance) }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot class="card-footer">
                                    <tr>
                                        <td colspan="6" class="text-right border-0">Current Balance</td>
                                        <td class="text-right border-0  bg-secondary  font-weight-bolder">{{ decent_format_dash_if_zero($balance) }}</td>
                                    </tr>
                                    </tfoot>
                                </table>


                            </div>
                        </div>
                    </div>
                    <div style="width: 60%;">
                        <div class="m-auto text-center mt-8">

                            <address class="text-left">
                                <b>if you have any questions about this statement please contact</b> <br>
                                {{ $settings->business_name??'n/a' }}
                                @if($settings->street_1??'')
                                    <br> {{ $settings->street_1??'' }}
                                @endif
                                @if($settings->street_2??'')
                                    <br> {{ $settings->street_2??'' }}
                                @endif
                                @if(($settings->state??'') || ($settings->zip_post??'') )
                                    <br> {{ $settings->state??'' }} {{ $settings->zip_post??'' }}
                                @endif
                                @if($settings->email??'')
                                    <br> {{ $settings->email??'' }}
                                @endif
                                @if($settings->phone??'')
                                    <br> {{ $settings->phone??'' }}
                                @endif
                            </address>
                        </div>
                    </div>
                    <h2 class="text-center">Thanks for your business</h2>
                </main>
                <!-- Footer -->


            </div>
        @endif

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

        $('#vendor_id').select2({placeholder: 'Select Vendor', allowClear: true})


    </script>
@endpush
