@extends('acc::layouts.app')

@section('content')

    <div class="card mx-auto" style="width: 50%">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New Tax</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('taxes.tax.index') }}" class="btn btn-primary" title="Show All Tax">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Tax
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('taxes.tax.store') }}" accept-charset="UTF-8" id="create_tax_form"
                  name="create_tax_form" class="form-horizontal">
                {{ csrf_field() }}
                <textarea name="content" id="content" cols="30" rows="10"></textarea>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('js')

    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
    <script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>

    <script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>

    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <script>
        Laraberg.init('content')

    </script>
@endsection
