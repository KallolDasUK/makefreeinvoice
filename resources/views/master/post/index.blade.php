@extends('master.master-layout')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif


    <div class="card">
        <div class="card-header">

            <h5 class="my-1 float-left">Post</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('post.create') }}" class="btn btn-success"
                   title="Create New Post">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Post
                </a>
            </div>

        </div>


        @if(count($posts) == 0)
            <div class="card-body text-center">
                <h4>No Posts Available.</h4>
            </div>
        @else
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Banner</th>
                            <th>Slug</th>
                            <th>Title</th>
                            <th>Category Name</th>
{{--                            <th>Meta Title</th>--}}
{{--                            <th>Meta Description</th>--}}
{{--                            <th>Short Summery</th>--}}
{{--                            <th>Content</th>--}}
{{--                            <th>Author Name</th>--}}
                            <th>Date</th>

                            <th>Featured Image</th>
                            <th>Publish</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$post->banner) }}" alt="" width="100" class="rounded"></td>
                                <td>{{$post-> slug}}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ optional($post->category)->category_name }}</td>
{{--                                <td>{{ $post->meta_title }}</td>--}}
{{--                                <td>{{ $post->meta_description }}</td>--}}
{{--                                <td>{{ $post->short_summery }}</td>--}}
{{--                                <td>{{ $post->content }}</td>--}}
{{--                                <td>{{ $post->author_name }}</td>--}}
                                <td>{{ $post->date }}</td>

                                <td>
                                    <img src="{{asset('storage'.$post->featured_image)}}" alt="" width="100" class="rounded"></td>
                                <td class="text-center">
                                    @if($post->publish == 1)
                                        <i class="fas fa-check text-primary" aria-hidden="true"></i>
                                    @else
                                        <i class="fas fa-times text-danger" aria-hidden="true"></i>
                                    @endif
                                </td>
{{----}}
                                <td>

                                    <form method="POST"
                                          action="{!! route('post.destroy', $post->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('post.edit', $post->id ) }}"
                                               class="mx-4" title="Edit Collect Payment">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Post Category"
                                                    onclick="return confirm(&quot;Click Ok to delete Post.&quot;)"
                                            >
                                                <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
                                            </button>
                                        </div>

                                    </form>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        @endif
    </div>
@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('table').DataTable({
                responsive: true,
                "order": [],
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]

            });
        });
    </script>

    <style>
        .dataTables_filter {
            float: right;
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection


