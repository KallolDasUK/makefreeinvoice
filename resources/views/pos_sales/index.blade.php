@extends('layouts.pos_layout')

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

            <h5 class="my-1 float-left">Pos Sales</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('pos_sales.pos_sale.create') }}" class="btn btn-success" title="Create New Pos Sale">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Pos Sale
                </a>
            </div>

        </div>

        @if(count($posSales) == 0)
            <div class="card-body text-center">
                <h4>No Pos Sales Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Pos Number</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Branch</th>
                            <th>Ledger</th>
                            <th>Discount Type</th>
                            <th>Discount</th>
                            <th>Vat</th>
                            <th>Service Charge Type</th>
                            <th>Service Charge</th>
                            <th>Payment Method</th>
                            <th>Sub Total</th>
                            <th>Total</th>
                            <th>Payment Amount</th>
                            <th>Due</th>
                            <th>Pos Status</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posSales as $posSale)
                            <tr>
                                <td>{{ $posSale->pos_number }}</td>
                                <td>{{ $posSale->date }}</td>
                                <td>{{ optional($posSale->customer)->name }}</td>
                                <td>{{ optional($posSale->branch)->id }}</td>
                                <td>{{ optional($posSale->ledger)->id }}</td>
                                <td>{{ $posSale->discount_type }}</td>
                                <td>{{ $posSale->discount }}</td>
                                <td>{{ $posSale->vat }}</td>
                                <td>{{ $posSale->service_charge_type }}</td>
                                <td>{{ $posSale->service_charge }}</td>
                                <td>{{ optional($posSale->ledger)->id }}</td>
                                <td>{{ $posSale->sub_total }}</td>
                                <td>{{ $posSale->total }}</td>
                                <td>{{ $posSale->payment_amount }}</td>
                                <td>{{ $posSale->due }}</td>
                                <td>{{ $posSale->pos_status }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('pos_sales.pos_sale.destroy', $posSale->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('pos_sales.pos_sale.show', $posSale->id ) }}"
                                               title="Show Pos Sale">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('pos_sales.pos_sale.edit', $posSale->id ) }}" class="mx-4"
                                               title="Edit Pos Sale">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Pos Sale"
                                                    onclick="return confirm(&quot;Click Ok to delete Pos Sale.&quot;)">
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
                {!! $posSales->render() !!}
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


