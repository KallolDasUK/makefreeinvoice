@extends('master.master-layout')




@section('content')


    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Blog Category</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('blog.category.index') }}" class="btn btn-primary" title="Show All Blog Category">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Blog Category
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('blog.category.store') }}" accept-charset="UTF-8" id="create_blog_category_form" name="create_blog_category_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('master.blog-category.form', ['blogCategory' => null ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>


@endsection
