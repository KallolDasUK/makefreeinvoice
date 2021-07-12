@extends('acc::layouts.app')

@section('content')

    <div style="position:absolute;right: 0">
        <a href="{{ route('invoices.invoice.index') }}" class="btn btn-primary float-right" title="Show All Invoice">
            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
            Show All
        </a>
    </div>
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
            product_id: '', description: '', price: '', qnt: 1, tax_id: '', unit: 'unit'
        };
        var copiedObject = jQuery.extend(true, {}, sample_item)
        var pair = [{'key': '', value: ''}];
        var taxes = @json($taxes);
        var invoice_items = [copiedObject];
        var products = @json($products);
        var additional_fields = [{name: '', value: ''}];

        console.log(products)
        $(document).ready(function () {

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

            })


        });
    </script>
    <script src="{{ asset('js/invoices.js') }}"></script>
    <script src="{{ asset('js/invoice-crud.js') }}"></script>

@endsection



@section('css')
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('css/invoice.css') }}">
    <style>
        td > * {
            vertical-align: top !important;
        }
    </style>
@endsection


