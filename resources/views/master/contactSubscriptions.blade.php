@extends('master.master-layout')

@section('css')
    <link href="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link rel="stylesheet/less"
          href="https://raw.githack.com/kosmikko/bootstrap-checkbox-tree/master/css/bootstrap-checkbox-tree.less"
          type="text/css"/>
    <style>
        ul {
            list-style-type: none;
        }

        ul li {
            list-style-type: none;
            display: inline-block;

        }

        .col > label {
            font-weight: bolder;
        }

    </style>
@endsection
@section('content')
    <h2>Contact Subscription</h2>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    {{--    <form method="post" action="{{ route('accounting.settings.update') }}" style="margin-bottom: 50px"--}}
    {{--          enctype="multipart/form-data">--}}
    {{--        @csrf--}}
    {{--        <div class="mx-auto text-right">--}}
    {{--            <button type="submit"--}}
    {{--                    class="btn btn-primary btn-lg" {{ ability(\App\Utils\Ability::GENERAL_SETTINGS_EDIT) }}>Save--}}
    {{--                Settings--}}
    {{--            </button>--}}

    {{--        </div>--}}
    {{--        </div>--}}


    <form action="{{ route('master.contact.subscriptions.store') }}" method="POST">

        @csrf

        <div class="form-group row">
            <div class="col-form-label col-lg-2 required">
                <label class="font-weight-bolder text-danger"> Phone Number *</label>
            </div>
            <div class="col-lg-8">
                <input type="text" class="form-control" name="phone" value="{{ $global_settings->phone??'' }}">
            </div>
        </div>
        <div class="mx-auto text-right">
            <button type="submit"
                    class="btn btn-primary btn-lg" >Save
                Settings
            </button>

        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript"
            src="https://raw.githack.com/kosmikko/bootstrap-checkbox-tree/master/js/bootstrap-checkbox-tree.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script>

    <script type="text/javascript">

        jQuery(document).ready(function () {
            var cbTree = $('.checkbox-tree').checkboxTree({
                checkChildren: true,
                singleBranchOpen: true,
                openBranches: ['.liverpool', '.chelsea']
            });
            $('#tree-expand').on('click', function (e) {
                cbTree.expandAll();
            });
            $('#tree-collapse').on('click', function (e) {
                cbTree.collapseAll();
            });
            $('#tree-default').on('click', function (e) {
                cbTree.defaultExpand();
            });
            $('#tree-select-all').on('click', function (e) {
                cbTree.checkAll();
            });
            $('#tree-deselect-all').on('click', function (e) {
                cbTree.uncheckAll();
            });
            $('.checkbox-tree').on('checkboxTicked', function (e) {
                var checkedCbs = $(e.currentTarget).find("input[type='checkbox']:checked");
                console.log('checkbox tick', checkedCbs.length);
            });
        });

    </script>
@endsection

