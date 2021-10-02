@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-ledger-create-form')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New Bill Payment</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('bill_payments.bill_payment.index') }}" class="btn btn-primary"
                   title="Show All Bill Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Bill Payment
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('bill_payments.bill_payment.store') }}" accept-charset="UTF-8"
                  id="create_bill_payment_form" name="create_bill_payment_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('bill_payments.form', ['billPayment' => null])

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
        var vendorBillUrl = "{{ route('vendor_unpaid_bills') }}"
        var create = true;
        var vendor_id = "{{ $vendor_id}}";
        $(document).ready(function () {
            $('#vendor_id').select2()
            $('#payment_method_id').select2()
            $('#ledger_id').select2()
            setTimeout(() => {
                if (vendor_id) {
                    $('#vendor_id').val(vendor_id).trigger('change')
                } else {
                    $('#vendor_id').select2('open')
                }
            }, 100)
        })
    </script>

    <script src="{{ asset('js/payment/bill-payments.js') }}"></script>
@endsection
