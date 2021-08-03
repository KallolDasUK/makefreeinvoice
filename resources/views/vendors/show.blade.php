@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($vendor->name) ? $vendor->name : 'Vendor' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('vendors.vendor.destroy', $vendor->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('vendors.vendor.index') }}" class="btn btn-primary mr-2" title="Show All Vendor">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Vendor
                    </a>

                    <a href="{{ route('vendors.vendor.create') }}" class="btn btn-success mr-2" title="Create New Vendor">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Vendor
                    </a>

                    <a href="{{ route('vendors.vendor.edit', $vendor->id ) }}" class="btn btn-primary mr-2" title="Edit Vendor">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Vendor
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Vendor" onclick="return confirm(&quot;Click Ok to delete Vendor.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Vendor
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $vendor->name }}</dd>
            <dt>Photo</dt>
            <dd>{{ asset('storage/' . $vendor->photo) }}</dd>
            <dt>Company Name</dt>
            <dd>{{ $vendor->company_name }}</dd>
            <dt>Phone</dt>
            <dd>{{ $vendor->phone }}</dd>
            <dt>Email</dt>
            <dd>{{ $vendor->email }}</dd>
            <dt>Country</dt>
            <dd>{{ $vendor->country }}</dd>
            <dt>Street 1</dt>
            <dd>{{ $vendor->street_1 }}</dd>
            <dt>Street 2</dt>
            <dd>{{ $vendor->street_2 }}</dd>
            <dt>City</dt>
            <dd>{{ $vendor->city }}</dd>
            <dt>State</dt>
            <dd>{{ $vendor->state }}</dd>
            <dt>Zip Post</dt>
            <dd>{{ $vendor->zip_post }}</dd>
            <dt>Address</dt>
            <dd>{{ $vendor->address }}</dd>
            <dt>Website</dt>
            <dd>{{ $vendor->website }}</dd>

        </dl>

    </div>
</div>

@endsection
