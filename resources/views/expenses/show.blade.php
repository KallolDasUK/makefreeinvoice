@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Expense' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('expenses.expense.destroy', $expense->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('expenses.expense.index') }}" class="btn btn-primary mr-2" title="Show All Expense">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Expense
                    </a>

                    <a href="{{ route('expenses.expense.create') }}" class="btn btn-success mr-2" title="Create New Expense">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Expense
                    </a>

                    <a href="{{ route('expenses.expense.edit', $expense->id ) }}" class="btn btn-primary mr-2" title="Edit Expense">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Expense
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Expense" onclick="return confirm(&quot;Click Ok to delete Expense.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Expense
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
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

@endsection
