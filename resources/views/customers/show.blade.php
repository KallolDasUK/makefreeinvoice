@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($customer->name) ? $customer->name : 'Customer' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('customers.customer.destroy', $customer->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('customers.customer.index') }}" class="btn btn-primary mr-2" title="Show All Customer">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Customer
                    </a>

                    <a href="{{ route('customers.customer.create') }}" class="btn btn-success mr-2" title="Create New Customer">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Customer
                    </a>

                    <a href="{{ route('customers.customer.edit', $customer->id ) }}" class="btn btn-primary mr-2" title="Edit Customer">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Customer
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Customer" onclick="return confirm(&quot;Click Ok to delete Customer.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Customer
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $customer->name }}</dd>
            <dt>Profile Photo</dt>
            <dd>{{ asset('storage/' . $customer->photo) }}</dd>
            <dt>Company Name</dt>
            <dd>{{ $customer->company_name }}</dd>
            <dt>Phone</dt>
            <dd>{{ $customer->phone }}</dd>
            <dt>Email</dt>
            <dd>{{ $customer->email }}</dd>
            <dt>Address</dt>
            <dd>{{ $customer->address }}</dd>
            <dt>Website</dt>
            <dd>{{ $customer->website }}</dd>

        </dl>

    </div>
</div>

@endsection
