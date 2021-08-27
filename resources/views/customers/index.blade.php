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

            <h3 class="my-1 float-left">Customers</h3>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a style="font-size: 16px" href="{{ route('customers.customer.create') }}" class="btn btn-success btn-lg font-weight-bolder font-size-sm" title="Create New Customer">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Customer
                </a>
            </div>

        </div>

        @if(count($customers) == 0)
            <div class="card-body text-center">
                <h4>No Customers Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div class="">
                    <form action="{{ route('customers.customer.index') }}">
                        <div class="row align-items-center mb-4">

                            <div class="col-4">
                                <input name="q" type="text" class="form-control" placeholder="Name, Phone, Email"
                                       value="{{ $q }}">
                            </div>
                            <div class="col-4">

                                <button role="button" type="submit" class="btn btn-primary ">
                                    <i class="fas fa-sliders-h"></i>
                                    Filter
                                </button>

                                @if( $q != null)
                                    <a href="{{ route('customers.customer.index') }}" title="Clear Filter"
                                       class="btn btn-icon btn-light-danger"> X</a>
                                @endif


                            </div>

                        </div>
                    </form>
                    <table class="table table-head-custom table-vertical-center">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Website</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->company_name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->website }}</td>

                                <td>

                                    <form method="POST"
                                          action="{!! route('customers.customer.destroy', $customer->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">
                                            <a href="{{ route('customers.customer.show', $customer->id ) }}"
                                               title="Show Customer">
                                                <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('customers.customer.edit', $customer->id ) }}"
                                               class="mx-4" title="Edit Customer">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit" style="border: none;background: transparent"
                                                    title="Delete Customer"
                                                    onclick="return confirm(&quot;Click Ok to delete Customer.&quot;)">
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
                {!! $customers->render() !!}
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


