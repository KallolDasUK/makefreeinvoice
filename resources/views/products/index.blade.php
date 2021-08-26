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

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Products</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('products.product.create') }}" class="btn btn-success" title="Create New Product">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Product
                </a>
            </div>

        </div>

        @if(count($products) == 0)
            <div class="card-body text-center">
                <h4>No Products Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Sell Price</th>
                            <th>Purchase Price</th>


                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->product_type }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ optional($product->category)->name }}</td>
                                <td>{{ $product->sell_price }}</td>
                                <td>{{ $product->purchase_price }}</td>


                                <td>

                                    <form method="POST" action="{!! route('products.product.destroy', $product->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('products.product.show', $product->id ) }}"
                                               title="Show Product">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('products.product.edit', $product->id ) }}" class="mx-4"
                                               title="Edit Product">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Product"
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


