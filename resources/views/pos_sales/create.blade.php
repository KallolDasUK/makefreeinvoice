@extends('layouts.pos_layout')

@section('content')
    @include('partials.ajax-category-create-form')
    @include('partials.ajax-product-create-form')
    @include('partials.ajax-customer-create-form')
    @include('partials.ajax-payment-method-create-form')
    @include('partials.pos-payment-single')
    @include('partials.blank_modal')
    @include('partials.ajax-ledger-create-form')
    <form method="POST" action="{{ route('pos_sales.pos_sale.store') }}" accept-charset="UTF-8"
          id="create_pos_sale_form" name="create_pos_sale_form" class="form-horizontal">
        {{ csrf_field() }}
        @include ('pos_sales.form', ['posSale' => null])


    </form>


@endsection

@section('js')

    <script>

        {{--var data = $.ajax({--}}
        {{--    type: "GET",--}}
        {{--    url: "{{ route('ajax.posCreateData') }}",--}}
        {{--    async: true--}}
        {{--}).responseText;--}}

        {{--$.ajax({--}}
        {{--    url: "{{ route('ajax.posCreateData') }}",--}}
        {{--    async: false,--}}
        {{--    success: function (response) {--}}
        {{--        console.log(response)--}}

        {{--    }--}}
        {{--});--}}

        {{--console.log(data)--}}
        var products = @json($products);
        var customers = @json($customers);
        var ledgers = @json($ledgers);
        var cash_ledger_id = "{{ $ledger_id }}";
        var categories = @json($categories);
        var bookmarks = @json($bookmarks);
        var start_date = @json($start_date);
        var end_date = @json($end_date);
        var paymentMethods = @json($paymentMethods);


        var no_image = "{{ asset('images/no_image.png') }}";
        var token = $("meta[name='csrf-token']").attr("content");
        var orders = @json($orders);
        var can_delete = @json($can_delete);
        var settings = @json($settings);
        var pos_print_receipt = (settings.pos_print_receipt || '1') === '1';
        console.log(settings)
        var currency = settings.currency;
        var sample_pos_item = {
            product_id: '', description: '', price: '', qnt: 1, tax_id: '', attribute_id: '', unit: 'unit', amount: ''
        };
        var posSalesDetailsUrl = "{{ route('pos_sales.pos_sale.details') }}";
        var productBookmarkedUrl = "{{ route('products.product.bookmark') }}";

        var copiedObject = jQuery.extend(true, {}, sample_pos_item)
        var pos_items = [];

        var charges = @json($charges);
        var payments = [];

        $(document).ready(function () {

        });
    </script>
    <script src="{{ asset('js/product.js') }}?v=1.13"></script>
    <script src="{{ asset('js/pos/pos_sales.js') }}?v=2.13"></script>
    <script src="{{ asset('js/pos/pos_crud.js') }}?v=1.13"></script>
    <script src="{{ asset('js/pos/pos_payment.js') }}?v=1.13"></script>
@endsection

