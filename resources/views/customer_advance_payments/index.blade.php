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

            <h5 class="my-1 float-left">Customer Advance Payments</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('customer_advance_payments.customer_advance_payment.create') }}"
                   class="btn btn-success" title="Create New Customer Advance Payment">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Customer Advance Payment
                </a>
            </div>

        </div>

        @if(count($customerAdvancePayments) == 0)
            <div class="card-body text-center">
                <h4>No Customer Advance Payments Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Customer</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Date</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customerAdvancePayments as $customerAdvancePayment)
                            <tr>
                                <td>{{ (($customerAdvancePayments->currentPage() - 1) * $customerAdvancePayments->perPage()) + $loop->iteration }}</td>

                                <td>{{ optional($customerAdvancePayment->customer)->name }}</td>
                                <td>{{ optional($customerAdvancePayment->ledger)->ledger_name }}</td>
                                <td>{{ $customerAdvancePayment->amount }}</td>
                                <td>{{ $customerAdvancePayment->date }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('customer_advance_payments.customer_advance_payment.destroy', $customerAdvancePayment->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('customer_advance_payments.customer_advance_payment.show', $customerAdvancePayment->id ) }}"
                                               title="Show Customer Advance Payment">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('customer_advance_payments.customer_advance_payment.edit', $customerAdvancePayment->id ) }}"
                                               class="mx-4" title="Edit Customer Advance Payment">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Customer Advance Payment"
                                                    onclick="return confirm(&quot;Click Ok to delete Customer Advance Payment.&quot;)">
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
                {!! $customerAdvancePayments->render() !!}
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


