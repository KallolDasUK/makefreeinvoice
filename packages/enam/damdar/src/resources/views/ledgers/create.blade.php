@extends('acc::layouts.app')


@section('content')

    <div class="card card-default">

        <div class="card-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('ledgers.ledger.index') }}" class="btn btn-primary" title="Show All Ledger">
                    <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                    Show All Ledger
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

            <form method="POST" action="{{ route('ledgers.ledger.store') }}" accept-charset="UTF-8"
                  id="create_ledger_form" name="create_ledger_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('acc::ledgers.form', [
                                            'ledger' => null,
                                          ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#ledger_name').focus()
            $('#ledger_group_id').select2();
        })
    </script>
@endsection
