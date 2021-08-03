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

            <h2 class="my-1 float-left">Expenses</h2>

            <div class="btn-group btn-group-sm float-right btn-lg" role="group">
                <a href="{{ route('expenses.expense.create') }}" class="btn btn-success" title="Create New Expense"
                   style="font-size:  20px">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create an Expense
                </a>
            </div>

        </div>

        @if(count($expenses) == 0)
            <div class="card-body text-center">
                <h4>No Expenses Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div>
                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Ref#</th>
                            <th>Paid Through</th>
                            <th>Vendor</th>
                            <th>Customer</th>

                            <th>Is Billable</th>
                            <th>Amount</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $expense)
                            <tr class="text-dark-75 font-weight-bolder">
                                <td class="text-dark-75 font-weight-bolder font-size-lg">{{ $loop->iteration }}</td>
                                <td class="text-dark-75 font-weight-bolder font-size-lg"> <a href="{{ route('expenses.expense.show',$expense->id) }}">{{ $expense->date }}</a>
                                </td>
                                <td><a href="{{ route('expenses.expense.show',$expense->id) }}">{{ $expense->ref }}</a>
                                </td>

                                <td>{{ optional($expense->ledger)->id }}</td>
                                <td>{{ optional($expense->vendor)->name }}</td>
                                <td>{{ optional($expense->customer)->name }}</td>
                                <td>{{ ($expense->is_billable) ? 'BILLABLE' : 'NON-BILLABLE' }}</td>
                                <td>{{ decent_format($expense->amount ) }}</td>
                                <td>

                                    <form method="POST" action="{!! route('expenses.expense.destroy', $expense->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('expenses.expense.show', $expense->id ) }}"
                                               title="Show Expense">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('expenses.expense.edit', $expense->id ) }}" class="mx-4"
                                               title="Edit Expense">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Expense"
                                                    onclick="return confirm(&quot;Click Ok to delete Expense.&quot;)">
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
                {!! $expenses->render() !!}
            </div>

        @endif

    </div>
@endsection

@section('scripts')

    <script>

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


