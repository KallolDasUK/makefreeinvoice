@extends('acc::layouts.app')


@section('content')

    <div class="card card-default">
        <div class="card-heading clearfix">


            <div class="float-right">

                <form method="POST" action="{!! route('contras.contra.destroy', $transaction->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a target="_blank" href="{{ route('contras.contra.pdf',$transaction->id) }}"
                           class="btn btn-inverse-primary mr-2" title="Print Transaction">
                            <span class="mdi mdi-printer" aria-hidden="true"></span>
                            Print Transaction
                        </a>
                        <a href="{{ route('contras.contra.index') }}" class="btn btn-primary mr-2"
                           title="Show All Transaction">
                            <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                            Show All Transaction
                        </a>

                        <a href="{{ route('contras.contra.create') }}" class="btn btn-success mr-2"
                           title="Create New Transaction">
                            <span class="mdi mdi-plus" aria-hidden="true"></span>
                            Create New Transaction
                        </a>

                        <a href="{{ route('contras.contra.edit', $transaction->id ) }}"
                           class="btn btn-primary  mr-2" title="Edit Transaction">
                            <span class="mdi mdi-pencil" aria-hidden="true"></span>
                            Edit Transaction
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Transaction"
                                onclick="return confirm(&quot;Click Ok to delete contra.?&quot;)">
                            <span class="mdi mdi-delete" aria-hidden="true"></span>
                            Delete Transaction
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <div class="card-body">
            <dl class="dl-horizontal">
                <dt>Ledger Name</dt>
                <dd>{{ $transaction->ledger_name }}</dd>
                <dt>Voucher No</dt>
                <dd>{{ $transaction->voucher_no }}</dd>
                <dt>Branch</dt>
                <dd>{{ optional($transaction->branch)->name }}</dd>
                <dt>Amount</dt>
                <dd>{{ $transaction->amount }}</dd>
                <dt>Voucher Date</dt>
                <dd>{{ $transaction->date }}</dd>
                <dt>Note</dt>
                <dd>{{ $transaction->note }}</dd>
                <dt>Txn Type</dt>
                <dd>{{ $transaction->txn_type }}</dd>
                <dt>Type</dt>
                <dd>{{ $transaction->type }}</dd>
                <dt>Type</dt>
                <dd>{{ $transaction->type_id }}</dd>

            </dl>

        </div>
    </div>

@endsection
