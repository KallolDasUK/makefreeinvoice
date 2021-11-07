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

            <h5 class="my-1 float-left">Brands</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('brands.brand.create') }}"
                   class="btn btn-success  {{ ability(\App\Utils\Ability::BRAND_CREATE) }}" title="Create New Brand">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Brand
                </a>
            </div>

        </div>

        @if(count($brands) == 0)
            <div class="card-body text-center">
                <h4>No Brands Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <form method="POST" action="{!! route('brands.brand.destroy', $brand->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <a href="{{ route('brands.brand.edit', $brand->id ) }}" class="mx-4 btn  {{ ability(\App\Utils\Ability::BRAND_EDIT) }}"
                                               title="Edit Brand">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Brand"
                                                    {{ ability(\App\Utils\Ability::BRAND_DELETE) }}
                                                    onclick="return confirm(&quot;Click Ok to delete Brand.&quot;)">
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
                {!! $brands->render() !!}
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

    <style>
        .dataTables_filter {
            float: right;
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection


