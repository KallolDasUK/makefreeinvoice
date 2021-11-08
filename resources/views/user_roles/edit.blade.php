@extends('acc::layouts.app')

@section('content')
    @include('partials.settings-tab',['page'=>'user_roles'])

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($userRole->name) ? $userRole->name : 'User Role' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('user_roles.user_role.index') }}" class="btn btn-primary mr-2  {{  ability(\App\Utils\Ability::ROLE_READ) }}" title="Show All User Role">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All User Role
                </a>

                <a href="{{ route('user_roles.user_role.create') }}" class="btn btn-success  {{  ability(\App\Utils\Ability::ROLE_CREATE) }}" title="Create New User Role">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New User Role
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

            <form method="POST" action="{{ route('user_roles.user_role.update', $userRole->id) }}" id="edit_user_role_form" name="edit_user_role_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('user_roles.form', ['userRole' => $userRole])

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
            $('#create').on('change', function () {
                let is_checked = $(this).is(':checked');
                if (is_checked) {
                    $('.create').prop('checked', true)
                } else {
                    $('.create').prop('checked', false)
                }
            })
            $('#read').on('change', function () {
                let is_checked = $(this).is(':checked');
                if (is_checked) {
                    $('.read').prop('checked', true)
                } else {
                    $('.read').prop('checked', false)
                }
            })
            $('#edit').on('change', function () {
                let is_checked = $(this).is(':checked');
                if (is_checked) {
                    $('.edit').prop('checked', true)
                } else {
                    $('.edit').prop('checked', false)
                }
            })
            $('#delete').on('change', function () {
                let is_checked = $(this).is(':checked');
                if (is_checked) {
                    $('.delete').prop('checked', true)
                } else {
                    $('.delete').prop('checked', false)
                }
            })
        })
    </script>
@endsection
