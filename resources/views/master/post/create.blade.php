@extends('master.master-layout')




@section('content')


    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Post</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('post.index') }}" class="btn btn-primary" title="Show Post">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Post
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('post.store') }}" accept-charset="UTF-8" id="create_post_form"
                  name="create_post_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('master.post.form', ['post' => null ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>


@endsection

