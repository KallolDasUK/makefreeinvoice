@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($category->name) ? $category->name : 'Category' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('categories.category.index') }}" class="btn btn-primary mr-2" title="Show All Category">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Category
                </a>

                <a href="{{ route('categories.category.create') }}" class="btn btn-success" title="Create New Category">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Category
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

            <form method="POST" action="{{ route('categories.category.update', $category->id) }}" id="edit_category_form" name="edit_category_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('categories.form', [
                                        'category' => $category,
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

@section('js')
    <script>
        $(document).ready(function () {
            new TomSelect(`#category_id`, {
                sortField: {
                    field: "text",
                    direction: "asc"
                },

            });
        });
    </script>
@endsection
