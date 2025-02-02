@extends('acc::layouts.app')

@section('content')
    @include('partials.settings-tab',['page'=>'user_roles'])

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
                <a href="{{ route('user_roles.user_role.create') }}" class="btn btn-success  {{  ability(\App\Utils\Ability::ROLE_CREATE) }}"
                   title="Create New User Role">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New User Role
                </a>
            </div>

        </div>

        @if(count($userRoles) == 0)
            <div class="card-body text-center">
                <h4>No User Roles Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div >
                    <table class="table mb-0  table-head-custom table-vertical-center font-weight-bolder"
                           style="font-size: 16px">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Description</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userRoles as $userRole)
                            <tr>
                                <td>{{ (($userRoles->currentPage() - 1) * $userRoles->perPage()) + $loop->iteration }}</td>

                                <td>{{ $userRole->name }}</td>
                                <td>{{ $userRole->description }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('user_roles.user_role.destroy', $userRole->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <a  href="{{ route('user_roles.user_role.edit', $userRole->id ) }}"
                                               class="mx-4  {{  ability(\App\Utils\Ability::ROLE_EDIT) }}" title="Edit User Role">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    {{  ability(\App\Utils\Ability::ROLE_DELETE) }}
                                                    title="Delete User Role"
                                                    onclick="return confirm(&quot;Click Ok to delete User Role.&quot;)">
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
                {!! $userRoles->render() !!}
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


