@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Reason</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('reasons.reason.index') }}" class="btn btn-primary" title="Show All Reason">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Reason
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('reasons.reason.store') }}" accept-charset="UTF-8" id="create_reason_form" name="create_reason_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('reasons.form', [
                                        'reason' => null,
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


