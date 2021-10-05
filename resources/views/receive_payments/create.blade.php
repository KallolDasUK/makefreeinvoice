@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-ledger-create-form')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New Receive Payment</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('receive_payments.receive_payment.index') }}" class="btn btn-primary"
                   title="Show All Receive Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Receive Payment
                </a>
            </div>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('receive_payments.receive_payment.store') }}" accept-charset="UTF-8"
                  id="create_receive_payment_form" name="create_receive_payment_form" class="form-horizontal"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('receive_payments.form', ['receivePayment' => null])

                <div class="form-group mb-4">
                    <div class="">
                        <input class="btn btn-primary btn-lg float-right mr-4" type="submit" id="addPayment" disabled
                               value="Add Payment">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('js')
    <script>
        var customerInvoiceUrl = "{{ route('receive-payment-customers-invoice') }}"
        var customer_id = "{{ $customer_id }}";
        var create = true;
        $(document).ready(function () {
            $('#customer_id').select2()
            $('#payment_method_id').select2()
            $('#deposit_to').select2()
            setTimeout(() => {
                if (customer_id) {
                    $('#customer_id').val(customer_id).trigger('change')
                }else{

                    $('#customer_id').select2('open')
                }
            }, 100)

        })
    </script>

    <script src="{{ asset('js/payment/receive-payments.js') }}?v=1.4"></script>
@endsection
