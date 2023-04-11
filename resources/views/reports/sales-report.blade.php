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
            <header>
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

                <hr>
            </header>



            <div class="card mb-2">
            <div class="card-body">
                <form action="{{ route('reports.report.sales_report') }}">
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
                                <div class="mx-2">
                                    <select id="invoice_id" name="invoice_id" class=" form-control "
                                            style="max-width: 130px"
                                    >
                                        <option></option>
                                        @foreach($invoices as $invoice)
                                            <option value="{{ $invoice->invoice_number }}"
                                                    @if($invoice->invoice_number == $invoice_id) selected @endif>
                                                {{ $invoice->invoice_number }}
                                            </option>
                                        @endforeach
                                        @foreach($pos_sales as $pos_sale)
                                            <option value="{{ $pos_sale->pos_number }}"
                                                    @if($pos_sale->pos_number == $invoice_id) selected @endif>
                                                {{ $pos_sale->pos_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mx-2">
                                    <select id="payment_status" name="payment_status" class="form-control "
                                            style="max-width: 130px"

                                    >
                                        <option></option>
                                        @foreach([\App\Models\Invoice::Paid,\App\Models\Invoice::UnPaid,\App\Models\Invoice::Partial] as $status)
                                            <option value="{{ $status }}"
                                                    @if($status == $payment_status) selected @endif>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(auth()->user()->is_admin)
                                    <div class="mx-2">
                                        <select name="user_id" id="user_id" class="form-control"
                                                style="max-width: 130px">
                                            <option></option>
                                            @foreach(\App\Models\User::query()->where('client_id',auth()->user()->client_id)->get() as $user)
                                                <option value="{{ $user->id }}"
                                                        @if($user->id == $user_id) selected @endif>{{ $user->name }} {{ $user->email }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
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
        @if(count($records)>0)
            <div id="invoice-container" class="container-fluid invoice-container">

                <!-- Header -->
                <header>
                    <div class="text-center">

                        @if($settings->business_name??false)
                            <h3>{{ $settings->business_name }}</h3>
                            <h1>Sales Report </h1>
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
                            <table class="table mb-0  table-head-custom table-vertical-center text-center">
                                <thead>

                                <tr>
                                    <th class="text-left">SL</th>
                                    <th class="text-left">Date</th>
                                    <th class="text-left">Invoice</th>
                                    <th class="text-left">Customer</th>
                                    <th style="text-align: center">Amount</th>
                                    <th style="text-align: center">Discount</th>
                                    <th style="text-align: center">Charges/VAT(+)</th>
                                    <th style="text-align: center">Total</th>
                                    <th style="text-align: center">Paid</th>
                                    <th style="text-align: center">Due</th>
                                </tr>

                                </thead>
                                <tbody>

                                @foreach($records as $record)
                                    <tr>
                                        <td class="text-left">{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $record->date }}</td>
                                        <td class="text-left">{{ $record->invoice }}</td>
                                        <td class="text-left">{{ $record->customer }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->sub_total) }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->discount) }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->charges) }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->total) }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->payment) }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->due) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="font-weight-bolder">
                                    <td colspan="4">Total</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('sub_total')) }}</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('discount')) }}</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('charges')) }}</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('total')) }}</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('payment')) }}</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('due')) }}</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
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
            $('#customer_id').select2({placeholder: 'Customer', allowClear: true})
            $('#invoice_id').select2({placeholder: 'Invoice', allowClear: true})
            $('#payment_status').select2({placeholder: 'Payment Status', allowClear: true})
        })
    </script>
@endpush
