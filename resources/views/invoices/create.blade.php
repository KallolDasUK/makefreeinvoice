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
                        <input class="btn btn-primary btn-lg btn-fw" type="submit" value="Save Invoice">
                    </div>
                </div>

            </form>

        </div>


    </div>

@endsection

@section('js')

    <script>
        var sample_item = {
            product_id: '', description: '', price: '', qnt: 1, tax_id: '', unit: 'Unit'
        };
        var copiedObject = jQuery.extend(true, {}, sample_item)
        var pair = {'key': '', value: ''};
        var taxes = @json($taxes);
        var invoice_items = [copiedObject];
        var products = @json($products);
        console.log(products)
        $(document).ready(function () {
            $('.customer').selectize({});
        });
    </script>
    <script src="{{ asset('js/invoices.js') }}"></script>
@endsection



@section('css')
    <style>
        td > * {
            vertical-align: top !important;
        }
    </style>
@endsection
