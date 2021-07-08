@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($category->name) ? $category->name : 'Category' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('categories.category.destroy', $category->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('categories.category.index') }}" class="btn btn-primary mr-2" title="Show All Category">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Category
                    </a>

                    <a href="{{ route('categories.category.create') }}" class="btn btn-success mr-2" title="Create New Category">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Category
                    </a>

                    <a href="{{ route('categories.category.edit', $category->id ) }}" class="btn btn-primary mr-2" title="Edit Category">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Category
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Category" onclick="return confirm(&quot;Click Ok to delete Category.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Category
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $category->name }}</dd>
            <dt>Parent Category</dt>
            <dd>{{ optional($category->category)->id }}</dd>

        </dl>

    </div>
</div>

@endsection
