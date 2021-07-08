@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($product->name) ? $product->name : 'Product' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('products.product.destroy', $product->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('products.product.index') }}" class="btn btn-primary mr-2" title="Show All Product">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Product
                    </a>

                    <a href="{{ route('products.product.create') }}" class="btn btn-success mr-2" title="Create New Product">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Product
                    </a>

                    <a href="{{ route('products.product.edit', $product->id ) }}" class="btn btn-primary mr-2" title="Edit Product">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Product
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Product" onclick="return confirm(&quot;Click Ok to delete Product.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Product
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Product Type</dt>
            <dd>{{ $product->product_type }}</dd>
            <dt>Name</dt>
            <dd>{{ $product->name }}</dd>
            <dt>SKU</dt>
            <dd>{{ $product->sku }}</dd>
            <dt>Product Image</dt>
            <dd>{{ asset('storage/' . $product->photo) }}</dd>
            <dt>Category</dt>
            <dd>{{ optional($product->category)->name }}</dd>
            <dt>Sell Price</dt>
            <dd>{{ $product->sell_price }}</dd>
            <dt>Sell Unit</dt>
            <dd>{{ $product->sell_unit }}</dd>
            <dt>Purchase Price</dt>
            <dd>{{ $product->purchase_price }}</dd>
            <dt>Purchase Unit</dt>
            <dd>{{ $product->purchase_unit }}</dd>
            <dt>Description</dt>
            <dd>{{ $product->description }}</dd>
            <dt>Is Track</dt>
            <dd>{{ ($product->is_track) ? 'Yes' : 'No' }}</dd>
            <dt>Opening Stock</dt>
            <dd>{{ $product->opening_stock }}</dd>
            <dt>Opening Stock Price</dt>
            <dd>{{ $product->opening_stock_price }}</dd>

        </dl>

    </div>
</div>

@endsection
