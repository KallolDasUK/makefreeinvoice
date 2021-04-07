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

    <div class="card card-default">

        <div class="card-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('branches.branch.trash') }}" class="btn btn-danger" title="Create New Branch">
                    <span class="mdi mdi-trash-can" aria-hidden="true"></span>
                    Trashed ({{ \Enam\Acc\Models\Branch::onlyTrashed()->count() }})
                </a><a href="{{ route('branches.branch.create') }}" class="btn btn-success mx-2"
                       title="Create New Branch">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Branch
                </a>
            </div>

        </div>

        @if(count($branches) == 0)
            <div class="card-body text-center">
                <h4>No Branches Available.</h4>
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

                                    <form method="POST" action="{!! route('branches.branch.destroy', $branch->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs float-right" role="group">
                                            <a href="{{ route('branches.branch.show', $branch->id ) }}"
                                               class="btn btn-info mr-2" title="Show Branch">

                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('branches.branch.edit', $branch->id ) }}"
                                               class="btn btn-primary  mr-2" title="Edit Branch">
                                                <span class="mdi mdi-pencil" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Branch"
                                                    onclick="return confirm(&quot;Click Ok to delete Branch.&quot;)">
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
            $('.table').dataTable({    "order": []
            });
        })
    </script>
@endsection
