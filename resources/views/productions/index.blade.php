UJ@extends('acc::layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left"></h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('productions.production.create') }}" class="btn btn-success {{  ability(\App\Utils\Ability::PRODUCTION_CREATE) }}"
                   title="Create New Production">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Production
                </a>
            </div>

        </div>

        @if(count($productions) == 0)
            <div class="card-body text-center">
                <h4>No Productions Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div>
                    <table class="table table-head-custom table-vertical-center font-weight-bolder"
                           style="font-size: 20px">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Ref</th>
                            <th>Date</th>
                            <th>Production Status</th>
                            <th>Notes</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productions as $production)
                            <tr>
                                <td>{{ (($productions->currentPage() - 1) * $productions->perPage()) + $loop->iteration }}</td>

                                <td>{{ $production->ref }}</td>
                                <td>{{ $production->date }}</td>
                                <td>{{ $production->status }}</td>
                                @if($production->note)
                                    <td style="font-size: 12px">{{ $production->note }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>

                                    <form method="POST"
                                          action="{!! route('productions.production.destroy', $production->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <a href="{{ route('productions.production.edit', $production->id ) }}"
                                               class="mx-4" title="Edit Production">
                                                <i class="fas fa-edit text-primary {{  ability(\App\Utils\Ability::PRODUCTION_EDIT) }}" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" {{  ability(\App\Utils\Ability::PRODUCTION_READ) }}
                                                    title="Delete Production"
                                                    onclick="return confirm('Click Ok to delete Production.')">
                                                <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
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

            <div class="card-footer">
                {!! $productions->render() !!}
            </div>

        @endif

    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('table').DataTable({
                responsive: true,
                "order": [],
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]

            });
        });
    </script>

    <style>
        .dataTables_filter {
            float: right;
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection


