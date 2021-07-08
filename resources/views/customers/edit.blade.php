@extends('layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($customer->name) ? $customer->name : 'Customer' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('customers.customer.index') }}" class="btn btn-primary mr-2" title="Show All Customer">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Customer
                </a>

                <a href="{{ route('customers.customer.create') }}" class="btn btn-success" title="Create New Customer">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Customer
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

            <form method="POST" action="{{ route('customers.customer.update', $customer->id) }}" id="edit_customer_form" name="edit_customer_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('customers.form', [
                                        'customer' => $customer,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
