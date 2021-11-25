@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Payment Request</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('payment_requests.payment_request.index') }}" class="btn btn-primary" title="Show All Payment Request">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Payment Request
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('payment_requests.payment_request.store') }}" accept-charset="UTF-8" id="create_payment_request_form" name="create_payment_request_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('master.payment_requests.form', ['paymentRequest' => null])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


