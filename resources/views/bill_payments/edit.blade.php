@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-ledger-create-form')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">{{ !empty($title) ? $title : 'Bill Payment' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('bill_payments.bill_payment.index') }}" class="btn btn-primary mr-2 {{ ability(\App\Utils\Ability::PAY_BILL_READ) }}"
                   title="Show All Bill Payment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Bill Payment
                </a>

                <a href="{{ route('bill_payments.bill_payment.create') }}" class="btn btn-success {{ ability(\App\Utils\Ability::PAY_BILL_CREATE) }}"
                   title="Create New Bill Payment">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Bill Payment
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

            <form method="POST" action="{{ route('bill_payments.bill_payment.update', $billPayment->id) }}"
                  id="edit_bill_payment_form" name="edit_bill_payment_form" accept-charset="UTF-8"
                  class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('bill_payments.form', ['billPayment' => $billPayment ])

                <div class="form-group">
                        <button class="btn btn-primary btn-lg float-right mr-4" type="submit" >Confirm Update</button>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('js')
    <script>
        var vendorBillUrl = "{{ route('vendor_unpaid_bills') }}"
        var create = false;
        $(document).ready(function () {
            $('#vendor_id').select2()
            $('#payment_method_id').select2()
            $('#ledger_id').select2()
        })
    </script>

    <script src="{{ asset('js/payment/bill-payments.js') }}"></script>
@endsection
