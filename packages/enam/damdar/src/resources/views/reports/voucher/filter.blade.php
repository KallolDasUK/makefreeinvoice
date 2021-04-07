@extends('acc::layouts.app')


@push('css')

@endpush

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif


    <form action="{{ route('accounting.report.voucher.pdf') }}" method="get" target="_blank">
        <div class=" text-dark" style="position:relative;">

            <div id="dvBranch" class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto">
                <fieldset class="border p-4 card">
                    <legend class=" h4">Select Branch</legend>
                    <div class=" clearfix marg-top mid span">
                        <!--Row-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  clearfix ">
                            <!--Row-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class="col-12">

                                    <select name="branch_id" class="col-12 form-control">
                                        <option> All</option>

                                        @foreach($branches as $id => $text)
                                            <option value="{{ $id }}">{{ $text }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <!--End Row-->
                        </div>
                    </div>
                    <!--End Row-->
                </fieldset>
            </div>
            <br>

            <div id="ledgerDiv" class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto">
                <fieldset class="border p-4 card">
                    <legend class=" h4">Select Voucher Type</legend>
                    <div class=" ">
                        <!--Row-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  clearfix ">
                            <!--Row-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class="col-12">
                                    <div class="row">

                                        <div class="col form-check">
                                            <input class="form-check-input" id="Receive" type="radio"
                                                   name="voucher_type"
                                                   value="Receive">
                                            <label class="form-check-label" for="Receive">Receipt</label>
                                        </div>
                                        <div class="col form-check">
                                            <input class="form-check-input" id="Payment" type="radio"
                                                   name="voucher_type"
                                                   value="Payment" checked>
                                            <label class="form-check-label" for="Payment">Payment</label>
                                        </div>
                                        <div class="col form-check">
                                            <input class="form-check-input" id="Journal" type="radio"
                                                   name="voucher_type"
                                                   value="Journal">
                                            <label class="form-check-label" for="Journal">Journal</label>
                                        </div>
                                        <div class="col form-check">
                                            <input class="form-check-input" id="Contra" type="radio"
                                                   name="voucher_type"
                                                   value="Contra">
                                            <label class="form-check-label" for="Contra">Contra</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--End Row-->
                        </div>
                    </div>
                    <!--End Row-->
                </fieldset>
            </div>
            <br>

            <div id="ledgerDiv" class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto">
                <fieldset class="border p-4 card">
                    <legend class=" h4">All/Individual</legend>
                    <div class=" ">
                        <!--Row-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  clearfix ">
                            <!--Row-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class="col-12">
                                    <div class="row">

                                        <div class="col form-check">
                                            <input class="form-check-input" id="All" type="radio"
                                                   name="filter"
                                                   value="All" checked>
                                            <label class="form-check-label" for="All">All</label>
                                        </div>
                                        <div class="col form-check">
                                            <input class="form-check-input" id="Individual" type="radio"
                                                   name="filter"
                                                   value="Individual">
                                            <label class="form-check-label" for="Individual">Individual</label>

                                            <select class="form-control" id="txn_id" name="txn_id">
                                                @foreach($txns as $id => $txn)
                                                    <option value="{{$id}}"> {{ $txn }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <!--End Row-->
                        </div>
                    </div>
                    <!--End Row-->
                </fieldset>
            </div>
            <br>
            <div class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12">
                <fieldset class="border p-4 card">
                    <legend class=" h4">Date Between</legend>
                    <div class="p-2">
                        <div class="row ">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <label class="control-label" for="inputWarning">From Date :</label>
                                <input type="date" name="start_date" value="{{ $start_date }}"
                                       class="col-xs-12 col-sm-12 col-md-12 col-lg-12 focusColor datePicker form-control hasDatepicker">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <label class="control-label" for="inputWarning">To Date :</label>
                                <input type="date" name="end_date" value="{{ $end_date }}"
                                       class="col-xs-12 col-sm-12 col-md-12 col-lg-12 focusColor datePicker form-control">
                            </div>

                            <!--End Row-->
                        </div>
                    </div>


                    <!--End Row-->
                </fieldset>
            </div>
            <br>
            <div class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto float-right pr-4">


                <a href="{{ route('accounting.report.ledger') }}"
                   class="col-lg-3 mx-auto col-xs-12 col-sm-12 col-md-12 btn btn-secondary">Reset Filter</a>

                <button class="col-lg-3 mx-auto col-xs-12 col-sm-12 col-md-12 btn btn-primary">Show Report</button>
            </div>
        </div>


    </form>


@endsection

@push('js')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#ledger_id').select2({placeholder: '-- Ledger --'});
            $('#txn_id').select2();
        })

    </script>


@endpush


