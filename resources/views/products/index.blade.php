@extends('acc::layouts.app')

@section('css')
    <style>

        .lds-ripple {
            display: inline-block;
            position: relative;
            width: 20px;
            height: 20px;
        }

        .lds-ripple div {
            position: absolute;
            border: 2px solid #065a92;
            opacity: 1;
            border-radius: 50%;
            animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }

        .lds-ripple div:nth-child(2) {
            animation-delay: -0.5s;
        }

        @keyframes lds-ripple {
            0% {
                top: 36px;
                left: 36px;
                width: 0;
                height: 0;
                opacity: 1;
            }
            100% {
                top: 0px;
                left: 0px;
                width: 72px;
                height: 72px;
                opacity: 0;
            }
        }

    </style>

@endsection
@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
    @if(Session::has('error_message'))
        <div class="alert alert-danger">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('error_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('products.product.import') }}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Upload From Excel File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input name="file" required type="file" class="form-control-file">


                        <hr>
                        Please <a target="_blank"
                                  href="https://docs.google.com/spreadsheets/d/1k_f8DDOa39AIrahz4_kqkvkjCV4hZ1kma0pD5Qhs_iI/edit?usp=sharing"><b>download</b></a>
                        sample file to check the column name and column order. Column order and name are equally
                        important.

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload File</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">
                <form action="{{ route('products.product.index') }}" style="width: 200px;" class="row">
                    <input name="q" type="text" class="form-control col rounded-none" placeholder="Search.."
                           style="border-radius: 0px;" value="{{ $q }} ">
                    <button type="submit" class="btn btn-sm btn-primary" style="border-radius: 0px;"><i
                            class="fa fa-search"></i></button>
                </form>
            </h5>

            <div class="float-right" role="group">

                <button
                    style="color: #17205f;font-size: 16px" id="importBtn" type="button"
                    class="btn btn-outline-secondary btn-lg font-weight-bolder font-size-sm mr-2"
                    data-toggle="modal" data-target="#importModal"
                >
                    <i class="fas fa-file-upload"></i>
                    <b>Import Product</b>
                </button>
                <a
                    href="{{ route('products.product.export') }}"
                    style="color: #007337;font-size: 16px"
                    id="exportButton" type="button"
                    class="btn btn-outline-secondary btn-lg font-weight-bolder font-size-sm ">
                    <i class="fas fa-file-excel"></i>
                    <b>Export to Excel</b>
                </a>

                <a href="{{ route('products.product.barcode') }}"
                   class="btn btn btn-outline-secondary btn-lg font-weight-bolder font-size-sm mx-4 {{ ability(\App\Utils\Ability::BARCODE_READ) }}"
                   style="color: #0a0a0a;font-size: 16px"
                   title="Create New Product">
                    <i class="fa fa-barcode" aria-hidden="true"></i>
                    Print Barcode
                </a>
                <a href="{{ route('products.product.create') }}"
                   class="btn btn-success btn-lg font-weight-bolder font-size-sm {{ ability(\App\Utils\Ability::PRODUCT_CREATE) }}"
                   style="font-size: 16px"
                   title="Create New Product">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Product
                </a>
            </div>

        </div>

        @if(count($products) == 0)
            <div class="card-body text-center">
                <div class="text-center">
                    <img style="text-align: center;margin: 0 auto;"
                         src="https://1.bp.blogspot.com/-oFZuUJWkeVI/YU2wRxUt26I/AAAAAAAAFKw/tA92-qZCPksDCerRYqgANfzaeF8xtGTFQCLcBGAsYHQ/s320/norecord.png"
                         alt="">

                </div>
            </div>
        @else
            <div class="card-body">

                <div class="">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Type</th>

                            <th>Name</th>
                            <th>Code</th>
                            <th>Stock Now</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Sell Price</th>
                            <th>Purchase Price</th>


                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $i => $product)
                            <tr>
                                <td>{{ (($products->currentPage() - 1) * $products->perPage()) + $loop->iteration }}</td>

                                <td>
                                    <img class="rounded" src="{{ asset('storage/'.$product->photo) }}" alt=""
                                         width="50">
                                </td>
                                <td>{{ $product->product_type }}</td>
                                <td><b>{{ $product->name }}</b></td>
                                <td>{{ $product->code }}</td>
                                <td class="text-center lds-ripple" id="stock_{{$product->id}}"> <div></div> <div></div></td>
                                <td>{{ optional($product->category)->name }}</td>
                                <td>{{ optional($product->brand)->name }}</td>
                                <td> {{ optional( $settings)->currency }}{{ number_format($product->sell_price, 2) }}</td>
                                <td> {{ optional( $settings)->currency }} {{ number_format($product->purchase_price, 2) }}</td>
                                <td>

                                    <form method="POST" action="{!! route('products.product.destroy', $product->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <a href="{{ route('products.product.edit', $product->id ) }}"
                                               class="btn mx-4 {{ ability(\App\Utils\Ability::PRODUCT_EDIT) }}"
                                               title="Edit Product">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit"
                                                    title="Delete Product"
                                                    class="btn"
                                                    {{ ability(\App\Utils\Ability::PRODUCT_DELETE) }}
                                                    onclick="return confirm(&quot;Click Ok to delete Product.&quot;)">
                                                <i class="fas  fa-trash text-danger" aria-hidden="true"></i>
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="float-right">
                    {!! $products->withQueryString()->links() !!}
                </div>
            </div>


        @endif

    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function () {
            var products = @json($product_ids);
            // alert(product_ids)
            $.ajax({
                url: route('products.product.product_stock'),
                data: {product_ids: products},
                type: 'post',
                success: function (response) {
                    console.log(response);
                    let product_stocks = response;
                    for (let i = 0; i < product_stocks.length; i++) {
                        let product_id = product_stocks[i].product_id;
                        let product_stock = product_stocks[i].product_stock;
                        $('#stock_' + product_id).text(product_stock);
                        $('#stock_' + product_id).removeClass('lds-ripple');

                    }

                }
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            $('#business_location').select2({placeholder: " -- Country --"})
            $('#currency').select2({placeholder: " ----"})
            $('#ledger_group_id').select2();
            var avatar1 = new KTImageInput('kt_image_1');
            var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            // alert(timezone)
            if (!$('#timezone').val()){

                $('#timezone').val(timezone);
            }
        })
    </script>



@endsection


