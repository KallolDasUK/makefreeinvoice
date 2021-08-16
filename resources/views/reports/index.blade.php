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

        .divider {
            float: left;
            height: 132px;
            margin: 18px 10px 5px;
            float: left;
            padding: 8px;
            text-align: center;

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

        .shortcuts-title {
            color: black;
            font-weight: bolder;
        }


    </style>
@endsection
@section('content')

    <div>

        <div class="card">
            <div class="card-body">
                <div class="mx-auto" style="width: 50%">
                  <input type="text" placeholder="Search Reports" class="form-control text-center" style="font-size: 25px">

                </div>
                <a class="sc-gPEVay eaBhby  " href="{{ route('reports.report.tax_report') }}">
                    <div class="sc-iRbamj image" style="background-image:url('images/estimate.svg') ">

                    </div>
                    <div class="shortcuts-title sc-jlyJG gSoaLO ">Tax Summary</div>
                </a>
            </div>

        </div>
    </div>

@endsection

@push('js')

    <script>

        $(document).ready(function () {

        })


    </script>
@endpush
