@extends('acc::layouts.app')

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

            <h5  class="my-1 float-left">Categories</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('categories.category.create') }}" class="btn btn-success {{ ability(\App\Utils\Ability::CATEGORY_CREATE) }}" title="Create New Category">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Category
                </a>
            </div>

        </div>

        @if(count($categories) == 0)
            <div class="card-body text-center">
                <h4>No Categories Available.</h4>
            </div>
        @else
        <div class="card-body">

            <div class="">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                                <th>Name</th>
                            <th>Parent Category</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                                <td>{{ $category->name }}</td>
                            <td>{{ optional($category->category)->name }}</td>

                            <td>

                                <form method="POST" action="{!! route('categories.category.destroy', $category->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">

                                        <a href="{{ route('categories.category.edit', $category->id ) }}" class="mx-4 btn {{ ability(\App\Utils\Ability::CATEGORY_EDIT) }}" title="Edit Category">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" {{ ability(\App\Utils\Ability::CATEGORY_DELETE) }} title="Delete Category" onclick="return confirm(&quot;Click Ok to delete Category.&quot;)">
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

@section('js')

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





@endsection


