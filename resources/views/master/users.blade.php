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
        <table class="table table-bordered table-sm">
            <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>On Plan</th>
                <th>Invoices</th>
                <th>Bills</th>
                <th>Estimate</th>
                <th>Expense</th>
                <th>Customers</th>
                <th>Vendors</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}-<small>{{ $user->email }}</small></td>
                    <td>{{ Str::title($user->role) }}</td>
                    <td>{{ $user->plan }}</td>
                    <td>{{ count($user->invoices)==0?'-':count($user->invoices) }}</td>
                    <td>{{ count($user->bills)==0?'-':count($user->bills) }}</td>
                    <td>{{ count($user->estimates)==0?'-':count($user->estimates) }}</td>
                    <td>{{ count($user->expenses)==0?'-':count($user->expenses) }}</td>
                    <td>{{ count($user->customers)==0?'-':count($user->customers) }}</td>
                    <td>{{ count($user->vendors)==0?'-':count($user->vendors) }}</td>
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
