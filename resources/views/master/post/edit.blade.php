@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($title) ? $title : 'Post' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('post.index') }}" class="btn btn-primary mr-2" title="Show All Post">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Post
                </a>

                <a href="{{ route('blog.category.create') }}" class="btn btn-success" title="Create New Collect Payment">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Post
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

            <form method="POST" action="{{ route('post.update', $post->id) }}" id="edit_post_form" name="edit_post_form"
                  accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('master.post.form', [
                                            'post' => $post,
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

