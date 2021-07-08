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
                @include ('taxes.form', ['tax' => null])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


