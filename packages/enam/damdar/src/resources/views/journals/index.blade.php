@extends('acc::layouts.app')


@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="mdi mdi-information-outline"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="card card-default">

        <div class="card-heading clearfix">

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('journals.journal.trash') }}" class="btn btn-danger mr-2">
                    <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                    Trash({{\Enam\Acc\Models\Transaction::onlyTrashed()->where('txn_type',\Enam\Acc\Utils\VoucherType::$JOURNAL)->count()}}
                    )
                </a>
                <a href="{{ route('journals.journal.create') }}" class="btn btn-success" title="Create New Journal">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Journal
                </a>
            </div>

        </div>

        @if(count($transactions) == 0)
            <div class="card-body text-center">
                <h4>No Transactions Available.</h4>
            </div>
        @else
            <div class="card-body card-body-with-table">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Ledger Name</th>
                            <th>Voucher No</th>
                            <th>Branch</th>
                            <th>Amount</th>
                            <th>Voucher Date</th>


                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{  mb_strimwidth($transaction->ledger_name, 0, 30, "...")}}</td>
                                <td>{{ $transaction->voucher_no }}</td>
                                <td>{{  mb_strimwidth(optional($transaction->branch)->name, 0, 30, "...")}}</td>
                                <td>{{ number_format($transaction->amount) }}</td>
                                <td>{{  $transaction->date }}</td>


                                <td>

                                    <form method="POST"
                                          action="{!! route('journals.journal.destroy', $transaction->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs float-right" role="group">
                                            <a target="_blank"
                                               href="{{ route('journals.journal.pdf', $transaction->id ) }}"
                                               class="btn btn-inverse-primary mr-2" title="Print Transaction">

                                                <i class="mdi mdi-printer"></i>
                                            </a>
                                            <a href="{{ route('journals.journal.show', $transaction->id ) }}"
                                               class="btn btn-info mr-2" title="Show Transaction">

                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('journals.journal.edit', $transaction->id ) }}"
                                               class="btn btn-primary  mr-2" title="Edit Transaction">
                                                <span class="mdi mdi-pencil" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Transaction"
                                                    onclick="return confirm(&quot;Click Ok to delete Transaction.&quot;)">
                                                <span class="mdi mdi-delete" aria-hidden="true"></span>
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
            $('.table').dataTable({
                "order": [],
            });
        })
    </script>
@endsection
