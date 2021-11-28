@extends('acc::layouts.app')


@section('content')


    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="mdi mdi-information-outline"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
    @include('partials.settings-tab',['page'=>'pos_settings'])

    <br>


    <form method="post" action="{{ route('accounting.settings.pos_settings_store') }}">
        @csrf
        <div class="form-group row  align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label class="font-weight-bolder">Price</label>
            </div>
            <div class="col-lg-4">
                <select name="pos_card_price" id="pos_card_price" class="form-control">
                    <option value="sale_price" {{ ($settings->pos_card_price ?? null) == 'sale_price'?'selected':'' }}>
                        Sale Price
                    </option>
                    <option
                        value="purchase_price" {{ ($settings->pos_card_price ?? null) == 'purchase_price'?'selected':'' }}>
                        Purchase Price
                    </option>
                </select>

            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_stock" class="font-weight-bolder ">Hide Stock</label>
            </div>
            <div class="col-lg-4">
                <input type="hidden" name="pos_hide_stock" value="0">
                <input id="pos_hide_stock" type="checkbox" name="pos_hide_stock"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->pos_hide_stock??'0')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_price" class="font-weight-bolder ">Hide Product Price</label>
            </div>
            <div class="col-lg-4">
                <input type="hidden" name="pos_hide_price" value="0">
                <input id="pos_hide_price" type="checkbox" name="pos_hide_price"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->pos_hide_price??'0')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_name" class="font-weight-bolder ">Hide Product Name</label>
            </div>
            <div class="col-lg-4">
                <input type="hidden" name="pos_hide_name" value="0">
                <input id="pos_hide_name" type="checkbox" name="pos_hide_name"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->pos_hide_name??'0')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_image" class="font-weight-bolder ">Hide Product Image</label>
            </div>
            <div class="col-lg-4">
                <input type="hidden" name="pos_hide_image" value="0">
                <input id="pos_hide_image" type="checkbox" name="pos_hide_image"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->pos_hide_image??'1')?'checked':'' }}>
            </div>
        </div>

        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_print_receipt" class="font-weight-bolder ">Print Receipt After Sale</label>
            </div>
            <div class="col-lg-4">
                <input type="hidden" name="pos_print_receipt" value="0">
                <input id="pos_print_receipt" type="checkbox" name="pos_print_receipt"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->pos_print_receipt??'1')?'checked':'' }}>
            </div>
        </div>   <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_prevent_sale_out_of_stock" class="font-weight-bolder ">Prevent Sale On <br> <b class="text-danger">'Out of Stock'</b></label>
            </div>
            <div class="col-lg-4">
                <input type="hidden" name="pos_prevent_sale_out_of_stock" value="0">
                <input id="pos_prevent_sale_out_of_stock" type="checkbox" name="pos_prevent_sale_out_of_stock"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->pos_prevent_sale_out_of_stock??'0')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2 required">
                <label class="font-weight-bolder"> </label>
            </div>
            <div class="col-lg-4 text-right">
                <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
            </div>
        </div>

    </form>


@endsection

@push('js')
    <script src="{{ asset('js/subscriptions/subscribe.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#show').on('change', function () {

                if (this.checked) {
                    $('#new_password,#confirmed_password').attr('type', 'text')

                } else {
                    $('#new_password,#confirmed_password').attr('type', 'password')

                }
            })
        })
    </script>
@endpush

