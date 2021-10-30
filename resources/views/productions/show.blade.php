@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Production' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('productions.production.destroy', $production->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('productions.production.index') }}" class="btn btn-primary mr-2" title="Show All Production">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Production
                    </a>

                    <a href="{{ route('productions.production.create') }}" class="btn btn-success mr-2" title="Create New Production">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Production
                    </a>

                    <a href="{{ route('productions.production.edit', $production->id ) }}" class="btn btn-primary mr-2" title="Edit Production">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Production
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Production" onclick="return confirm(&quot;Click Ok to delete Production.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Production
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Ref</dt>
            <dd>{{ $production->ref }}</dd>
            <dt>Date</dt>
            <dd>{{ $production->date }}</dd>
            <dt>Production Status</dt>
            <dd>{{ $production->status }}</dd>
            <dt>Note</dt>
            <dd>{{ $production->note }}</dd>

        </dl>

    </div>
</div>

@endsection
