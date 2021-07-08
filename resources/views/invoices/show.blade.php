@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Invoice' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('invoices.invoice.destroy', $invoice->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('invoices.invoice.index') }}" class="btn btn-primary mr-2" title="Show All Invoice">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Invoice
                    </a>

                    <a href="{{ route('invoices.invoice.create') }}" class="btn btn-success mr-2" title="Create New Invoice">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Invoice
                    </a>

                    <a href="{{ route('invoices.invoice.edit', $invoice->id ) }}" class="btn btn-primary mr-2" title="Edit Invoice">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Invoice
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Invoice" onclick="return confirm(&quot;Click Ok to delete Invoice.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Invoice
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Customer</dt>
            <dd>{{ optional($invoice->customer)->name }}</dd>
            <dt>Invoice Number</dt>
            <dd>{{ $invoice->invoice_number }}</dd>
            <dt>Order Number</dt>
            <dd>{{ $invoice->order_number }}</dd>
            <dt>Invoice Date</dt>
            <dd>{{ $invoice->invoice_date }}</dd>
            <dt>Payment Terms</dt>
            <dd>{{ $invoice->payment_terms }}</dd>
            <dt>Due Date</dt>
            <dd>{{ $invoice->due_date }}</dd>
            <dt>Total</dt>
            <dd>{{ $invoice->total }}</dd>
            <dt>Discount Type</dt>
            <dd>{{ $invoice->discount_type }}</dd>
            <dt>Discount Value</dt>
            <dd>{{ $invoice->discount_value }}</dd>
            <dt>Discount</dt>
            <dd>{{ $invoice->discount }}</dd>
            <dt>Shipping Charge</dt>
            <dd>{{ $invoice->shipping_charge }}</dd>
            <dt>Terms Condition</dt>
            <dd>{{ $invoice->terms_condition }}</dd>
            <dt>Notes</dt>
            <dd>{{ $invoice->notes }}</dd>
            <dt>Attach File(s) to Invoice</dt>
            <dd>{{ asset('storage/' . $invoice->attachment) }}</dd>

        </dl>

    </div>
</div>

@endsection
