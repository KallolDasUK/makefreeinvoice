@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($title) ? $title : 'Customer Advance Payment' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('customer_advance_payments.customer_advance_payment.index') }}" class="btn btn-primary mr-2" title="Show All Customer Advance Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Customer Advance Payment
                </a>

                <a href="{{ route('customer_advance_payments.customer_advance_payment.create') }}" class="btn btn-success" title="Create New Customer Advance Payment">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Customer Advance Payment
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

            <form method="POST" action="{{ route('customer_advance_payments.customer_advance_payment.update', $customerAdvancePayment->id) }}" id="edit_customer_advance_payment_form" name="edit_customer_advance_payment_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('customer_advance_payments.form', [
                                        'customerAdvancePayment' => $customerAdvancePayment,
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
