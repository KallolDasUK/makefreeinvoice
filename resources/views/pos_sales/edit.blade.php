@extends('layouts.pos_layout')



@section('content')
    @include('partials.ajax-category-create-form')
    @include('partials.ajax-product-create-form')
    @include('partials.ajax-customer-create-form')
    @include('partials.ajax-payment-method-create-form')
    @include('partials.pos-payment-single')
    @include('partials.blank_modal')
    @include('partials.ajax-ledger-create-form')
    <form method="POST" action="{{ route('pos_sales.pos_sale.update',$posSale->id) }}" accept-charset="UTF-8"
          id="edit_pos_sale_form" name="edit_pos_sale_form" class="form-horizontal">
        @csrf
        @method('put')
        @include ('pos_sales.form', ['posSale' => null])


    </form>



@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/jquery.qrcode.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/qrcode.js') }}"></script>
    <script>

        var products = @json($products,JSON_INVALID_UTF8_IGNORE);
        var customers = @json($customers,JSON_INVALID_UTF8_IGNORE);
        var ledgers = @json($ledgers);
        var cash_ledger_id = "{{ $ledger_id }}";
        var categories = @json($categories,JSON_INVALID_UTF8_IGNORE);
        var bookmarks = @json($bookmarks,JSON_INVALID_UTF8_IGNORE);
        var start_date = @json($start_date);
        var end_date = @json($end_date);
        var pos_numbers = @json($pos_numbers);
        var paymentMethods = @json($paymentMethods);

        var is_edit = true;
        var no_image = "{{ asset('images/no_image.png') }}";
        var token = $("meta[name='csrf-token']").attr("content");
        var orders = @json($orders,JSON_INVALID_UTF8_IGNORE);
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
        var pos_items = @json($pos_items);

        var charges = @json($charges);
        var payments = [];

        $(document).ready(function () {

        });
    </script>
    <script src="{{ asset('js/product.js') }}?v=1.17"></script>
    <script src="{{ asset('js/pos/pos_sales.js') }}?v=2.17"></script>
    <script src="{{ asset('js/pos/pos_crud.js') }}?v=1.17"></script>
    <script src="{{ asset('js/pos/pos_payment.js') }}?v=1.17"></script>
@endsection

