@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Payment Method</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('payment_methods.payment_method.index') }}" class="btn btn-primary" title="Show All Payment Method">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Payment Method
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('payment_methods.payment_method.store') }}" accept-charset="UTF-8" id="create_payment_method_form" name="create_payment_method_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('payment_methods.form', [
                                        'paymentMethod' => null,
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


