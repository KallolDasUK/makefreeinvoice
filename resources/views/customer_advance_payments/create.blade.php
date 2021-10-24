@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New Customer Advance Payment</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('customer_advance_payments.customer_advance_payment.index') }}"
                   class="btn btn-primary" title="Show All Customer Advance Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Customer Advance Payment
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('customer_advance_payments.customer_advance_payment.store') }}"
                  accept-charset="UTF-8" id="create_customer_advance_payment_form"
                  name="create_customer_advance_payment_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('customer_advance_payments.form', [
                                            'customerAdvancePayment' => null,
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

@section('js')
    <script>
        $(document).ready(function () {
            let customer_id = "{{ $customer_id }}"
            if (customer_id) {
                $('#customer_id').val(customer_id).trigger('change')
                $('#amount').focus()

            }
        })
    </script>
@endsection


