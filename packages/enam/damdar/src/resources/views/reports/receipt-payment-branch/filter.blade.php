@extends('acc::layouts.app')


@push('css')

@endpush

@section('content')

    <form target="_blank" action="{{ route('accounting.report.receipt-payment-branch.pdf') }}">
        <div class=" text-dark">
            @if(session()->has('message'))
                <div class="col-6 alert alert-warning mx-auto" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            <div class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12">
                <div id="dvBranch" class="col-lg-12 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto">
                    <fieldset class="border p-4 card">
                        <legend class=" h4">Select Branch</legend>
                        <div class="clearfix marg-top mid span">
                            <!--Row-->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  clearfix">
                                <!--Row-->
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                    <div class="col-12">

                                        <select name="branch_id" class="col-12 form-control">
                                            <option value=""> All</option>

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
                <fieldset class="border p-4 card">
                    <legend class=" h4">Select Month</legend>
                    <div class="p-2">
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label class="control-label" for="inputWarning">Month</label>
                                <input type="month" name="month"
                                       value="{{ session()->has('month') ? session('month') : '' }}"
                                       class="col-xs-12 col-sm-12 col-md-12 col-lg-12 focusColor datePicker form-control hasDatepicker"
                                       required>
                            </div>

                            <!--End Row-->
                        </div>
                    </div>


                    <!--End Row-->
                </fieldset>
            </div>
            <br>
            <div class="col-lg-6 mx-auto col-xs-12 col-sm-12 col-md-12 mx-auto float-right pr-4">


                <a href="{{ route('accounting.report.receipt-payment-branch') }}"
                   class="col-lg-3 mx-auto col-xs-12 col-sm-12 col-md-12 btn btn-secondary">Reset Filter</a>

                <button class="col-lg-3 mx-auto col-xs-12 col-sm-12 col-md-12 btn btn-primary">Show Report</button>
            </div>


        </div>


    </form>



@endsection

@push('js')
    <script type="text/javascript">

        $(document).ready(function () {

        })

    </script>


@endpush


