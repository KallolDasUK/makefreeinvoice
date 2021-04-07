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
                <a href="{{ route('branches.branch.trash') }}" class="btn btn-danger" title="Create New Branch">
                    <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                    Trashed ({{ \Enam\Acc\Models\Branch::onlyTrashed()->count() }})
                </a><a href="{{ route('branches.branch.index') }}" class="btn btn-success mx-2"
                       title="Create New Branch">
                    <span class="mdi mdi-view-list" aria-hidden="true"></span>
                    All ({{ \Enam\Acc\Models\Branch::query()->count() }})
                </a>
            </div>

        </div>

        @if(count($branches) == 0)
            <div class="card-body text-center">
                <h4>Trash is empty</h4>
            </div>
        @else
            <div class="card-body card-body-with-table">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($branches as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->location }}</td>

                                <td>
                                    <div class="row float-right">


                                        <form class="col" method="POST"
                                              action="{!! route('branches.branch.restore', $branch->id) !!}"
                                              accept-charset="UTF-8">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-success" title="Restore Branch"
                                                    onclick="return confirm('Click Ok to restore Branch');">
                                                <span class="mdi mdi-restore" aria-hidden="true"></span>
                                            </button>

                                        </form>
                                        <form class="col" method="POST"
                                              action="{!! route('branches.branch.destroy', [$branch->id,'hard'=>true]) !!}"
                                              accept-charset="UTF-8">
                                            <input name="_method" value="DELETE" type="hidden">

                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger" title="Delete Branch"
                                                    onclick="return confirm('Click Ok to permanently remove Branch');">
                                                <span class="mdi mdi-delete" aria-hidden="true"></span>
                                            </button>

                                        </form>


                                    </div>

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
            $('.table').dataTable({
                "order": []
            });
        })
    </script>
@endsection
