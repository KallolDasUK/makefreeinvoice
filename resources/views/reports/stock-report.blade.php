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
        .table-sm th, .table-sm td {
            padding: 0.3rem;
            max-width: 200px;
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
                <form action="{{ route('reports.report.stock-report') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-4 ">
                                    <select id="product_id" name="product_id" class="form-control mr-2 ">
                                        <option></option>
                                        @foreach(\App\Models\Product::all() as $product)
                                            <option value="{{ $product->id }}"
                                                    @if($product->id == $product_id) selected @endif>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select id="brand_id" name="brand_id" class="form-control mr-2 ">
                                        <option></option>
                                        @foreach(\App\Models\Brand::all() as $brand)
                                            <option value="{{ $brand->id }}"
                                                    @if($brand->id == $brand_id) selected @endif>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 ">
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

                                <div class="input-daterange col-12 input-group  mt-4" id="start_date">
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
            <header>
                <div class="text-center">

                    @if($settings->business_name??false)
                        @include('reports.partials.report-header')
                        <h1>Stock Report </h1>
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
                            <table class="table mb-0 table-bordered table-sm">
                                <thead class="card-header">
                                <tr>
                                    <td class=" border-0"><strong>SL</strong></td>
                                    <td class=" border-0"><strong>Item</strong></td>
                                    <td class=" border-0"><strong>Rate</strong></td>
                                    <td class="text-right  border-0"> Opening <br>
                                        Quantity (As on {{ $start_date }})
                                    </td>

                                    <td class="text-right border-0">Purchase</td>
                                    <td class="text-right border-0">Sold</td>

                                    <td class="text-right border-0 ">Purchase <br> Return (-)</td>
                                    <td class="text-right border-0 ">Sales <br> Return (+)</td>

                                    <td class="text-right border-0 ">Used In <br> Production (-)</td>
                                    <td class="text-right border-0 ">Produced In <br> Production (+)</td>


                                    <td class="text-right border-0 ">Stock <br> Adjusted (Added +)</td>
                                    <td class="text-right border-0 ">Stock <br> Adjusted (Removed -)</td>
                                    <td class="text-right border-0 ">Stock <br> Entry</td>


                                    <td class="text-right border-0  bg-secondary">Stock</td>
                                    <td class="text-right border-0  bg-secondary">Stock Value</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($records as $record)
                                    <tr>
                                        <td class=" border-0">{{ $loop->iteration }}</td>
                                        <td class="text-start border-0">{{ $record->name }}</td>
                                        <td class="text-start border-0">{{ $record->price }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash($record->opening_stock) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash($record->purchase) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash($record->sold) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash($record->purchase_return) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash($record->sales_return) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash($record->used_in_production) }}</td>
                                        <td class="text-right border-0">{{ decent_format_dash($record->produced_in_production) }}</td>


                                        <td class="text-right border-0">{{ decent_format_dash($record->added) }}</td>
                                        <td class="text-right border-0  ">{{ decent_format_dash($record->removed) }}</td>
                                        <td class="text-right border-0  ">{{ decent_format_dash($record->stock_entry) }}</td>

                                        <td class="text-right border-0  bg-secondary">{{ decent_format_dash($record->stock) }}</td>
                                        <td class="text-right border-0  bg-secondary">{{ decent_format_dash_if_zero($record->stockValue) }}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="card-footer">

                                <tr>
                                    <td class="text-right border-0"></td>
                                    <td class="text-start border-0"></td>
                                    <td class="text-start border-0"></td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('opening_stock')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('purchase')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('sold')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('purchase_return')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('sales_return')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('used_in_production')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('produced_in_production')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder">{{ decent_format_dash(collect($records)->sum('added')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder  ">{{ decent_format_dash(collect($records)->sum('removed')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder  ">{{ decent_format_dash(collect($records)->sum('stock_entry')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder bg-secondary ">{{ decent_format_dash(collect($records)->sum('stock')) }}</td>
                                    <td class="text-right border-0 font-weight-bolder   bg-secondary">{{ decent_format_dash_if_zero(collect($records)->sum('stockValue')) }}</td>


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
        $('#category_id').select2({placeholder: '-- Category --', allowClear: true})
        $('#brand_id').select2({placeholder: '-- Brand --', allowClear: true})
        $('#product_id').select2({placeholder: '-- Product --', allowClear: true})

    </script>
@endpush
