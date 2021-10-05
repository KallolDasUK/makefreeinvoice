@extends('acc::layouts.app')
@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($brand->name) ? $brand->name : 'Brand' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('brands.brand.destroy', $brand->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('brands.brand.index') }}" class="btn btn-primary mr-2" title="Show All Brand">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Brand
                    </a>

                    <a href="{{ route('brands.brand.create') }}" class="btn btn-success mr-2" title="Create New Brand">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Brand
                    </a>

                    <a href="{{ route('brands.brand.edit', $brand->id ) }}" class="btn btn-primary mr-2" title="Edit Brand">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Brand
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Brand" onclick="return confirm(&quot;Click Ok to delete Brand.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Brand
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $brand->name }}</dd>

        </dl>

    </div>
</div>

@endsection
