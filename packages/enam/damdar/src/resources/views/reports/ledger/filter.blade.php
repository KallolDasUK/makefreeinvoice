@extends('acc::layouts.app')


@push('css')

@endpush

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif


    <form action="{{ route('accounting.report.ledger.pdf') }}" method="get" target="_blank">
        <div class=" text-dark" style="position:relative;">

            <div id="dvBranch" class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto">
                <fieldset class="border p-4 card">
                    <legend class=" h4">Select Branch</legend>
                    <div class="clearfix marg-top mid span">
                        <!--Row-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  clearfix">
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
                    <legend class=" h4">Select Ledger</legend>
                    <div class=" ">
                        <!--Row-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  clearfix ">
                            <!--Row-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class="col-12">

                                    <select id="ledger_id" name="ledger_id" class="col-12" required>
                                        @foreach($ledgers as $id => $text)
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
        })

    </script>


@endpush


