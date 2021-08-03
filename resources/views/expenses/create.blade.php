@extends('acc::layouts.app')

@section('content')

    <div class="float-left">
        <h2>Add an Expense</h2>
    </div>
    <div class="text-right">
        <a href="{{ route('expenses.expense.index') }}" class="btn btn-primary " title="Show All Expenses">
            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
            My Expense List
        </a>
    </div>
    <p class="clearfix"></p>
    <div class="card">


        <div class="card-body">


            <form method="POST" action="{{ route('expenses.expense.store') }}" accept-charset="UTF-8"
                  id="create_expense_form" name="create_expense_form" class="form-horizontal"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('expenses.form', ['expense' => null])

                <div class="form-group">
                    <div class="float-right">
                        <input class="btn btn-primary btn-lg " type="submit" value="SAVE">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('#ledger_id').select2()
            $('#vendor_id').select2()
            $('#customer_id').select2()
        })
    </script>
    <script src="{{ asset('js/expenses/expense.js') }}"></script>
    <script src="{{ asset('js/expenses/expense-crud.js') }}"></script>
@endsection
