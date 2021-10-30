@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left"></h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('productions.production.index') }}" class="btn btn-primary"
                   title="Show All Production">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Production
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('productions.production.store') }}" accept-charset="UTF-8"
                  id="create_production_form" name="create_production_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('productions.form', ['production' => null])

                <div class="form-group">
                    <div class="">
                        <input class="btn btn-primary" type="submit" value="Add" style="width: 200px">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


@section('js')
    <script>
        var sample_item = {
            product_id: '', qnt: ''
        };
        var products = @json($products);
        var production_items = [jQuery.extend(true, {}, sample_item)];
        var used_items = [jQuery.extend(true, {}, sample_item)];

    </script>
    <script src="{{ asset('js/production.js') }}"></script>
@endsection
