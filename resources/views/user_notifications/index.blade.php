@extends('master.master-layout')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">User Notifications</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('user_notifications.user_notification.create') }}" class="btn btn-success"
                   title="Create New User Notification">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New User Notification
                </a>
            </div>

        </div>

        @if(count($userNotifications) == 0)
            <div class="card-body text-center">
                <h4>No User Notifications Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>User</th>
                            <th>Seen</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userNotifications as $userNotification)
                            <tr>
                                <td>{{ $userNotification->type }}</td>
                                <td>{{ $userNotification->title }}</td>
                                <td>{{ $userNotification->body }}</td>
                                <td>{{ optional($userNotification->user)->name }}</td>
                                <td>{{ $userNotification->seen?'Yes':'No' }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('user_notifications.user_notification.destroy', $userNotification->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('user_notifications.user_notification.show', $userNotification->id ) }}"
                                               title="Show User Notification">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('user_notifications.user_notification.edit', $userNotification->id ) }}"
                                               class="mx-4" title="Edit User Notification">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete User Notification"
                                                    onclick="return confirm('Click Ok to delete User Notification.')">
                                                <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card-footer">
                {!! $userNotifications->render() !!}
            </div>

        @endif

    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('table').DataTable({
                responsive: true,
                "order": [],
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]

            });
        });
    </script>

    <style>
        .dataTables_filter {
            float: right;
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection


