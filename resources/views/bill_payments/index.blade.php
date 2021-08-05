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

            <h5 class="my-1 float-left">Receive Payments</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('receive_payments.receive_payment.create') }}" class="btn btn-success"
                   title="Create New Receive Payment">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Receive Payment
                </a>
            </div>

        </div>

        @if(count($receivePayments) == 0)
            <div class="card-body text-center">
                <h4>No Receive Payments Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Payment Sl</th>
                            <th>Customer</th>
                            <th>Invoices</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($receivePayments as $receivePayment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $receivePayment->payment_sl }}</td>
                                <td>{{ optional($receivePayment->customer)->name }}</td>
                                <td>{{ $receivePayment->invoice }}</td>
                                <td>{{ $receivePayment->payment_date }}</td>
                                <td>{{ optional($receivePayment->paymentMethod)->name }}</td>
                                <td>{{ $receivePayment->amount }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('receive_payments.receive_payment.destroy', $receivePayment->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <a href="{{ route('receive_payments.receive_payment.show', $receivePayment->id ) }}"
                                               title="Show Receive Payment">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>

                                            <a href="{{ route('receive_payments.receive_payment.edit', $receivePayment->id ) }}"
                                               class="mx-4" title="Edit Receive Payment">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Receive Payment"
                                                    onclick="return confirm(&quot;Click Ok to delete Receive Payment.&quot;)">
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
                {!! $receivePayments->links() !!}
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


