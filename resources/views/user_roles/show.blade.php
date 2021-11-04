@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($userRole->name) ? $userRole->name : 'User Role' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('user_roles.user_role.destroy', $userRole->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('user_roles.user_role.index') }}" class="btn btn-primary mr-2" title="Show All User Role">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All User Role
                    </a>

                    <a href="{{ route('user_roles.user_role.create') }}" class="btn btn-success mr-2" title="Create New User Role">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New User Role
                    </a>

                    <a href="{{ route('user_roles.user_role.edit', $userRole->id ) }}" class="btn btn-primary mr-2" title="Edit User Role">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit User Role
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete User Role" onclick="return confirm(&quot;Click Ok to delete User Role.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete User Role
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $userRole->name }}</dd>
            <dt>Description</dt>
            <dd>{{ $userRole->description }}</dd>

        </dl>

    </div>
</div>

@endsection
