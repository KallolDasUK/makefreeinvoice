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

        <div class="card-heading">
            <div class="filters float-left m-2">
                <button class="btn btn-secondary btn-fw dropdown-toggle">
                    <i class="fa fa-filter"></i>
                    Filters
                </button>


            </div>
            <div class="btn-group btn-group-sm float-right m-2" role="group">
                <a href="{{ route('payments.payment.trash') }}" class="btn btn-danger mr-2" title="Create New Payment">
                    <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                    Trash({{\Enam\Acc\Models\Transaction::onlyTrashed()->where('txn_type',\Enam\Acc\Utils\VoucherType::$PAYMENT)->count()}}
                    )
                </a> <a href="{{ route('payments.payment.create') }}" class="btn btn-success"
                        title="Create New Payment">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Payment
                </a>
            </div>
            <p class="clearfix"></p>
            <div class="filter-content border p-2" style="display: none;background: #efefef">
                <form action="" method="get">
                    <div class=" text-dark" style="position:relative;">

                        <div id="dvBranch" class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto">
                            <label class="font-weight-bolder">Select Branch</label>
                            <select name="branch_id" class="col-12 form-control">
                                <option> All</option>

                                @foreach($branches as $id => $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>


                        <div class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12">

                            <div class="row ">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label class="font-weight-bolder" for="inputWarning">From Date</label>
                                    <input type="date" name="start_date" value="{{ $start_date }}"
                                           class="col-xs-12 col-sm-12 col-md-12 col-lg-12 focusColor datePicker form-control hasDatepicker">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label class="font-weight-bolder" for="inputWarning">To Date </label>
                                    <input type="date" name="end_date" value="{{ $end_date }}"
                                           class="col-xs-12 col-sm-12 col-md-12 col-lg-12 focusColor datePicker form-control">
                                </div>

                                <!--End Row-->
                            </div>

                        </div>
                        <br>
                        <div class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto float-right pr-4">


                            <a href="{{ route('payments.payment.index') }}"
                               class="col-lg-3 mx-auto col-xs-12 col-sm-12 col-md-12 btn btn-secondary">Reset
                                Filter</a>

                            <button class="col-lg-3 mx-auto col-xs-12 col-sm-12 col-md-12 btn btn-primary">Apply
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                </form>

            </div>


        </div>

        @if(count($transactions) == 0)
            <div class="card-body text-center">
                <h4>No Transactions Available.</h4>
            </div>
        @else
            <div class="card-body card-body-with-table">
                <div>

                    <table class="table table-striped table-bordered ">
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
                                          action="{!! route('payments.payment.destroy', $transaction->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs float-right" role="group">
                                            <a target="_blank"
                                               href="{{ route('payments.payment.pdf', $transaction->id ) }}"
                                               class="btn btn-inverse-primary mr-2" title="Print Transaction">

                                                <i class="mdi mdi-printer"></i>
                                            </a>
                                            <a href="{{ route('payments.payment.show', $transaction->id ) }}"
                                               class="btn btn-info mr-2" title="Show Transaction">

                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('payments.payment.edit', $transaction->id ) }}"
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
            $('.filters').on('click', function (event) {

                $('.filter-content').toggle()
                // event.stopPropagation();

            })

            // $(window).click(function() {
            //     $('.filter-content').hide()
            // });
        })
    </script>
@endsection
