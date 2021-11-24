@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Collect Payment</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('collect_payments.collect_payment.index') }}" class="btn btn-primary" title="Show All Collect Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Collect Payment
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('collect_payments.collect_payment.store') }}" accept-charset="UTF-8" id="create_collect_payment_form" name="create_collect_payment_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('master.collect_payments.form', ['collectPayment' => null ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


