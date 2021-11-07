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

            <div class="row">
                <div class="row col d-none">
                    <div class="card col ">
                        <div class="py-4 text-center">
                            <h3>{{ $totalCustomers??0 }}</h3>
                            <h5> Customers</h5>
                        </div>
                    </div>
                    <div class="card col mx-2">
                        <div class="py-4 text-center">
                            <h3>{{ decent_format_dash_if_zero($totalReceivables) }}</h3>
                            <h5> Receivables</h5>
                        </div>
                    </div>
                    <div class="card col">
                        <div class="py-4 text-center">

                            <h3>{{ decent_format_dash_if_zero($totalAdvance) }}</h3>
                            <h5> Advance </h5>
                           </div>
                    </div>
                </div>

                <div class="col">
                    <div class="btn-group btn-group-sm float-right" role="group">
                        <a style="font-size: 16px" href="{{ route('customers.customer.create') }}"
                           class="btn btn-success btn-lg font-weight-bolder font-size-sm  {{ ability(\App\Utils\Ability::CUSTOMER_CREATE) }}" title="Create New Customer">
                            <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                            New Customer
                        </a>

                    </div>
{{--                    <div class="clearfix"></div>--}}
                    <a  href="{{ route('customer_advance_payments.customer_advance_payment.index') }}"
                        class="btn btn-secondary font-weight-bolder font-size-sm float-right mx-2  {{ ability(\App\Utils\Ability::CUSTOMER_ADVANCE_READ) }}" title="Create New Customer">
                        <i class="fa fa-money-bill" aria-hidden="true"></i>
                        Advance Payments
                    </a>
                </div>
            </div>


        </div>


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
                <table class="table mb-0  table-head-custom table-vertical-center">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>RECEIVABLES</th>
                        <th>Advance</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="font-weight-bolder" style="font-size: 14px">
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ (($customers->currentPage() - 1) * $customers->perPage()) + $loop->iteration }}</td>
                            <td>
                                <a class="customer_statement"
                                   data-toggle="tooltip" data-placement="top" title="Customer Statement"
                                   href="{{ route('reports.report.customer_statement',['customer_id'=>$customer->id]) }}">{{ $customer->name }}</a>
                                <br>
                                <p style="font-size: 14px">{{ $customer->email }}</p>
                            </td>
                            <td>{{ $customer->phone??'-' }}</td>

                            <td class="text-center">{{ decent_format_dash_if_zero($customer->receivables) }}</td>
                            <td class="text-center">{{ decent_format_dash_if_zero($customer->advance) }}</td>

                            <td class="pr-0 text-right">


                                <div class="btn-group btn-group-sm  " role="group">
                                    <a style="text-decoration: underline"
                                       class="{{ $customer->receivables>0?'':'d-none' }} font-weight-bolder text-success  font-size-lg underline  text-hover-danger cursor-pointer mx-4 recordPaymentBtn"
                                       href="{{ route('receive_payments.receive_payment.create',['customer_id'=>$customer->id]) }}"
                                    > Receive Payment</a>

                                </div>

                                <div class="dropdown d-inline dropleft">
                                    <span class=" dropdown-toggle mr-4 " type="button" style="font-size: 25px"
                                          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false">
                                        <svg
                                            style="height: 35px;width: 35px"
                                            aria-hidden="true" focusable="false" data-prefix="far"
                                            data-icon="caret-circle-down" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512"
                                            class="svg-inline--fa fa-caret-circle-down fa-w-16 fa-3x"><path
                                                fill="currentColor"
                                                d="M157.1 216h197.8c10.7 0 16.1 13 8.5 20.5l-98.9 98.3c-4.7 4.7-12.2 4.7-16.9 0l-98.9-98.3c-7.7-7.5-2.3-20.5 8.4-20.5zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-48 0c0-110.5-89.5-200-200-200S56 145.5 56 256s89.5 200 200 200 200-89.5 200-200z"
                                                class=""></path></svg>
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('customer_advance_payments.customer_advance_payment.create',['customer_id'=>$customer->id]) }}"
                                           class="dropdown-item btn  align-items-center  {{ ability(\App\Utils\Ability::CUSTOMER_ADVANCE_CREATE) }}">
                                            <span class="fa fa-money-bill mx-4"></span> <strong> Make Advance
                                                Payment</strong>
                                        </a>
                                        <a href="{{ route('customers.customer.edit',$customer->id) }}"
                                           class="dropdown-item btn  {{ ability(\App\Utils\Ability::CUSTOMER_EDIT) }}">
                                            <span class="fa fa-pencil-alt mx-4"></span> <strong>Edit</strong>
                                        </a>


                                        <form method="POST"
                                              action="{!! route('customers.customer.destroy', $customer->id) !!}">
                                            {{ csrf_field() }}
                                            <button class="dropdown-item "
                                                    {{ ability(\App\Utils\Ability::CUSTOMER_DELETE) }}
                                                    onclick="return confirm('Click Ok to delete Customer')">
                                                @method('DELETE')
                                                <span class="fa fa-trash-alt mx-4 text-danger"></span>
                                                <span>
                                                    <strong>Delete</strong>
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($customers) == 0)
                    <div class="card-body text-center">
                        <div class="text-center">
                            <img style="text-align: center;margin: 0 auto;"
                                 src="https://1.bp.blogspot.com/-oFZuUJWkeVI/YU2wRxUt26I/AAAAAAAAFKw/tA92-qZCPksDCerRYqgANfzaeF8xtGTFQCLcBGAsYHQ/s320/norecord.png"
                                 alt="">

                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer">
            {!! $customers->render() !!}
        </div>


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


