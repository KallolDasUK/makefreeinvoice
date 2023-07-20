@extends('master.master-layout')

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

            <h5 class="my-1 float-left">Collect Payments</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('collect_payments.collect_payment.create') }}" class="btn btn-success"
                   title="Create New Collect Payment">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Collect Payment
                </a>
            </div>

        </div>

        @if(count($collectPayments) == 0)
            <div class="card-body text-center">
                <h4>No Collect Payments Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table  table-sm" id="myTable" >
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>For Month</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Referred By</th>
                            <th>Referred By Amount</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($collectPayments as $collectPayment)
                            <tr>
                                <td>{{ $collectPayment->date }}</td>
                                <td>{{ $collectPayment->for_month }}</td>
                                <td>{{ optional($collectPayment->user)->name }}</td>
                                <td>{{ $collectPayment->amount }}</td>
                                <td>{{ optional($collectPayment->referred)->name }}</td>
                                <td>{{ $collectPayment->referred_by_amount }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('collect_payments.collect_payment.destroy', $collectPayment->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('collect_payments.collect_payment.show', $collectPayment->id ) }}"
                                               title="Show Collect Payment">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('collect_payments.collect_payment.edit', $collectPayment->id ) }}"
                                               class="mx-4" title="Edit Collect Payment">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Collect Payment"
                                                    onclick="return confirm(&quot;Click Ok to delete Collect Payment.&quot;)">
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
                {!! $collectPayments->render() !!}
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


