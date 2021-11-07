@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">{{ !empty($title) ? $title : 'Production' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('productions.production.index') }}" class="btn btn-primary mr-2  {{  ability(\App\Utils\Ability::PRODUCTION_READ) }}"
                   title="Show All Production">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Production
                </a>

                <a href="{{ route('productions.production.create') }}" class="btn btn-success {{  ability(\App\Utils\Ability::PRODUCTION_CREATE) }}"
                   title="Create New Production">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Production
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

            <form method="POST" action="{{ route('productions.production.update', $production->id) }}"
                  id="edit_production_form" name="edit_production_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('productions.form', [
                                            'production' => $production,
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

@section('js')
    <script>
        var sample_item = {
            product_id: '', qnt: ''
        };
        var products = @json($products);
        var copiedObject = jQuery.extend(true, {}, sample_item)
        var production_items = @json($production->production_items);
        var used_items =  @json($production->used_items);


    </script>
    <script src="{{ asset('js/production.js') }}"></script>
@endsection
