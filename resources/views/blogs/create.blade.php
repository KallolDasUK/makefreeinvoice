{{--@extends('acc::layouts.app')--}}
@extends('super_admin.layouts.app')
@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Blog</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('blogs.blog.index') }}" class="btn btn-primary" title="Show All Blog">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Blog
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('blogs.blog.store') }}" accept-charset="UTF-8" id="create_blog_form" name="create_blog_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('blogs.form', ['blog' => null])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
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


