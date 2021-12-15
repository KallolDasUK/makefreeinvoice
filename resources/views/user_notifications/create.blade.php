@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New User Notification</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('user_notifications.user_notification.index') }}" class="btn btn-primary"
                   title="Show All User Notification">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All User Notification
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('user_notifications.user_notification.store') }}"
                  accept-charset="UTF-8" id="create_user_notification_form" name="create_user_notification_form"
                  class="form-horizontal">
                {{ csrf_field() }}
                @include ('user_notifications.form', ['userNotification' => null])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
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
