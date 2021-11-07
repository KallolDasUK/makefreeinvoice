@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('stock_entries.stock_entry.index') }}" class="btn btn-primary  {{  ability(\App\Utils\Ability::STOCK_ENTRY_READ) }}" title="Show All Stock Entry">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Stock Entry
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('stock_entries.stock_entry.store') }}" accept-charset="UTF-8" id="create_stock_entry_form" name="create_stock_entry_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('stock_entries.form', [
                                        'stockEntry' => null,
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

@section('js')
    <script>
        var sample_item = {
            product_id: '', qnt: ''
        };
        var products = @json($products);
        var items = [jQuery.extend(true, {}, sample_item)];
        var edit = false;

    </script>
    <script src="{{ asset('js/stock-entry.js') }}"></script>
@endsection

