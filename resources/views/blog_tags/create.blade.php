@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Blog Tag</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('blog_tags.blog_tag.index') }}" class="btn btn-primary" title="Show All Blog Tag">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Blog Tag
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('blog_tags.blog_tag.store') }}" accept-charset="UTF-8" id="create_blog_tag_form" name="create_blog_tag_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('blog_tags.form', [
                                        'blogTag' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


