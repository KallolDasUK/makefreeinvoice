@extends('acc::layouts.app')


@section('content')

<div class="card card-default">
    <div class="card-heading clearfix">



        <div class="float-right">

            <form method="POST" action="{!! route('ledgers.ledger.destroy', $ledger->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('ledgers.ledger.index') }}" class="btn btn-primary mr-2" title="Show All Ledger">
                        <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                        Show All Ledger
                    </a>

                    <a href="{{ route('ledgers.ledger.create') }}" class="btn btn-success mr-2" title="Create New Ledger">
                        <span class="mdi mdi-plus" aria-hidden="true"></span>
                        Create New Ledger
                    </a>

                    <a href="{{ route('ledgers.ledger.edit', $ledger->id ) }}" class="btn btn-primary mr-2" title="Edit Ledger">
                       <span class="mdi mdi-pencil" aria-hidden="true"></span>
                       Edit Ledger
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Ledger" onclick="return confirm(&quot;Click Ok to delete Ledger.?&quot;)">
                         <span class="mdi mdi-delete" aria-hidden="true"></span>
                         Delete Ledger
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Ledger Name</dt>
            <dd>{{ $ledger->ledger_name }}</dd>
            <dt>Ledger Group</dt>
            <dd>{{ optional($ledger->ledgerGroup)->id }}</dd>
            <dt>Opening</dt>
            <dd>{{ $ledger->opening }}</dd>
            <dt>Opening Type</dt>
            <dd>{{ $ledger->opening_type }}</dd>
            <dt>Active</dt>
            <dd>{{ $ledger->active }}</dd>

        </dl>

    </div>
</div>

@endsection
