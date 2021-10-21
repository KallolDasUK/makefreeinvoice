@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Customer Advance Payment' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('customer_advance_payments.customer_advance_payment.destroy', $customerAdvancePayment->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('customer_advance_payments.customer_advance_payment.index') }}" class="btn btn-primary mr-2" title="Show All Customer Advance Payment">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Customer Advance Payment
                    </a>

                    <a href="{{ route('customer_advance_payments.customer_advance_payment.create') }}" class="btn btn-success mr-2" title="Create New Customer Advance Payment">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Customer Advance Payment
                    </a>

                    <a href="{{ route('customer_advance_payments.customer_advance_payment.edit', $customerAdvancePayment->id ) }}" class="btn btn-primary mr-2" title="Edit Customer Advance Payment">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Customer Advance Payment
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Customer Advance Payment" onclick="return confirm(&quot;Click Ok to delete Customer Advance Payment.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Customer Advance Payment
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Customer</dt>
            <dd>{{ optional($customerAdvancePayment->customer)->name }}</dd>
            <dt>Payment Method</dt>
            <dd>{{ optional($customerAdvancePayment->ledger)->id }}</dd>
            <dt>Amount</dt>
            <dd>{{ $customerAdvancePayment->amount }}</dd>
            <dt>Date</dt>
            <dd>{{ $customerAdvancePayment->date }}</dd>
            <dt>Note</dt>
            <dd>{{ $customerAdvancePayment->note }}</dd>

        </dl>

    </div>
</div>

@endsection
