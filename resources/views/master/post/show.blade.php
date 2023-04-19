@extends('master.master-layout')

@section('content')

    <div class="card">
        <div class="card-header">

            <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Post' }}</h5>

            <div class="float-right">

                <form method="POST" action="{!! route('post.destroy', $post->id) !!}" accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('post.index') }}" class="btn btn-primary mr-2" title="Show All Post">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Post
                        </a>

                        <a href="{{ route('post.create') }}" class="btn btn-success mr-2" title="Create New Post">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Post
                        </a>

                        <a href="{{ route('post.edit', $post->id ) }}" class="btn btn-primary mr-2" title="Edit Payment Request">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Post
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Post" onclick="return confirm(&quot;Click Ok to delete Post Request.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Post
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <div class="card-body">
            <dl class="dl-horizontal">
                <dt>Banner</dt>
                <dd>{{ $post->banner }}</dd>
                <dt>Title</dt>
                <dd>{{ $post->title }}</dd>
                <dt>Category Name</dt>
                <dd>{{ optional($post->category_name)->category }}</dd>
                <dt>Date</dt>
                <dd>{{ $post->date }}</dd>
                <dt>Featured image</dt>
                <dd>{{ $post->featured_image }}</dd>


            </dl>

        </div>
    </div>

@endsection

