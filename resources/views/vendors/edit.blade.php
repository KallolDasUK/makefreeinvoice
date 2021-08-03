@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($vendor->name) ? $vendor->name : 'Vendor' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('vendors.vendor.index') }}" class="btn btn-primary mr-2" title="Show All Vendor">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Vendor
                </a>

                <a href="{{ route('vendors.vendor.create') }}" class="btn btn-success" title="Create New Vendor">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Vendor
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

            <form method="POST" action="{{ route('vendors.vendor.update', $vendor->id) }}" id="edit_vendor_form" name="edit_vendor_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('vendors.form', ['vendor' => $vendor])

                <div class="form-group">
                    <div class="float-right">
                        <input class="btn btn-primary btn-lg" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
