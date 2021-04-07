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
                <a href="{{ route('ledgers.ledger.index') }}" class="btn btn-success" title="Show Ledger">
                    <span class="mdi mdi-view-list" aria-hidden="true"></span>
                    All({{ \Enam\Acc\Models\Ledger::all()->count() }})
                </a>

            </div>
            <div class="btn-group btn-group-sm float-right mx-2" role="group">
                <a href="{{ route('ledgers.ledger.trash') }}" class="btn btn-danger" title="Trashed Ledger">
                    <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                    Trashed({{ \Enam\Acc\Models\Ledger::onlyTrashed()->count()}})
                </a>

            </div>

        </div>

        @if(count($ledgers) == 0)
            <div class="card-body text-center">
                <h4>No Ledgers Available.</h4>
            </div>
        @else
            <div class="card-body card-body-with-table">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Ledger Name</th>
                            <th>Under</th>
                            <th>Opening</th>
                            <th>Opening Type</th>
                            <th>Active</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ledgers as $ledger)
                            <tr>
                                <td>{{ $ledger->ledger_name }}</td>
                                <td>{{ optional($ledger->ledgerGroup)->group_name }}</td>
                                <td>{{ $ledger->opening }}</td>
                                <td>{{ $ledger->opening_type }}</td>
                                <td>{{ $ledger->active }}</td>

                                <td>

                                    <form method="POST" action="{!! route('ledgers.ledger.restore', $ledger->id) !!}"
                                          accept-charset="UTF-8">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs float-right" role="group">

                                            <button type="submit" class="btn btn-success" title="Delete Ledger"
                                                    onclick="return confirm(&quot;Click Ok to restore Ledger.&quot;)">
                                                <span class="mdi mdi-restore" aria-hidden="true"></span>
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
            $('.table').dataTable({"order": []});
            $('a[title="Create New Ledger"]').focus()

        })
    </script>
@endsection
