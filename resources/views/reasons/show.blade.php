@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($reason->name) ? $reason->name : 'Reason' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('reasons.reason.destroy', $reason->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('reasons.reason.index') }}" class="btn btn-primary mr-2" title="Show All Reason">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Reason
                    </a>

                    <a href="{{ route('reasons.reason.create') }}" class="btn btn-success mr-2" title="Create New Reason">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Reason
                    </a>

                    <a href="{{ route('reasons.reason.edit', $reason->id ) }}" class="btn btn-primary mr-2" title="Edit Reason">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Reason
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Reason" onclick="return confirm(&quot;Click Ok to delete Reason.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Reason
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $reason->name }}</dd>

        </dl>

    </div>
</div>

@endsection
