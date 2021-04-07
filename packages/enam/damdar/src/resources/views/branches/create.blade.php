@extends('acc::layouts.app')

@section('content')

    <div class="card card-default">

        <div class="card-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('branches.branch.index') }}" class="btn btn-primary" title="Show All Branch">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    Show All Branch
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

            <form method="POST" action="{{ route('branches.branch.store') }}" accept-charset="UTF-8" id="create_branch_form" name="create_branch_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('acc::branches.form', [
                                        'branch' => null,
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


