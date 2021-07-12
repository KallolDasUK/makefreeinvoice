@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">{{ !empty($title) ? $title : 'Invoice' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('invoices.invoice.index') }}" class="btn btn-primary mr-2" title="Show All Invoice">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Invoice
                </a>

                <a href="{{ route('invoices.invoice.create') }}" class="btn btn-success" title="Create New Invoice">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Invoice
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

            <form method="POST" action="{{ route('invoices.invoice.update', $invoice->id) }}" id="edit_invoice_form"
                  name="edit_invoice_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('invoices.form', ['invoice' => $invoice])

                <div class="form-group mt-2">
                    <div class="float-right">

                        <button class="btn btn-primary btn-lg btn-fw" type="submit">

                            <i class="far fa-share-square"></i>
                            Update Invoice
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
        var pair = @json($invoiceExtraField);
        var taxes = @json($taxes);
        var invoice_items = @json($invoice_items);
        var products = @json($products);
        var additional_fields = @json($extraFields);
        console.log(pair, 'pairs')
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
            if (additional_fields.length > 0) {
                $('#additionalCollapse').collapse('show')
            }
        });
    </script>
    <script src="{{ asset('js/invoices.js') }}"></script>
    <script src="{{ asset('js/invoice-crud.js') }}"></script>
@endsection
