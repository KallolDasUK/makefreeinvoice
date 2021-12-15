@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($userNotification->title) ? $userNotification->title : 'User Notification' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('user_notifications.user_notification.index') }}" class="btn btn-primary mr-2" title="Show All User Notification">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All User Notification
                </a>

                <a href="{{ route('user_notifications.user_notification.create') }}" class="btn btn-success" title="Create New User Notification">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New User Notification
                </a>

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('user_notifications.user_notification.update', $userNotification->id) }}" id="edit_user_notification_form" name="edit_user_notification_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('user_notifications.form', ['userNotification' => $userNotification,
                                    ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#user_id').select2();
        })
    </script>
@endsection
