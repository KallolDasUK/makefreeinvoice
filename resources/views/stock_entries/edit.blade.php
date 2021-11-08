@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">{{ !empty($title) ? $title : 'Stock Entry' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('stock_entries.stock_entry.index') }}" class="btn btn-primary mr-2  {{  ability(\App\Utils\Ability::STOCK_ENTRY_READ) }}"
                   title="Show All Stock Entry">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Stock Entry
                </a>

                <a href="{{ route('stock_entries.stock_entry.create') }}" class="btn btn-success  {{  ability(\App\Utils\Ability::STOCK_ENTRY_CREATE) }}"
                   title="Create New Stock Entry">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Stock Entry
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

            <form method="POST" action="{{ route('stock_entries.stock_entry.update', $stockEntry->id) }}"
                  id="edit_stock_entry_form" name="edit_stock_entry_form" accept-charset="UTF-8"
                  class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('stock_entries.form', [
                                            'stockEntry' => $stockEntry,
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
        var items = @json($stockEntry->items);
        var edit = true;
    </script>
    <script src="{{ asset('js/stock-entry.js') }}"></script>
@endsection
