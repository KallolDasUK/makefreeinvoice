@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($title) ? $title : 'Pos Sale' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('pos_sales.pos_sale.index') }}" class="btn btn-primary mr-2" title="Show All Pos Sale">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Pos Sale
                </a>

                <a href="{{ route('pos_sales.pos_sale.create') }}" class="btn btn-success" title="Create New Pos Sale">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Pos Sale
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

            <form method="POST" action="{{ route('pos_sales.pos_sale.update', $posSale->id) }}" id="edit_pos_sale_form" name="edit_pos_sale_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('pos_sales.form', [
                                        'posSale' => $posSale,
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
