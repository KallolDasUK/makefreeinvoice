@extends('layouts.pos_layout')

@section('content')
    @include('partials.ajax-category-create-form')
    @include('partials.ajax-product-create-form')
    @include('partials.ajax-customer-create-form')
    @include('partials.blank_modal')
    <form method="POST" action="{{ route('pos_sales.pos_sale.store') }}" accept-charset="UTF-8"
          id="create_pos_sale_form" name="create_pos_sale_form" class="form-horizontal">
        {{ csrf_field() }}
        @include ('pos_sales.form', ['posSale' => null])


    </form>


@endsection

@section('js')

    <script>
        var products = @json($products);
        var customers = @json($customers);
        var categories = @json($categories);
        var orders = @json($orders);
        var currency = '$';
        var sample_pos_item = {
            product_id: '', description: '', price: '', qnt: 1, tax_id: '', attribute_id: '', unit: 'unit', amount: ''
        };
        var posSalesDetailsUrl = "{{ route('pos_sales.pos_sale.details') }}";
        var copiedObject = jQuery.extend(true, {}, sample_pos_item)
        var pos_items = [];

        var sample_charge_item = {
            key: 'Discount', value: ''
        };
        var charges = [jQuery.extend(true, {}, sample_charge_item), {key: '', value: ''}];
        $(document).ready(function () {

        });
    </script>
    <script src="{{ asset('js/product.js') }}"></script>
    <script src="{{ asset('js/pos/pos_sales.js') }}"></script>
    <script src="{{ asset('js/pos/pos_crud.js') }}"></script>
@endsection

