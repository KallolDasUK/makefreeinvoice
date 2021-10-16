@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">


            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('s_rs.s_r.index') }}" class="btn btn-primary mr-2" title="Show All S R">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All S R
                </a>

                <a href="{{ route('s_rs.s_r.create') }}" class="btn btn-success" title="Create New S R">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New S R
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

            <form method="POST" action="{{ route('s_rs.s_r.update', $sR->id) }}" id="edit_s_r_form" name="edit_s_r_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('s_rs.form', [
                                        'sR' => $sR,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
