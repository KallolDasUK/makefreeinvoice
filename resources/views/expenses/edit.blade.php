@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($title) ? $title : 'Expense' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('expenses.expense.index') }}" class="btn btn-primary mr-2" title="Show All Expense">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Expense
                </a>

                <a href="{{ route('expenses.expense.create') }}" class="btn btn-success" title="Create New Expense">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Expense
                </a>

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('expenses.expense.update', $expense->id) }}" id="edit_expense_form" name="edit_expense_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('expenses.form', [ 'expense' => $expense])

                <div class="form-group">
                    <div class="float-right">
                        <input class="btn btn-primary btn-lg" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('js')
    <script>
        var sample_expense = {ledger_id: '', notes: '', tax_id: '', amount: ''};
        var expense_items = @json($expense_items);
        var ledgers = @json($ledgers);
        var taxes = @json($taxes);
        console.log(ledgers,taxes)
        $(document).ready(function () {
            $('#ledger_id').select2()
            $('#vendor_id').select2()
            $('#customer_id').select2()


        })
    </script>
    <script src="{{ asset('js/expenses/expense.js') }}"></script>
    <script src="{{ asset('js/expenses/expense-crud.js') }}"></script>
@endsection
