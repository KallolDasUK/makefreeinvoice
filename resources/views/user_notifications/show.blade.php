@extends('master.master-layout')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($userNotification->title) ? $userNotification->title : 'User Notification' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('user_notifications.user_notification.destroy', $userNotification->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('user_notifications.user_notification.index') }}" class="btn btn-primary mr-2" title="Show All User Notification">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All User Notification
                    </a>

                    <a href="{{ route('user_notifications.user_notification.create') }}" class="btn btn-success mr-2" title="Create New User Notification">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New User Notification
                    </a>

                    <a href="{{ route('user_notifications.user_notification.edit', $userNotification->id ) }}" class="btn btn-primary mr-2" title="Edit User Notification">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit User Notification
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete User Notification" onclick="return confirm(&quot;Click Ok to delete User Notification.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete User Notification
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Type</dt>
            <dd>{{ $userNotification->type }}</dd>
            <dt>Title</dt>
            <dd>{{ $userNotification->title }}</dd>
            <dt>Body</dt>
            <dd>{{ $userNotification->body }}</dd>
            <dt>User</dt>
            <dd>{{ optional($userNotification->user)->name }}</dd>
            <dt>Seen</dt>
            <dd>{{ $userNotification->seen }}</dd>

        </dl>

    </div>
</div>

@endsection
