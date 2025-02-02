@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-product-create-form')
    @include('partials.ajax-customer-create-form')
    @include('partials.ajax-tax-create-form')
    @include('partials.ajax-payment-method-create-form')
    @include('partials.ajax-ledger-create-form')

    <div class="float-left">
        <h2>Add Contact Invoice</h2>
    </div>

    <div class="text-right">
        <a href="{{ route('contact_invoices.contact_invoice.index') }}" class="btn btn-primary" title="Show All ">
            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
            Show All
        </a>
    </div>
    <p class="clearfix"></p>
    <div class="card">

        <div class="card-body">


            <span class="clearfix"></span>

            <form method="POST" action="{{ route('contact_invoices.contact_invoice.store') }}" accept-charset="UTF-8"
                  id="create_invoice_form" name="create_invoice_form" class="form-horizontal"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('contact-invoices.form', ['contact_invoice' => null])

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
            product_id: '', description: '', workers: 1, monthly_cost: '',daily_cost: '', tax_id: '', working_days: ''
        };
        var copiedObject = jQuery.extend(true, {}, sample_item)
        var pair = @json($bill_fields);
        var taxes = @json($taxes);
        var bill_items = [copiedObject];
        var products = @json($products);
        var additional_fields = @json($extraFields);
        if (additional_fields.length === 0) {
            additional_fields = [{name: '', value: ''}];
        }
        var create = true;
        console.log(products)
        $(document).ready(function () {

            $('#customer_id').select2({
                placeholder: "Choose or New Customer"
            }).on('select2:open', function () {
                let a = $(this).data('select2');
                let doExits = a.$results.parents('.select2-results').find('button')
                if (!doExits.length) {
                    a.$results.parents('.select2-results')
                        .append('<div><button  data-toggle="modal" data-target="#customerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Customer</button></div>')
                        .on('click', function (b) {
                            $("#customer_id").select2("close");
                        });
                }


            })


        });
    </script>
    <script src="{{ asset('js/contact_invoices/bill.js') }}?v=1.0"></script>
    <script src="{{ asset('js/contact_invoices/bill-crud.js') }}?v=1.0"></script>

@endsection



@section('css')
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/invoice.css') }}"/>
    <style>
        td > * {
            vertical-align: top !important;
        }
    </style>
@endsection


