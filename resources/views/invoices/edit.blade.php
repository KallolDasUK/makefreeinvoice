@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($title) ? $title : 'Invoice' }}</h5>

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

            <form method="POST" action="{{ route('invoices.invoice.update', $invoice->id) }}" id="edit_invoice_form" name="edit_invoice_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('invoices.form', [
                                        'invoice' => $invoice,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
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
        var pair = @json($additional);
        var taxes = @json($taxes);
        var invoice_items = @json($invoice_items);
        var products = @json($products);
        var additional_fields = @json($additionalFields);
        console.log(pair,'pairs')
        $(document).ready(function () {
            $('.customer').selectize({});
            if (pair.length>0){
                $('#additionalCollapse').collapse('show')
            }
        });
    </script>
    <script src="{{ asset('js/invoices.js') }}"></script>
@endsection
