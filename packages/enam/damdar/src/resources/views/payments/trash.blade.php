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
                <a href="{{ route('payments.payment.trash') }}" class="btn btn-danger mr-2" title="Create New Payment">
                    <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                    Trash({{\Enam\Acc\Models\Transaction::onlyTrashed()->where('txn_type',\Enam\Acc\Utils\VoucherType::$PAYMENT)->count()}}
                    )
                </a> <a href="{{ route('payments.payment.index') }}" class="btn btn-success">
                    <span class="mdi mdi-view-list" aria-hidden="true"></span>
                    All
                    Payments({{ \Enam\Acc\Models\Transaction::query()->where('txn_type',\Enam\Acc\Utils\VoucherType::$PAYMENT)->count() }}
                    )
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
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->date }}</td>


                                <td>
                                    <div class="row float-right">


                                        <form class="col" method="POST"
                                              action="{!! route('payments.payment.restore', $transaction->id) !!}"
                                              accept-charset="UTF-8">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-success" title="Restore"
                                                    onclick="return confirm('Click Ok to restore This Voucher');">
                                                <span class="mdi mdi-restore" aria-hidden="true"></span>
                                            </button>

                                        </form>
                                    </div>

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
