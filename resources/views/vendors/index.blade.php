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

            <h5  class="my-1 float-left">Vendors</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('vendors.vendor.create') }}" class="btn btn-success" title="Create New Vendor">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Vendor
                </a>
            </div>

        </div>

        @if(count($vendors) == 0)
            <div class="card-body text-center">
                <h4>No Vendors Available.</h4>
            </div>
        @else
        <div class="card-body">

            <div class="table-responsive">
                <table class="table  table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Country</th>


                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->company_name }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->country }}</td>


                            <td>

                                <form method="POST" action="{!! route('vendors.vendor.destroy', $vendor->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">
                                        <a href="{{ route('vendors.vendor.show', $vendor->id ) }}"title="Show Vendor">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('vendors.vendor.edit', $vendor->id ) }}" class="mx-4" title="Edit Vendor">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" style="border: none;background: transparent"  title="Delete Vendor" onclick="return confirm(&quot;Click Ok to delete Vendor.&quot;)">
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
            {!! $vendors->render() !!}
        </div>

        @endif

    </div>
@endsection

@section('scripts')

     <script>

     </script>

     <style>
         .dataTables_filter {
             float: right;
         }
        i:hover { color: #0248fa !important; }

     </style>


@endsection


