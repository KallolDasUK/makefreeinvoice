@extends('master.master-layout')

@section('content')
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2>Client List</h2></div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ Str::title($user->role) }}</td>
                    <td>
                        <a target="_blank" class="add" href="" title="" data-toggle="tooltip" data-original-title="Add"><i
                                class="material-icons">Login</i></a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $users->links() !!}
    </div>
@endsection
