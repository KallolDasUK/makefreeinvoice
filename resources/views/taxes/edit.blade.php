@extends('acc::layouts.app')

@section('content')

    <div class="card mx-auto" style="width: 50%">

        <div class="card-header">

            <h5 class="my-1 float-left">{{ !empty($tax->name) ? $tax->name : 'Tax' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('taxes.tax.index') }}" class="btn btn-primary mr-2" title="Show All Tax">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Tax
                </a>

                <a href="{{ route('taxes.tax.create') }}" class="btn btn-success" title="Create New Tax">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Tax
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

            <form method="POST" action="{{ route('taxes.tax.update', $tax->id) }}" id="edit_tax_form"
                  name="edit_tax_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('taxes.form', [
                                            'tax' => $tax,
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


