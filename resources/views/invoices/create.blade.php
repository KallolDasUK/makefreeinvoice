@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-product-create-form')
    @include('partials.ajax-ledger-create-form')

    @include('partials.ajax-customer-create-form')
    @include('partials.ajax-tax-create-form')
    @include('partials.ajax-payment-method-create-form')
    <div class="text-right">
        <a href="{{ route('invoices.invoice.index') }}"
           class="btn btn-primary {{  ability(\App\Utils\Ability::INVOICE_READ) }}" title="Show All Invoices">
            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
            Show All Invoice
        </a>
    </div>
    <p class="clearfix"></p>
    <div class="card">

        <div class="card-body">


            <span class="clearfix"></span>

            <form method="POST" action="{{ route('invoices.invoice.store') }}" accept-charset="UTF-8"
                  id="create_invoice_form" name="create_invoice_form" class="form-horizontal"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('invoices.form', ['invoice' => null])

                <div class="form-group">
                    <div class="float-right">

                        <button class="btn btn-primary btn-lg btn-fw" type="submit">

                            <i class="far fa-save"></i> Save Invoice
                        </button>
                    </div>
                </div>

            </form>

        </div>


    </div>

@endsection

@section('js')

    <script>

        var sample_item = {
            product_id: '', description: '', price: '', qnt: 1, tax_id: '', unit: 'unit', batch: ''
        };
        var copiedObject = jQuery.extend(true, {}, sample_item)
        var pair = @json($invoice_fields);
        var taxes = @json($taxes);
        var invoice_items = [copiedObject];
        var products = @json($products,JSON_INVALID_UTF8_IGNORE);
        var additional_fields = @json($extraFields);

        if (additional_fields.length === 0) {
            additional_fields = [{name: '', value: ''}];
        }
        var create = true;
        var settings = @json($settings);

        console.log(products)
        $(document).ready(function () {
            $('#country').select2({placeholder: 'Select Country'})
            $('.customer').select2({
                placeholder: "Choose or New Customer"
            }).on('select2:open', function () {
                let a = $(this).data('select2');
                let doExits = a.$results.parents('.select2-results').find('button')
                if (!doExits.length) {
                    a.$results.parents('.select2-results')
                        .append('<div><button  data-toggle="modal" data-target="#customerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Customer</button></div>')
                        .on('click', function (b) {
                            $(".customer").select2("close");
                        });
                }
                if (additional_fields.length > 0) {
                    $('#additionalCollapse').collapse('show')
                }

            })


        });
    </script>
    <script src="{{ asset('js/invoices.js') }}?v=1.2"></script>
    <script src="{{ asset('js/invoice-crud.js') }}?v=1.2"></script>

@endsection



@section('css')
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/invoice.css') }}"/>
    <style>
        td > * {
            vertical-align: top !important;
        }
    </style>
@endsection


