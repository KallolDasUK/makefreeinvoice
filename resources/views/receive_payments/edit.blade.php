@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-ledger-create-form')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($title) ? $title : 'Receive Payment' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('receive_payments.receive_payment.index') }}" class="btn btn-primary mr-2 {{  ability(\App\Utils\Ability::RECEIVE_PAYMENT_READ) }}" title="Show All Receive Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Receive Payment
                </a>

                <a href="{{ route('receive_payments.receive_payment.create') }}" class="btn btn-success {{  ability(\App\Utils\Ability::RECEIVE_PAYMENT_CREATE) }}" title="Create New Receive Payment">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Receive Payment
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

            <form method="POST" action="{{ route('receive_payments.receive_payment.update', $receivePayment->id) }}" id="edit_receive_payment_form" name="edit_receive_payment_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('receive_payments.form', [
                                        'receivePayment' => $receivePayment,
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
@section('js')
    <script>
        var customerInvoiceUrl = "{{ route('receive-payment-customers-invoice') }}"
        var create = false;
        $(document).ready(function () {
            $('#customer_id').select2()
            $('#payment_method_id').select2()
            $('#deposit_to').select2()
        })
    </script>

    <script src="{{ asset('js/payment/receive-payments.js') }}"></script>
@endsection
