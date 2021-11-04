@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($user->name) ? $user->name : 'User' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('users.user.destroy', $user->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('users.user.index') }}" class="btn btn-primary mr-2" title="Show All User">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All User
                    </a>

                    <a href="{{ route('users.user.create') }}" class="btn btn-success mr-2" title="Create New User">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New User
                    </a>

                    <a href="{{ route('users.user.edit', $user->id ) }}" class="btn btn-primary mr-2" title="Edit User">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit User
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete User" onclick="return confirm(&quot;Click Ok to delete User.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete User
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $user->name }}</dd>
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>
            <dt>Password</dt>
            <dd>{{ $user->password }}</dd>

        </dl>

    </div>
</div>

@endsection
