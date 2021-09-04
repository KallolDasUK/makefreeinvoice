@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Bill Payment' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('bill_payments.bill_payment.destroy', $billPayment->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('bill_payments.bill_payment.index') }}" class="btn btn-primary mr-2" title="Show All Bill Payment">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Bill Payment
                    </a>

                    <a href="{{ route('bill_payments.bill_payment.create') }}" class="btn btn-success mr-2" title="Create New Bill Payment">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Bill Payment
                    </a>

                    <a href="{{ route('bill_payments.bill_payment.edit', $billPayment->id ) }}" class="btn btn-primary mr-2" title="Edit Bill Payment">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Bill Payment
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Bill Payment" onclick="return confirm(&quot;Click Ok to delete Bill Payment.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Bill Payment
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Vendor</dt>
            <dd>{{ optional($billPayment->vendor)->name }}</dd>
            <dt>Bill</dt>
            <dd>{{ optional($billPayment->bill)->bill_number }}</dd>
            <dt>Payment Date</dt>
            <dd>{{ $billPayment->payment_date }}</dd>
            <dt>Payment Sl</dt>
            <dd>{{ $billPayment->payment_sl }}</dd>
            <dt>Payment Method</dt>
            <dd>{{ optional($billPayment->paymentMethod)->name }}</dd>
            <dt>Ledger</dt>
            <dd>{{ optional($billPayment->ledger)->id }}</dd>
            <dt>Note</dt>
            <dd>{{ $billPayment->note }}</dd>

        </dl>

    </div>
</div>

@endsection
