@extends('super_admin.layouts.app')

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

            <h5  class="my-1 float-left">Blogs</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('blogs.blog.create') }}" class="btn btn-success" title="Create New Blog">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Blog
                </a>
            </div>

        </div>

        @if(count($blogs) == 0)
            <div class="card-body text-center">
                <h4>No Blogs Available.</h4>
            </div>
        @else
        <div class="card-body">

            <div >
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>


                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                                <td>{{ $blog->title }}</td>
                            <td>{{ $blog->slug }}</td>



                            <td>

                                <form method="POST" action="{!! route('blogs.blog.destroy', $blog->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">
                                        <a href="{{ route('blogs.blog.show', $blog->slug ) }}" title="Show Blog">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('blogs.blog.edit', $blog->id ) }}" class="mx-4" title="Edit Blog">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" style="border: none;background: transparent"  title="Delete Blog" onclick="return confirm(&quot;Click Ok to delete Blog.&quot;)">
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

        <div class="card-footer">
            {!! $blogs->render() !!}
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
        i:hover { color: #0248fa !important; }

     </style>


@endsection


