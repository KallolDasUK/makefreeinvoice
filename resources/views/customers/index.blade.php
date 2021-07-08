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

            <h5 class="my-1 float-left">Customers</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('customers.customer.create') }}" class="btn btn-success" title="Create New Customer">
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

                <div>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Avatar</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td class="text-center">
                                    @if($customer->photo)
                                        <img class="avatar" src="{{ asset('storage/' . $customer->photo) }}"
                                             width="50px"></td>

                                @endif
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td title="{{ $customer->address }}">
                                    {{  mb_strimwidth($customer->address, 0, 30, "...")}}</td>
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

            $('.avatar').on('hover', function () {

            })
        });
    </script>

    <style>
        .dataTables_filter {
            float: right;
        }

        .avatar {
            transition: all .2s ease-in-out;
        }

        .avatar:hover {
            transform: scale(4);
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection



