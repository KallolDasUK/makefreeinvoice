@extends('acc::layouts.app')
@section('content')
    <div class="" style="min-height: 100vh">
        <div class="float-right">
            <form>
            <h4 class="card-title"><input type="month" class="form-control font-weight-bolder text-danger" value="{{ $date }}" name="date" onchange="this.form.submit()"></h4>
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
        })
    </script>
@endsection
