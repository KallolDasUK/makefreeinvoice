@extends('acc::layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Bill Payments</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('bill_payments.bill_payment.create') }}" class="btn btn-success {{ ability(\App\Utils\Ability::PAY_BILL_CREATE) }}"
                   title="Create New Bill Payment">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Bill Payment
                </a>
            </div>

        </div>

        @if(count($billPayments) == 0)
            <div class="card-body text-center">
                <h4>No Bill Payments Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div>
                    <table class=" table mb-0  table-head-custom table-vertical-center ">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Payment Sl</th>
                            <th>Vendor</th>
                            <th>Bills</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="font-weight-bolder" style="font-size: 14px">
                        @foreach($billPayments as $billPayment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $billPayment->payment_sl }}</td>
                                <td>{{ optional($billPayment->vendor)->name }}</td>
                                <td>{{ $billPayment->bill }}</td>

                                <td>{{ $billPayment->payment_date }}</td>
                                <td>{{ optional($billPayment->ledger)->ledger_name }}</td>
                                <td>{{ $billPayment->amount }}</td>
                                <td>

                                    <form method="POST"
                                          action="{!! route('bill_payments.bill_payment.destroy', $billPayment->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <a href="{{ route('bill_payments.bill_payment.edit', $billPayment->id ) }}"
                                               class="mx-4 btn  disabled {{ ability(\App\Utils\Ability::PAY_BILL_EDIT) }}" title="Edit Bill Payment">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit"
                                                    title="Delete Bill Payment"
                                                    class="btn"
                                                    {{ ability(\App\Utils\Ability::PAY_BILL_DELETE) }}
                                                    onclick="return confirm(&quot;Click Ok to delete Bill Payment.&quot;)">
                                                <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card-footer">
                {!! $billPayments->render() !!}
            </div>

        @endif

    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('table').DataTable({
                responsive: true,
                "order": [],
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]

            });
        });
    </script>

    <style>
        .dataTables_filter {
            float: right;
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection


