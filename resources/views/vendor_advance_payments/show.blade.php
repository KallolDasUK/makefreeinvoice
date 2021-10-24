@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Vendor Advance Payment' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('vendor_advance_payments.vendor_advance_payment.destroy', $vendorAdvancePayment->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('vendor_advance_payments.vendor_advance_payment.index') }}" class="btn btn-primary mr-2" title="Show All Vendor Advance Payment">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Vendor Advance Payment
                    </a>

                    <a href="{{ route('vendor_advance_payments.vendor_advance_payment.create') }}" class="btn btn-success mr-2" title="Create New Vendor Advance Payment">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Vendor Advance Payment
                    </a>

                    <a href="{{ route('vendor_advance_payments.vendor_advance_payment.edit', $vendorAdvancePayment->id ) }}" class="btn btn-primary mr-2" title="Edit Vendor Advance Payment">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Vendor Advance Payment
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Vendor Advance Payment" onclick="return confirm(&quot;Click Ok to delete Vendor Advance Payment.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Vendor Advance Payment
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Vendor</dt>
            <dd>{{ optional($vendorAdvancePayment->vendor)->name }}</dd>
            <dt>Payment Method</dt>
            <dd>{{ optional($vendorAdvancePayment->ledger)->id }}</dd>
            <dt>Amount</dt>
            <dd>{{ $vendorAdvancePayment->amount }}</dd>
            <dt>Date</dt>
            <dd>{{ $vendorAdvancePayment->date }}</dd>
            <dt>Note</dt>
            <dd>{{ $vendorAdvancePayment->note }}</dd>

        </dl>

    </div>
</div>

@endsection
