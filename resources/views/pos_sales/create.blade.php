@extends('layouts.pos_layout')

@section('content')

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
        var currency = '$';
        var sample_pos_item = {
            product_id: '', description: '', price: '', qnt: 1, tax_id: '', unit: 'unit', amount: ''
        };
        var copiedObject = jQuery.extend(true, {}, sample_pos_item)
        var pos_items = [];

        var sample_charge_item = {
            key: 'Discount', value: ''
        };
        var charges = [jQuery.extend(true, {}, sample_charge_item),{key: '', value: ''}];
        $(document).ready(function () {

        });
    </script>
    <script src="{{ asset('js/pos/pos_sales.js') }}"></script>
@endsection

