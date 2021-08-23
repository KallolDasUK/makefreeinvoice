@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($reason->name) ? $reason->name : 'Reason' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('reasons.reason.index') }}" class="btn btn-primary mr-2" title="Show All Reason">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Reason
                </a>

                <a href="{{ route('reasons.reason.create') }}" class="btn btn-success" title="Create New Reason">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Reason
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

            <form method="POST" action="{{ route('reasons.reason.update', $reason->id) }}" id="edit_reason_form" name="edit_reason_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('reasons.form', [
                                        'reason' => $reason,
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
