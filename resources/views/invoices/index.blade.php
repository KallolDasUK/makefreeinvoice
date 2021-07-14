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

            <h5 class="my-1 float-left">Invoices</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('invoices.invoice.create') }}" class="btn btn-success" title="Create New Invoice">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Invoice
                </a>
            </div>

        </div>

        @if(count($invoices) == 0)
            <div class="card-body text-center">
                <h4>No Invoices Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Invoice Number</th>
                            <th>Customer</th>
                            <th>Order Number</th>
                            <th>Invoice Date</th>
                            <th>Total</th>


                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ optional($invoice->customer)->name }}</td>
                                <td>{{ $invoice->order_number }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->total }}</td>


                                <td>

                                    <form method="POST" action="{!! route('invoices.invoice.destroy', $invoice->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('invoices.invoice.show', $invoice->id ) }}"
                                               title="Show Invoice">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('invoices.invoice.edit', $invoice->id ) }}" class="mx-4"
                                               title="Edit Invoice">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Invoice"
                                                    onclick="return confirm(&quot;Click Ok to delete Invoice.&quot;)">
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



        @endif


    </div>
@endsection

@section('js')

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


