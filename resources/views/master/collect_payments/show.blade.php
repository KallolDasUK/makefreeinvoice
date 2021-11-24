@extends('master.master-layout')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Collect Payment' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('collect_payments.collect_payment.destroy', $collectPayment->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('collect_payments.collect_payment.index') }}" class="btn btn-primary mr-2" title="Show All Collect Payment">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Collect Payment
                    </a>

                    <a href="{{ route('collect_payments.collect_payment.create') }}" class="btn btn-success mr-2" title="Create New Collect Payment">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Collect Payment
                    </a>

                    <a href="{{ route('collect_payments.collect_payment.edit', $collectPayment->id ) }}" class="btn btn-primary mr-2" title="Edit Collect Payment">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Collect Payment
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Collect Payment" onclick="return confirm(&quot;Click Ok to delete Collect Payment.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Collect Payment
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Date</dt>
            <dd>{{ $collectPayment->date }}</dd>
            <dt>For Month</dt>
            <dd>{{ $collectPayment->for_month }}</dd>
            <dt>User</dt>
            <dd>{{ optional($collectPayment->user)->name }}</dd>
            <dt>Amount</dt>
            <dd>{{ $collectPayment->amount }}</dd>
            <dt>Referred By</dt>
            <dd>{{ optional($collectPayment->user)->name }}</dd>
            <dt>Referred By Amount</dt>
            <dd>{{ $collectPayment->referred_by_amount }}</dd>
            <dt>Note</dt>
            <dd>{{ $collectPayment->note }}</dd>

        </dl>

    </div>
</div>

@endsection
