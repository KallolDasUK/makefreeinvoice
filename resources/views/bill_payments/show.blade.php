@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Receive Payment' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('receive_payments.receive_payment.destroy', $receivePayment->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('receive_payments.receive_payment.index') }}" class="btn btn-primary mr-2" title="Show All Receive Payment">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Receive Payment
                    </a>

                    <a href="{{ route('receive_payments.receive_payment.create') }}" class="btn btn-success mr-2" title="Create New Receive Payment">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Receive Payment
                    </a>

                    <a href="{{ route('receive_payments.receive_payment.edit', $receivePayment->id ) }}" class="btn btn-primary mr-2" title="Edit Receive Payment">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Receive Payment
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Receive Payment" onclick="return confirm(&quot;Click Ok to delete Receive Payment.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Receive Payment
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Customer</dt>
            <dd>{{ optional($receivePayment->customer)->name }}</dd>
            <dt>Invoice</dt>
            <dd>{{ $receivePayment->invoice }}</dd>
            <dt>Payment Date</dt>
            <dd>{{ $receivePayment->payment_date }}</dd>
            <dt>Payment Sl</dt>
            <dd>{{ $receivePayment->payment_sl }}</dd>
            <dt>Payment Method</dt>
            <dd>{{ optional($receivePayment->paymentMethod)->name }}</dd>
            <dt>Deposit To</dt>
            <dd>{{ $receivePayment->deposit_to }}</dd>
            <dt>Note</dt>
            <dd>{{ $receivePayment->note }}</dd>

        </dl>

    </div>
</div>

@endsection
