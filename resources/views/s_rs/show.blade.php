@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($sR->name) ? $sR->name : 'S R' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('s_rs.s_r.destroy', $sR->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('s_rs.s_r.index') }}" class="btn btn-primary mr-2" title="Show All S R">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All S R
                    </a>

                    <a href="{{ route('s_rs.s_r.create') }}" class="btn btn-success mr-2" title="Create New S R">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New S R
                    </a>

                    <a href="{{ route('s_rs.s_r.edit', $sR->id ) }}" class="btn btn-primary mr-2" title="Edit S R">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit S R
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete S R" onclick="return confirm(&quot;Click Ok to delete S R.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete S R
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $sR->name }}</dd>
            <dt>Photo</dt>
            <dd>{{ asset('storage/' . $sR->photo) }}</dd>
            <dt>Phone</dt>
            <dd>{{ $sR->phone }}</dd>
            <dt>Email</dt>
            <dd>{{ $sR->email }}</dd>
            <dt>Address</dt>
            <dd>{{ $sR->address }}</dd>

        </dl>

    </div>
</div>

@endsection
