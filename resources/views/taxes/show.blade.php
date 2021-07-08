@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($tax->name) ? $tax->name : 'Tax' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('taxes.tax.destroy', $tax->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('taxes.tax.index') }}" class="btn btn-primary mr-2" title="Show All Tax">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Tax
                    </a>

                    <a href="{{ route('taxes.tax.create') }}" class="btn btn-success mr-2" title="Create New Tax">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Tax
                    </a>

                    <a href="{{ route('taxes.tax.edit', $tax->id ) }}" class="btn btn-primary mr-2" title="Edit Tax">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Tax
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Tax" onclick="return confirm(&quot;Click Ok to delete Tax.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Tax
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $tax->name }}</dd>
            <dt>Value (%)</dt>
            <dd>{{ $tax->value }}</dd>
            <dt>Tax Type</dt>
            <dd>{{ $tax->tax_type }}</dd>

        </dl>

    </div>
</div>

@endsection
