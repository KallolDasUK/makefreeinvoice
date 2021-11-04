@extends('acc::layouts.app')

@section('content')
    @include('partials.settings-tab',['page'=>'users'])
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


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('users.user.create') }}" class="btn btn-success" title="Create New User">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New User
                </a>
            </div>

        </div>

        @if(count($users) == 0)
            <div class="card-body text-center">
                <h4>No Users Available.</h4>
            </div>
        @else
            <div class="card-body">


                <table class="table mb-0  table-head-custom table-vertical-center font-weight-bolder"
                       style="font-size: 16px">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>

                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span
                                    class=" badge {{ random_item(['badge-info','badge-primary','badge-warning','badge-secondary','badge-danger']) }}">
                                {{ optional($user->user_role)->name }} [{{ optional($user->user_role)->description }}]

                                </span>
                            </td>
                            <td>

                                <form method="POST" action="{!! route('users.user.destroy', $user->id) !!}"
                                      accept-charset="UTF-8">
                                    <input name="_method" value="DELETE" type="hidden">
                                    {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">

                                        <a href="{{ route('users.user.edit', $user->id ) }}" class="mx-4"
                                           title="Edit User">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" style="border: none;background: transparent"
                                                title="Delete User"
                                                onclick="return confirm(&quot;Click Ok to delete User.&quot;)">
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

            <div class="card-footer">
                {!! $users->render() !!}
            </div>

        @endif

    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

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


