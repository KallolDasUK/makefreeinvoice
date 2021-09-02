@extends('acc::layouts.app')
@section('css')

    <style>
        .dropdown-toggle:hover {
            color: #0d71bb !important;
        }

        svg:hover {
            color: #0d71bb !important;
        }

        .dropdown-toggle::before {
            content: "";

            border-right: 0em solid !important;

        }


    </style>
@endsection
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


    <div class="card rounded  mb-4">
        <div class="">
            <div class="row align-items-center">
                <div class="col ">

                    <div class="card " style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Total Expense
                                <h3>{{ $settings->currency??'$' }}{{ decent_format_dash($totalExpense??'') }}</h3>
                            </div>
                            <div class="vertical-divider"></div>
                        </div>

                    </div>


                </div>


            </div>

        </div>
    </div>

    <div class="card">

        <div class="card-header">

            <h2 class="my-1 float-left">Expenses</h2>

            <div class="btn-group btn-group-sm float-right btn-lg" role="group">
                <a href="{{ route('expenses.expense.create') }}" class="btn btn-success" title="Create New Expense"
                   style="font-size:  20px">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create an Expense
                </a>
            </div>

        </div>

        @if(count($expenses) == 0)
            <div class="card-body text-center">
                <h4>No Expenses Available.


                </h4>
                @if($start_date != null || $end_date != null || $q !=null)
                    <a href="{{ route('expenses.expense.index') }}" title="Clear Filter"
                       class="btn  btn-light-danger">[x] Clear Filter </a>
                @endif
            </div>
        @else
            <div class="card-body">
                <form action="{{ route('expenses.expense.index') }}">
                    <div class="row align-items-center mb-4">
                        <div class="col-lg-3 col-xl-2">
                            <input name="q" type="text" class="form-control" placeholder="Search Ref#"
                                   value="{{ $q }}"
                            >
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="input-daterange input-group" id="start_date">
                                    <input type="text" class="form-control col-2" name="start_date"
                                           value="{{ $start_date }}"
                                           placeholder="Start">
                                    <div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-ellipsis-h"></i>
                                        To
                                    </span>
                                    </div>
                                    <input type="text" class="form-control col-2" name="end_date" id="end_date"
                                           value="{{ $end_date }}"

                                           placeholder="End">
                                    <button role="button" type="submit"
                                            class="btn btn-primary px-6 mx-2 col-3 font-weight-bold">
                                        <i class="fas fa-sliders-h"></i>
                                        Filter
                                    </button>

                                    @if($start_date != null || $end_date != null || $q !=null)
                                        <a href="{{ route('expenses.expense.index') }}" title="Clear Filter"
                                           class="btn btn-icon btn-light-danger"> X</a>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </form>

                <div>
                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Ref#</th>
                            <th>Paid Through</th>
                            <th>Vendor</th>
                            <th>Customer</th>
                            <th>Attachment File</th>
                            <th>Amount</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $expense)
                            <tr class="text-dark-75 font-weight-bolder">
                                <td class="text-dark-75 font-weight-bolder font-size-lg">{{ $loop->iteration }}</td>
                                <td class="text-dark-75 font-weight-bolder font-size-lg"><a
                                        href="{{ route('expenses.expense.show',$expense->id) }}">{{ $expense->date }}</a>
                                </td>
                                <td><a href="{{ route('expenses.expense.show',$expense->id) }}">{{ $expense->ref }}</a>
                                </td>

                                <td>{{ optional($expense->ledger)->ledger_name }}</td>
                                <td>{{ optional($expense->vendor)->name }}</td>
                                <td>{{ optional($expense->customer)->name }}</td>
                                <td>
                                    @if($expense->file)
                                        <a target="_blank" href="{{ asset('storage/'.$expense->file) }}">Files(1)</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="font-size: 20px"> {{  $settings->currency??'$' }}{{ decent_format($expense->amount ) }}</td>
                                <td>

                                    <div class="dropdown d-inline dropleft">
                                    <span class=" dropdown-toggle mr-4 " type="button" style="font-size: 25px"
                                          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false">
                                        <svg style="height: 35px;width: 35px" aria-hidden="true" focusable="false"
                                             data-prefix="far"
                                             data-icon="caret-circle-down" role="img" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512"
                                             class="svg-inline--fa fa-caret-circle-down fa-w-16 fa-3x"><path
                                                fill="currentColor"
                                                d="M157.1 216h197.8c10.7 0 16.1 13 8.5 20.5l-98.9 98.3c-4.7 4.7-12.2 4.7-16.9 0l-98.9-98.3c-7.7-7.5-2.3-20.5 8.4-20.5zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-48 0c0-110.5-89.5-200-200-200S56 145.5 56 256s89.5 200 200 200 200-89.5 200-200z"
                                                class=""></path></svg>
                                    </span>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <a href="{{ route('expenses.expense.edit',$expense->id) }}"
                                               class="dropdown-item btn">
                                                <span class="fa fa-pencil-alt mx-4"></span> <strong>Edit</strong>
                                            </a>
                                            <a href="{{ route('expenses.expense.show',[$expense->id,'print'=>true]) }}"
                                               class="dropdown-item btn">
                                                <span class="fa fa-print mx-4 text-info"></span> <strong>Print
                                                    Receipt</strong>
                                            </a> <a
                                                href="{{ route('expenses.expense.show',[$expense->id,'download'=>true]) }}"
                                                class="dropdown-item btn">
                                                <span class="fa fa-download mx-4 text-primary"></span> <strong>Download
                                                    Receipt</strong>
                                            </a>
                                            <form method="POST"
                                                  action="{!! route('expenses.expense.destroy', $expense->id) !!}">
                                                {{ csrf_field() }}
                                                <button class="dropdown-item "
                                                        onclick="return confirm('Click Ok to delete Expense')">
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

                </div>
            </div>

            <div class="card-footer">
                {!! $expenses->render() !!}
            </div>

        @endif

    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function () {


            var datepicker = $.fn.datepicker.noConflict();
            $.fn.bootstrapDP = datepicker;
            $("#start_date,#end_date").bootstrapDP({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                templates: arrows
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


