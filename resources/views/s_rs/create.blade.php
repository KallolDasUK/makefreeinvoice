@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('s_rs.s_r.index') }}" class="btn btn-primary" title="Show All S R">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All S R
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('s_rs.s_r.store') }}" accept-charset="UTF-8" id="create_s_r_form" name="create_s_r_form" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include ('s_rs.form', [
                                        'sR' => null,
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


