@extends('acc::layouts.app')

@section('content')

    <div>
        <div>

            <h5 class="my-1 float-left">{{ isset($title) ? $title : 'Expense' }}</h5>

            <div class="float-right">

                <form method="POST" action="{!! route('expenses.expense.destroy', $expense->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('expenses.expense.index') }}" class="btn btn-primary mr-2"
                           title="Show All Expense">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Expense
                        </a>

                        <a href="{{ route('expenses.expense.create') }}" class="btn btn-success mr-2"
                           title="Create New Expense">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Expense
                        </a>

                        <a href="{{ route('expenses.expense.edit', $expense->id ) }}" class="btn btn-primary mr-2"
                           title="Edit Expense">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Expense
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Expense"
                                onclick="return confirm(&quot;Click Ok to delete Expense.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Expense
                        </button>
                    </div>
                </form>

            </div>

        </div>
        <p class="clearfix"></p>
        <div class=" mx-auto" style="width: 400px">
            <div class="card">
                <div class="card-body text-center">
                    <h2> Expense Receipt</h2>
                    @if($settings->business_logo??false)
                        <img
                            class="rounded text-center mx-auto"
                            src="{{ asset('storage/'.$settings->business_logo) }}"
                            width="100"
                            alt="">
                    @endif
                    <address class="">
                        <h5 class="m-0 p-0">{{ $settings->business_name??'n/a' }}</h5>
                        @if($settings->street_1??'')
                            {{ $settings->street_1??'' }}
                        @endif
                        @if($settings->street_2??'')
                            <br> {{ $settings->street_2??'' }}
                        @endif
                        @if(($settings->state??'') || ($settings->zip_post??'') )
                            <br> {{ $settings->state??'' }} {{ $settings->zip_post??'' }}
                        @endif
                        @if($settings->email??'')
                            <br> {{ $settings->email??'' }}
                        @endif
                        @if($settings->phone??'')
                            <br> {{ $settings->phone??'' }}
                        @endif
                    </address>
                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Amount</th>
                        </tr>
                        @foreach($expense->expense_items as $expense_item)
                            <tr>
                                <td class="">{{ $loop->iteration }}</td>
                                <td>{{ $expense_item->ledger->ledger_name??'' }}</td>
                                <td>{{ $expense_item->amount }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>Taxable Amount</td>
                            <td>{{ decent_format($expense->taxable_amount) }}</td>
                        </tr>
                    </table>
                    <br>
                    <div class="row">
                        <div class="col"><h2>Total Amount</h2></div>
                        <div class="col text-right"><h2>{{ decent_format($expense->amount) }}</h2></div>
                    </div>

                    <dl class="dl-horizontal d-none">
                        <dt>Date</dt>
                        <dd>{{ $expense->date }}</dd>
                        <dt>Paid Through</dt>
                        <dd>{{ optional($expense->ledger)->id }}</dd>
                        <dt>Vendor</dt>
                        <dd>{{ optional($expense->vendor)->name }}</dd>
                        <dt>Customer</dt>
                        <dd>{{ optional($expense->customer)->name }}</dd>
                        <dt>Ref#</dt>
                        <dd>{{ $expense->ref }}</dd>
                        <dt>Is Billable</dt>
                        <dd>{{ ($expense->is_billable) ? 'Yes' : 'No' }}</dd>
                        <dt>File</dt>
                        <dd>{{ asset('storage/' . $expense->file) }}</dd>

                    </dl>

                </div>
            </div>
        </div>


    </div>

@endsection
