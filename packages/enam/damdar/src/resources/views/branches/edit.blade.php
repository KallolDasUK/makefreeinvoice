@extends('acc::layouts.app')


@section('content')

    <div class="card card-default">

        <div class="card-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('branches.branch.index') }}" class="btn btn-primary mr-2" title="Show All Branch">
                    <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                    Show All Branch

                </a>

                <a href="{{ route('branches.branch.create') }}" class="btn btn-success" title="Create New Branch">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Branch
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

            <form method="POST" action="{{ route('branches.branch.update', $branch->id) }}" id="edit_branch_form" name="edit_branch_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('acc::branches.form', ['branch' => $branch,])

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
        })
    </script>
@endsection
