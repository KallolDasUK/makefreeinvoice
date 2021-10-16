@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-ledger-create-form')

    @include('partials.ajax-product-create-form')
    @include('partials.ajax-vendor-create-form')
    @include('partials.ajax-tax-create-form')
    <div class="card">

        <div class="card-header">

            <h3 class="my-1 float-left">{{ !empty($title) ? $title : 'Edit Bill' }}</h3>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('purchase_orders.purchase_order.show',$purchase_order->id) }}"
                   class="btn btn-outline-primary mr-2 " title="Show All Bill"
                   style="font-size: 16px"
                >
                    <i class=" fas fa-fw fa-eye" aria-hidden="true"></i>
                    Preview Bill
                </a>
                <a href="{{ route('purchase_orders.purchase_order.index') }}" class="btn btn-primary mr-2" title="Show All Bill">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Bill
                </a>

                <a href="{{ route('purchase_orders.purchase_order.create') }}" class="btn btn-success" title="Create New Bill">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Bill
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

            <form method="POST" action="{{ route('purchase_orders.purchase_order.store', $purchase_order->id) }}" id="edit_invoice_form"
                  name="edit_invoice_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('purchase_orders.form', ['purchase_order' => $purchase_order])

                <div class="form-group mt-2">
                    <div class="float-right">

                        <button class="btn btn-primary btn-lg btn-fw" type="submit">

                            <i class="far fa-share-square"></i>
                            Update Purchase Order
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('css')
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('css/invoice.css') }}">
@endsection

@section('js')

    <script>
        var sample_item = {
            product_id: '', description: '', price: '', qnt: 1, tax_id: '', unit: 'unit'
        };
        var copiedObject = jQuery.extend(true, {}, sample_item)
        var pair = @json($billExtraField);
        var taxes = @json($taxes);
        var bill_items = @json($bill_items);
        var products = @json($products);
        var additional_fields = @json($extraFields);
        var create = false;
        console.log(pair, 'pairs')
        $(document).ready(function () {
            $('#vendor_id').select2({
                placeholder: "Choose or New Vendor"
            }).on('select2:open', function () {
                let a = $(this).data('select2');
                let doExits = a.$results.parents('.select2-results').find('button')
                if (!doExits.length) {
                    a.$results.parents('.select2-results')
                        .append('<div><button  data-toggle="modal" data-target="#vendorModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Vendor</button></div>')
                        .on('click', function (b) {
                            $("#vendor_id").select2("close");
                        });
                }
            })

            setTimeout(() => {
                let paymentAmount = {{ $purchase_order->payment_amount??0 }};
                if (paymentAmount) {

                    $('#paymentAmount').val(paymentAmount)
                } else {

                    $('#paymentAmount').val($('#total').val())
                }
                console.log('payment amount', paymentAmount)

            }, 1000)

        });
    </script>
    <script src="{{ asset('js/bills/bill.js') }}"></script>
    <script src="{{ asset('js/bills/bill-crud.js') }}"></script>
@endsection
