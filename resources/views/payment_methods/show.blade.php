@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($paymentMethod->name) ? $paymentMethod->name : 'Payment Method' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('payment_methods.payment_method.destroy', $paymentMethod->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('payment_methods.payment_method.index') }}" class="btn btn-primary mr-2" title="Show All Payment Method">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Payment Method
                    </a>

                    <a href="{{ route('payment_methods.payment_method.create') }}" class="btn btn-success mr-2" title="Create New Payment Method">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Payment Method
                    </a>

                    <a href="{{ route('payment_methods.payment_method.edit', $paymentMethod->id ) }}" class="btn btn-primary mr-2" title="Edit Payment Method">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Payment Method
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Payment Method" onclick="return confirm(&quot;Click Ok to delete Payment Method.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Payment Method
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $paymentMethod->name }}</dd>
            <dt>Is Default</dt>
            <dd>{{ ($paymentMethod->is_default) ? 'Yes' : 'No' }}</dd>
            <dt>Description</dt>
            <dd>{{ $paymentMethod->description }}</dd>
            <dt>Created At</dt>
            <dd>{{ $paymentMethod->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $paymentMethod->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection
