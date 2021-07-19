@extends('acc::layouts.app')

@section('css')
    <style>
        .eaBhby {
            width: 140px;
            height: 132px;
            margin: 18px 10px 5px;
            float: left;
            padding: 8px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            background-color: initial;
            border: none;
            font-size: inherit;
        }

        .image {
            background-color: rgb(226, 231, 233);
            background-size: 80px;
            background-position: center center;
            background-repeat: no-repeat;
            width: 80px;
            height: 80px;
            margin: 0px auto 8px;
            border-radius: 50%;
            border: 2px solid rgb(212, 215, 220);
        }

        .eaBhby:hover, .eaBhby:focus, .eaBhby:active {
            background-color: rgb(236, 238, 241);
        }


    </style>
@endsection
@section('content')
    <div class="" style="min-height: 100vh">


        <div class="row card mt-4">
            <div class="card-body">
                <div class="font-weight-bolder">
                    SHORTCUTS
                </div>
                <a href="{{ route('customers.customer.create') }}" class="sc-gPEVay eaBhby border rounded">
                    <div class="sc-iRbamj image" style="background-image:url('images/customer 1.svg') ">

                    </div>
                    <div class=" font-weight-bolder text-black">Add customer</div>
                </a>
                <a  class="sc-gPEVay eaBhby border rounded"
                   href="{{ route('invoices.invoice.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/invoice.svg') ">

                    </div>
                    <div class="sc-jlyJG gSoaLO">Add Invoice</div>
                </a>
                <a  class="sc-gPEVay eaBhby development border rounded"
                   href="#">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="sc-jlyJG gSoaLO ">Add Estimate</div>
                </a>
                <a  class="sc-gPEVay eaBhby border rounded"
                   href="{{ route('receive_payments.receive_payment.create') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/receive.svg') ">

                    </div>
                    <div class="sc-jlyJG gSoaLO">Receive Payment</div>
                </a>
            </div>
        </div>
        <p class="my-4"></p>
        <div class="float-right">
            <form>
                <h4 class="card-title"><input type="month" class="form-control font-weight-bolder text-danger"
                                              value="{{ $date }}" name="date" onchange="this.form.submit()"></h4>
            </form>
        </div>
        <p class="clearfix"></p>
        <div class="row text-center ">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6  ">
                <div class="card ">
                    <div class="card-body">
                        <a class="font-weight-bold" href="{{ route('ledger_groups.ledger_group.index') }}">
                            <i class="mdi mdi-link"></i>

                            <h3>Ledger Groups</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 ">
                <div class="card ">
                    <div class="card-body">
                        <a class="font-weight-bold" href="{{ route('ledgers.ledger.index') }}">
                            <i class="mdi mdi-link"></i>

                            <h3>Ledgers</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 ">
                <div class="card ">
                    <div class="card-body">
                        <a class="font-weight-bold" href="{{ route('branches.branch.index') }}">
                            <i class="mdi mdi-link"></i>

                            <h3>Branches</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 ">
                <div class="card ">
                    <div class="card-body">
                        <a class="font-weight-bold" href="{{ route('accounting.coa') }}">
                            <i class="mdi mdi-link"></i>
                            <h3>Chart Of
                                Account</h3>
                        </a>

                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card mt-4">
                <a href="{{ route('payments.payment.index') }}">


                    <div class="card card-statistics">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi mdi-square-inc-cash  text-danger icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right text-dark">Payments</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0 text-dark">{{ number_format($payment) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('payments.payment.index') }}">
                                <i class="mdi mdi-link mr-1" aria-hidden="true"></i> View Payments</a>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card mt-4">
                <a href="{{ route('transactions.transaction.index') }}">

                    <div class="card card-statistics">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi mdi-square-inc-cash text-blue icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right text-dark">Receives</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0 text-dark">{{ number_format($receive) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('transactions.transaction.index') }}">
                                <i class="mdi mdi-link mr-1" aria-hidden="true"></i> View Receives</a>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card mt-4">
                <a href="{{ route('journals.journal.index') }}">

                    <div class="card card-statistics">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi mdi-square-inc-cash text-secondary icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right text-dark">Journals</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0 text-dark">{{ number_format($journal) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('journals.journal.index') }}">
                                <i class="mdi mdi-link mr-1" aria-hidden="true"></i> View Journals</a>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card mt-4">
                <a href="{{ route('contras.contra.index') }}">

                    <div class="card card-statistics">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi mdi-square-inc-cash text-secondary icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right text-dark">Contras</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0 text-dark">{{ number_format($contra) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('contras.contra.index') }}">
                                <i class="mdi mdi-link mr-1" aria-hidden="true"></i> View Contras</a>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('input').focus()
            $('.development').on('click',function (){
                swal.fire("Under Development!");
            })
        })
    </script>
@endsection
