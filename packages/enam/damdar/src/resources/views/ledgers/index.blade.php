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
                <a href="{{ route('ledgers.ledger.create') }}" class="btn btn-success" title="Create New Ledger">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Ledger
                </a>

            </div>
            <div class="btn-group btn-group-sm float-right mx-2" role="group">
                <a href="{{ route('ledgers.ledger.trash') }}" class="btn btn-danger" title="Create New Ledger">
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
                <div >

                    <table class="table table-bordered table-striped ">
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

                                    <form method="POST" action="{!! route('ledgers.ledger.destroy', $ledger->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs float-right" role="group">
                                            <a href="{{ route('ledgers.ledger.show', $ledger->id ) }}"
                                               class="btn btn-info mr-2" title="Show Ledger">

                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('ledgers.ledger.edit', $ledger->id ) }}"
                                               class="btn btn-primary  mr-2" title="Edit Ledger">
                                                <span class="mdi mdi-pencil" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Ledger"
                                                    onclick="return confirm(&quot;Click Ok to delete Ledger.&quot;)">
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
            $('.table').dataTable({"order": [] });
            $('a[title="Create New Ledger"]').focus()

        })
    </script>
@endsection
