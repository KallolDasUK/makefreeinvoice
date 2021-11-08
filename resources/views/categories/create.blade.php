@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Category</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('categories.category.index') }}" class="btn btn-primary  {{ ability(\App\Utils\Ability::CATEGORY_READ) }}" title="Show All Category">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Category
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('categories.category.store') }}" accept-charset="UTF-8" id="create_category_form" name="create_category_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('categories.form', [
                                        'category' => null,
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
