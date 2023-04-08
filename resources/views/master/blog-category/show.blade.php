@extends('master.master-layout')

@section('content')

    <div class="card">
        <div class="card-header">

            <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Blog Category' }}</h5>

            <div class="float-right">

                <form method="POST" action="{!! route('blog.category.destroy', $blogCategory->id) !!}" accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('blog.category.index') }}" class="btn btn-primary mr-2" title="Show All Blog Category">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Blog Category
                        </a>

                        <a href="{{ route('blog.category.create') }}" class="btn btn-success mr-2" title="Create New Blog Category">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Blog Category
                        </a>

                        <a href="{{ route('blog.category.edit', $blogCategory->id) }}" class="btn btn-primary mr-2" title="Edit Post">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Blog Category
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Blog Category" onclick="return confirm(&quot;Click Ok to delete Blog Category Request.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Blog Category
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <div class="card-body">
            <dl class="dl-horizontal">
                <dt>Category Name</dt>
                <dd>{{ $blogCategory->category_name }}</dd>
                <dt>Status</dt>
                <dd>{{ $blogCategory->status }}</dd>

            </dl>

        </div>
    </div>

@endsection
