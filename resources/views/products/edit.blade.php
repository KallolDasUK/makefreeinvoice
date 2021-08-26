@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($product->name) ? $product->name : 'Product' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('products.product.index') }}" class="btn btn-primary mr-2" title="Show All Product">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Product
                </a>

                <a href="{{ route('products.product.create') }}" class="btn btn-success" title="Create New Product">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Product
                </a>

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('products.product.update', $product->id) }}" id="edit_product_form" name="edit_product_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('products.form', [
                                        'product' => $product,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/product.js') }}"></script>
@endsection
