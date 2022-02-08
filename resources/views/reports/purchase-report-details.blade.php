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
                <form action="{{ route('reports.report.purchase_report_details') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <select id="vendor_id" name="vendor_id" class=" form-control m-2"

                                    >
                                        <option></option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                    @if($vendor->id == $vendor_id) selected @endif>{{ $vendor->name }}{{ $vendor->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select id="bill_id" name="bill_id" class=" form-control mr-2">
                                        <option></option>
                                        @foreach($bills as $bill)
                                            <option value="{{ $bill->bill_number }}"
                                                    @if($bill->bill_number == $bill_id) selected @endif>
                                                {{ $bill->bill_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 mt-4">
                                    <select id="brand_id" name="brand_id" class="form-control mr-2"
                                    >
                                        <option></option>
                                        @foreach(\App\Models\Brand::all() as $brand)
                                            <option value="{{ $brand->id }}"
                                                    @if($brand->id == $brand_id) selected @endif>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6  mt-4">
                                    <select id="category_id" name="category_id" class="form-control mr-2"
                                    >
                                        <option></option>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}"
                                                    @if($category->id == $category_id) selected @endif>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-6 ">
                                    <select id="product_id" name="product_id" class="form-control "
                                    >
                                        <option></option>
                                        @foreach(\App\Models\Product::all() as $product)
                                            <option value="{{ $product->id }}"
                                                    @if($product->id == $product_id) selected @endif>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6"></div>
                                <div class="col row mt-4">
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
                                <div class="col row mt-4">
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
                            <h1>Purchase Report Details </h1>
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
                                    <th class="text-left">Bill</th>
                                    <th class="text-left">Vendor</th>
                                    <th class="text-left">Product</th>
                                    <th class="text-left">Category</th>
                                    <th class="text-left">Brand</th>
                                    <th style="text-align: center">Qnt</th>
                                    <th style="text-align: center">Amount</th>
                                    <th style="text-align: center">Total</th>
                                </tr>

                                </thead>
                                <tbody>

                                @foreach($records as $record)
                                    <tr>
                                        <td class="text-left">{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $record->date }}</td>
                                        <td class="text-left">{{ $record->bill }}</td>
                                        <td class="text-left">{{ $record->vendor }}</td>
                                        <td class="text-left">{{ $record->product }}</td>
                                        <td class="text-left">{{ $record->category }}</td>
                                        <td class="text-left">{{ $record->brand }}</td>
                                        <td style="text-align: center">x{{ decent_format($record->qnt) }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->amount) }}</td>
                                        <td style="text-align: center">{{ decent_format_dash_if_zero($record->total) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="font-weight-bolder">
                                    <td colspan="7">Total</td>
                                    <td>{{ decent_format(collect($records)->sum('qnt')) }}</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('amount')) }}</td>
                                    <td>{{ decent_format_dash_if_zero(collect($records)->sum('total')) }}</td>

                                </tr>
                                </tbody>
                            </table>


                        </div>

                    </div>
                </main>
                <!-- Footer -->


            </div>
        @else
            <div class="text-center">
                <img style="text-align: center;margin: 0 auto;"
                     src="https://1.bp.blogspot.com/-oFZuUJWkeVI/YU2wRxUt26I/AAAAAAAAFKw/tA92-qZCPksDCerRYqgANfzaeF8xtGTFQCLcBGAsYHQ/s320/norecord.png"
                     alt="">
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
            $('#vendor_id').select2({placeholder: '-- Vendor --', allowClear: true})
            $('#bill_id').select2({placeholder: '-- Bill --', allowClear: true})
            $('#product_id').select2({placeholder: '-- Product --', allowClear: true})
            $('#category_id').select2({placeholder: '-- Category --', allowClear: true})
            $('#brand_id').select2({placeholder: '-- Brand --', allowClear: true})
        })
    </script>
@endpush
