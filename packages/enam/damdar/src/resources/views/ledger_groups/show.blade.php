@extends('acc::layouts.app')


@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Ledger Group' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('ledger_groups.ledger_group.destroy', $ledgerGroup->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('ledger_groups.ledger_group.index') }}" class="btn btn-primary" title="Show All Ledger Group">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('ledger_groups.ledger_group.create') }}" class="btn btn-success" title="Create New Ledger Group">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('ledger_groups.ledger_group.edit', $ledgerGroup->id ) }}" class="btn btn-primary" title="Edit Ledger Group">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Ledger Group" onclick="return confirm(&quot;Click Ok to delete Ledger Group.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>ID</dt>
            <dd>{{ $ledgerGroup->id }}</dd>
            <dt>Group Name</dt>
            <dd>{{ $ledgerGroup->group_name }}</dd>
            <dt>Parent</dt>
            <dd>{{ $ledgerGroup->parent }}</dd>
            <dt>Nature</dt>
            <dd>{{ $ledgerGroup->nature }}</dd>
            <dt>Cashflow Type</dt>
            <dd>{{ $ledgerGroup->cashflow_type }}</dd>

        </dl>

    </div>
</div>

@endsection
