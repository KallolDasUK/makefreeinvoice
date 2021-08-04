@extends('super_admin.layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($blog->title) ? $blog->title : 'Blog' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('blogs.blog.index') }}" class="btn btn-primary mr-2" title="Show All Blog">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Blog
                </a>

                <a href="{{ route('blogs.blog.create') }}" class="btn btn-success" title="Create New Blog">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Blog
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

            <form method="POST" action="{{ route('blogs.blog.update', $blog->id) }}" id="edit_blog_form" name="edit_blog_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('blogs.form', [ 'blog' => $blog])

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
    <script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>

    <script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>

    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">

    <script>
        Laraberg.init('body')

    </script>
@endsection

