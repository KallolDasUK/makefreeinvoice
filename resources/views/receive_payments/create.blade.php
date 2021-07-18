@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Receive Payment</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('receive_payments.receive_payment.index') }}" class="btn btn-primary" title="Show All Receive Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Receive Payment
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('receive_payments.receive_payment.store') }}" accept-charset="UTF-8" id="create_receive_payment_form" name="create_receive_payment_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('receive_payments.form', ['receivePayment' => null])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


