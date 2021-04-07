@extends('acc::layouts.app')


@section('content')

    <div class="card card-default">

        <div class="card-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('ledgers.ledger.index') }}" class="btn btn-primary mr-2" title="Show All Ledger">
                    <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                    Show All Ledger

                </a>

                <a href="{{ route('ledgers.ledger.create') }}" class="btn btn-success" title="Create New Ledger">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Ledger
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

            <form method="POST" action="{{ route('ledgers.ledger.update', $ledger->id) }}" id="edit_ledger_form"
                  name="edit_ledger_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('acc::ledgers.form', [
                                            'ledger' => $ledger,
                                          ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.table').dataTable();
            $('#ledger_name').focus()

            $('#ledger_group_id').select2();

        })
    </script>

@endsection
