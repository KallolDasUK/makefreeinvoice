@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Stock Entry' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('stock_entries.stock_entry.destroy', $stockEntry->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('stock_entries.stock_entry.index') }}" class="btn btn-primary mr-2" title="Show All Stock Entry">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Stock Entry
                    </a>

                    <a href="{{ route('stock_entries.stock_entry.create') }}" class="btn btn-success mr-2" title="Create New Stock Entry">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Stock Entry
                    </a>

                    <a href="{{ route('stock_entries.stock_entry.edit', $stockEntry->id ) }}" class="btn btn-primary mr-2" title="Edit Stock Entry">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Stock Entry
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Stock Entry" onclick="return confirm(&quot;Click Ok to delete Stock Entry.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Stock Entry
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Ref</dt>
            <dd>{{ $stockEntry->ref }}</dd>
            <dt>Date</dt>
            <dd>{{ $stockEntry->date }}</dd>
            <dt>Brand</dt>
            <dd>{{ optional($stockEntry->brand)->name }}</dd>
            <dt>Category</dt>
            <dd>{{ optional($stockEntry->category)->name }}</dd>
            <dt>Product</dt>
            <dd>{{ optional($stockEntry->product)->name }}</dd>

        </dl>

    </div>
</div>

@endsection
