@extends('acc::layouts.app')


@section('content')

<div class="card card-default">
    <div class="card-heading clearfix">



        <div class="float-right">

            <form method="POST" action="{!! route('branches.branch.destroy', $branch->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('branches.branch.index') }}" class="btn btn-primary mr-2" title="Show All Branch">
                        <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                        Show All Branch
                    </a>

                    <a href="{{ route('branches.branch.create') }}" class="btn btn-success mr-2" title="Create New Branch">
                        <span class="mdi mdi-plus" aria-hidden="true"></span>
                        Create New Branch
                    </a>

                    <a href="{{ route('branches.branch.edit', $branch->id ) }}" class="btn btn-primary" title="Edit Branch">
                       <span class="mdi mdi-pencil" aria-hidden="true"></span>
                       Edit Branch
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Branch" onclick="return confirm(&quot;Click Ok to delete Branch.?&quot;)">
                         <span class="mdi mdi-delete" aria-hidden="true"></span>
                         Delete Branch"
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $branch->name }}</dd>
            <dt>Location</dt>
            <dd>{{ $branch->location }}</dd>
            <dt>Description</dt>
            <dd>{{ $branch->description }}</dd>

        </dl>

    </div>
</div>

@endsection
