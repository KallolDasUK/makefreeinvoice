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
        <div class="btn-group btn-group-sm float-right" role="group">

            <a href="{{ route('ledger_groups.ledger_group.trash') }}" class="btn btn-danger mx-2"
               title="Trashed Ledger Group">
                <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                Trashed ({{ \Enam\Acc\Models\LedgerGroup::onlyTrashed()->count() }})
            </a>
            <a href="{{ route('ledger_groups.ledger_group.create') }}" class="btn btn-success"
               title="Create New Ledger Group">
                <span class="mdi mdi-plus" aria-hidden="true"></span>
                Create New Ledger Group
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

                                    <form method="POST"
                                          action="{!! route('ledger_groups.ledger_group.destroy', $ledgerGroup->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs float-right" role="group">
                                            <a href="{{ route('ledger_groups.ledger_group.show', $ledgerGroup->id ) }}"
                                               class="btn btn-info mr-2" title="Show Ledger Group">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('ledger_groups.ledger_group.edit', $ledgerGroup->id ) }}"
                                               class="btn btn-primary mr-2" title="Edit Ledger Group">
                                                <span class="mdi mdi-pencil" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Ledger Group"
                                                    onclick="return confirm(&quot;Click Ok to delete Ledger Group.&quot;)">
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
    <!-- plugin js -->
    <script>
        $(document).ready(function () {
            $('.table').dataTable({"order": []});
            $('a[title="Create New Ledger Group"]').focus()
        })
    </script>
@endsection
