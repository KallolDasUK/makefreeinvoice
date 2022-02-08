@extends('acc::layouts.app')

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

            <h5 class="my-1 float-left">Products</h5>

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
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Sell Price</th>
                            <th>Purchase Price</th>


                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <img class="rounded" src="{{ asset('storage/'.$product->photo) }}" alt=""
                                         width="50">
                                </td>
                                <td>{{ $product->product_type }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ optional($product->category)->name }}</td>
                                <td>{{ optional($product->brand)->name }}</td>
                                <td>{{ $product->sell_price }}</td>
                                <td>{{ $product->purchase_price }}</td>


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
            </div>


        @endif

    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function () {
            $('table').DataTable({
                responsive: true,
                "order": [],
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]

            });
        });
    </script>

    <style>
        .dataTables_filter {
            float: right;
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection


