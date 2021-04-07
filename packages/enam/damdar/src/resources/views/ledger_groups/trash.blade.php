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
    @if(Session::has('unexpected_error'))
        <div class="alert alert-danger">
            <span class="mdi mdi-information-outline"></span>
            {!! session('unexpected_error') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div>
        <div class="btn-group btn-group-sm float-right" role="group" >

            <a href="{{ route('ledger_groups.ledger_group.trash') }}" class="btn btn-danger mx-2"
               title="Trashed Ledger Group">
                <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                Trashed ({{ \Enam\Acc\Models\LedgerGroup::onlyTrashed()->count() }})
            </a>
            <a href="{{ route('ledger_groups.ledger_group.index') }}" class="btn btn-success"
               title="Show All Ledger Group">
                <span class="mdi mdi-view-list" aria-hidden="true"></span>
                All ({{ \Enam\Acc\Models\LedgerGroup::all()->count() }})
            </a>
        </div>

    </div>

    <div class="card">

        <div class="card-heading clearfix">


        </div>

        @if(count($ledgerGroups) == 0)
            <div class="card-body text-center">
                <h4>No Ledger Groups Available.</h4>
            </div>
        @else
            <div class="card-body panel-body-with-table">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Group Name</th>
                            <th>Parent</th>
                            <th>Nature</th>
                            <th>Cashflow Type</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ledgerGroups as $ledgerGroup)
                            <tr>
                                <td>{{ $ledgerGroup->id }}</td>
                                <td>{{ $ledgerGroup->group_name }}</td>
                                <td>{{ $ledgerGroup->under() }}</td>
                                <td>{{ $ledgerGroup->nature }}</td>
                                <td>{{ $ledgerGroup->cashflow_type }}</td>

                                <td>

                                    <form method="POST" action="{!! route('ledger_groups.ledger_group.restore', $ledgerGroup->id) !!}"
                                          accept-charset="UTF-8">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs float-right" role="group">

                                            <button type="submit" class="btn btn-success" title="Restore Ledger Group"
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
    <!-- plugin js -->
    <script>
        $(document).ready(function () {
            $('.table').dataTable({"order": []});
            $('a[title="Create New Ledger Group"]').focus()
        })
    </script>
@endsection
