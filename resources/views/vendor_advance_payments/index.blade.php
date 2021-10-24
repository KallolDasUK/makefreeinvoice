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

            <h5 class="my-1 float-left">Vendor Advance Payments</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('vendor_advance_payments.vendor_advance_payment.create') }}" class="btn btn-success"
                   title="Create New Vendor Advance Payment">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Vendor Advance Payment
                </a>
            </div>

        </div>

        @if(count($vendorAdvancePayments) == 0)
            <div class="card-body text-center">
                <h4>No Vendor Advance Payments Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Vendor</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Date</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vendorAdvancePayments as $vendorAdvancePayment)
                            <tr>
                                <td>{{ (($vendorAdvancePayments->currentPage() - 1) * $vendorAdvancePayments->perPage()) + $loop->iteration }}</td>

                                <td>{{ optional($vendorAdvancePayment->vendor)->name }}</td>
                                <td>{{ optional($vendorAdvancePayment->ledger)->ledger_name }}</td>
                                <td>{{ $vendorAdvancePayment->amount }}</td>
                                <td>{{ $vendorAdvancePayment->date }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('vendor_advance_payments.vendor_advance_payment.destroy', $vendorAdvancePayment->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <a href="{{ route('vendor_advance_payments.vendor_advance_payment.edit', $vendorAdvancePayment->id ) }}"
                                               class="mx-4" title="Edit Vendor Advance Payment">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Vendor Advance Payment"
                                                    onclick="return confirm(&quot;Click Ok to delete Vendor Advance Payment.&quot;)">
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
                {!! $vendorAdvancePayments->render() !!}
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


