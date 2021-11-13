@extends('acc::layouts.app')

@section('content')
    @include('partials.customer_payment_receipt_modal')

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

            <h5 class="my-1 float-left">Receive Payments</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('receive_payments.receive_payment.create') }}"
                   class="btn btn-success {{  ability(\App\Utils\Ability::RECEIVE_PAYMENT_CREATE) }}"
                   title="Create New Receive Payment">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Receive Payment
                </a>
            </div>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <form action="{{ route('receive_payments.receive_payment.index') }}">
                    <div class="row align-items-end mb-4 mx-auto justify-content-center">

                        <div class="col-lg-3 col-xl-2">

                            <select name="customer_id" id="customer_id" class="form-control searchable"
                                    >
                                <option></option>
                                @foreach($customers as $c)
                                    <option
                                        value="{{ $c->id }}" {{ $customer_id == $c->id?'selected':'' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="input-daterange input-group" id="start_date">
                                    <input type="text" class="form-control col-2" name="start_date"
                                           value="{{ $start_date??'' }}"
                                           placeholder="Start">
                                    <div class="input-group-append">
									<span class="input-group-text">
										...
                                    </span>
                                    </div>
                                    <input type="text" class="form-control col-2" name="end_date" id="end_date"
                                           value="{{ $end_date??'' }}"

                                           placeholder="End">
                                    <button role="button" type="submit"
                                            class="btn btn-primary px-6 mx-2 col-3 font-weight-bold">
                                        <i class="fas fa-sliders-h"></i>
                                        Update Report
                                    </button>

                                    @if( $customer_id !=null)
                                        <a href="{{ route('receive_payments.receive_payment.index') }}" title="Clear Filter"
                                           class="btn btn-icon btn-light-danger"> X</a>
                                    @endif


                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        @if(count($receivePayments) == 0)
            <div class="card-body text-center">
                <h4>No Receive Payments Available.</h4>
            </div>
        @else
            <div class="card-body">

                <div>
                    <table class=" table mb-0  table-head-custom table-vertical-center ">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Payment Sl</th>
                            <th>Customer</th>
                            <th>Invoices</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="font-weight-bolder" style="font-size: 14px">
                        @foreach($receivePayments as $receivePayment)
                            <tr>
                                <td>{{ (($receivePayments->currentPage() - 1) * 10) + $loop->iteration }}</td>
                                <td>{{ $receivePayment->payment_sl }}</td>
                                <td>
                                    <a class="customer_statement"
                                       data-toggle="tooltip" data-placement="top" title="Customer Statement"
                                       href="{{ route('reports.report.customer_statement',['customer_id'=>optional($receivePayment->customer)->id]) }}">{{ optional($receivePayment->customer)->name }}</a>
                                </td>
                                <td>{{ $receivePayment->invoice }}</td>
                                <td>{{ $receivePayment->payment_date }}</td>
                                <td>{{ optional($receivePayment->ledger)->ledger_name }}</td>
                                <td>{{ $receivePayment->amount }}</td>

                                <td>
                                    <form method="POST"
                                          {{  ability(\App\Utils\Ability::RECEIVE_PAYMENT_DELETE) }}
                                          action="{!! route('receive_payments.receive_payment.destroy', $receivePayment->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm float-right " role="group">

                                            <span
                                                title="Show Receive Payment"
                                                onclick="showCustomerPaymentReceipt('{{ $receivePayment->id }}')"
                                                class="btn btn-outline-secondary">
                                                <i class="fa fa-print text-info" aria-hidden="true"></i>
                                                Print Receipt
                                            </span>

                                            <a href="{{ route('receive_payments.receive_payment.edit', $receivePayment->id ) }}"
                                               class="mx-4 btn  {{  ability(\App\Utils\Ability::RECEIVE_PAYMENT_EDIT) }}"
                                               title="Edit Receive Payment">
                                                <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                            </a>

                                            <button type="submit"
                                                    title="Delete Receive Payment"
                                                    {{  ability(\App\Utils\Ability::RECEIVE_PAYMENT_DELETE) }}
                                                    class="btn "
                                                    onclick="return confirm(&quot;Click Ok to delete Receive Payment.&quot;)">
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
                {!! $receivePayments->links() !!}
            </div>

        @endif

    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function () {


            var datepicker = $.fn.datepicker.noConflict();
            $.fn.bootstrapDP = datepicker;
            $("#start_date,#end_date").bootstrapDP({

                autoclose: true,
                format: "yyyy-mm-dd",
                immediateUpdates: true,
                todayBtn: true,
                todayHighlight: true,
                clearBtn: true

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


