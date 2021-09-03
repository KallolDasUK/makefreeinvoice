@extends('master.master-layout')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($blogTag->name) ? $blogTag->name : 'Blog Tag' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('blog_tags.blog_tag.destroy', $blogTag->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('blog_tags.blog_tag.index') }}" class="btn btn-primary mr-2" title="Show All Blog Tag">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Blog Tag
                    </a>

                    <a href="{{ route('blog_tags.blog_tag.create') }}" class="btn btn-success mr-2" title="Create New Blog Tag">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Blog Tag
                    </a>

                    <a href="{{ route('blog_tags.blog_tag.edit', $blogTag->id ) }}" class="btn btn-primary mr-2" title="Edit Blog Tag">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Blog Tag
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Blog Tag" onclick="return confirm(&quot;Click Ok to delete Blog Tag.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Blog Tag
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $blogTag->name }}</dd>

        </dl>

    </div>
</div>

@endsection
