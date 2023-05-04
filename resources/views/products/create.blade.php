@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New Product</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('products.product.index') }}" class="btn btn-primary {{ ability(\App\Utils\Ability::PRODUCT_READ) }}" title="Show All Product">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Product
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('products.product.store') }}" accept-charset="UTF-8"
                  id="create_product_form" name="create_product_form" class="form-horizontal"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('products.form', ['product' => null])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/product.js') }}"></script>
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

