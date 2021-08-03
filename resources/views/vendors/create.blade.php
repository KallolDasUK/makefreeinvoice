@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Vendor</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('vendors.vendor.index') }}" class="btn btn-primary" title="Show All Vendor">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Vendor
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('vendors.vendor.store') }}" accept-charset="UTF-8" id="create_vendor_form" name="create_vendor_form" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include ('vendors.form', [
                                        'vendor' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


