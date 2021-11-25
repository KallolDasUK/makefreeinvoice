@extends('master.master-layout')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Payment Request' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('payment_requests.payment_request.destroy', $paymentRequest->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('payment_requests.payment_request.index') }}" class="btn btn-primary mr-2" title="Show All Payment Request">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Payment Request
                    </a>

                    <a href="{{ route('payment_requests.payment_request.create') }}" class="btn btn-success mr-2" title="Create New Payment Request">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Payment Request
                    </a>

                    <a href="{{ route('payment_requests.payment_request.edit', $paymentRequest->id ) }}" class="btn btn-primary mr-2" title="Edit Payment Request">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Payment Request
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Payment Request" onclick="return confirm(&quot;Click Ok to delete Payment Request.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Payment Request
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Date</dt>
            <dd>{{ $paymentRequest->date }}</dd>
            <dt>User</dt>
            <dd>{{ optional($paymentRequest->user)->name }}</dd>
            <dt>Amount</dt>
            <dd>{{ $paymentRequest->amount }}</dd>
            <dt>Status</dt>
            <dd>{{ $paymentRequest->status }}</dd>
            <dt>Note</dt>
            <dd>{{ $paymentRequest->note }}</dd>

        </dl>

    </div>
</div>

@endsection
