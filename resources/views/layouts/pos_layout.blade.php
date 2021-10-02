<!DOCTYPE html>

<html>

<head>
    <title>{{ $title ?? config('app.name')}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if($is_desktop)
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @else
        <meta name="viewport" content="width=1080px">
    @endif
    <link rel="shortcut icon"
          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/favicon.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- plugin css -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900'
          type='text/css'>


    <script src="https://use.fontawesome.com/715fc6bd34.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/materialicon.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/css/style.bundle.css?v=7.2.8">
    <link media="all" type="text/css" rel="stylesheet"
          href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.css?v=7.2.8">

    {{--    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/bundle.min.css') }}">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">


    <!-- common css -->
    {{--    <link media="all" type="text/css" rel="stylesheet"--}}
    {{--          href="https://www.bootstrapdash.com/demo/connect-plus/laravel/template/demo_1/css/app.css">--}}
<!-- end common css -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js"--}}
    {{--            integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>--}}

    {{--    <script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link media="all" type="text/css" rel="stylesheet"
          href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css"/>
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css"/>
    <link href="https://ckeditor.com/docs/ckeditor5/latest/assets/snippet-styles.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}"/>
    <script src="https://cdn.jsdelivr.net/npm/underscore@1.13.1/underscore-umd-min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @yield('css')
    @stack('css')

    <style>
        .ui-menu-item .ui-menu-item-wrapper.ui-state-active {
            background: #065a92 !important;
            font-weight: bold !important;
            color: #ffffff !important;
        }
        i:hover {
            color: inherit !important;
        }

        i {
            color: inherit !important;
        }

        .center {
            text-align-last: center;
            border: 2px solid black;
        }

        .form-group {
            margin-bottom: 1.0rem;
        }

        label {
            font-weight: bolder !important;
        }

        input:focus {
            background-color: yellow !important;
        }

        .header-tabs {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
            height: 100px;
            -ms-flex-item-align: end !important;
            align-self: flex-end !important;
        }

        .header-tabs .nav-item {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            padding: 0;
            margin: 2px;
            position: relative;
            text-align: center;
        }


        .header-tabs .nav-item .nav-link {
            margin: 0;
            padding: 0.75rem 1.5rem;
            color: #ffffff;
            -webkit-transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, -webkit-box-shadow 0.15s ease;
            transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, -webkit-box-shadow 0.15s ease;
            transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
            transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease, -webkit-box-shadow 0.15s ease;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            background-color: #065a92;
            border-right: 1px solid #E4E6EF;
        }

        .header-tabs .nav-item .nav-link .nav-title {
            font-size: 1.25rem;
            color: #ffffff;
            font-weight: 600;
        }

        .nav-item .nav-link .nav-desc {
            font-size: 1rem;
            color: #ecebeb;
        }

        .header-tabs .dropdown-toggle::after {
            display: none !important;
        }

        .nav-link:hover {
            color: #065a92 !important;
            background-color: white !important;
            border: 1px solid #065a92;
        }


        .card {
        }

        .btn.btn-outline-primary {
            color: #065a92 !important;
            background-color: transparent !important;
            border-color: #065a92 !important;
        }

        .border-primary {

            border-color: #357294 !important;
        }

        .btn.btn-outline-primary:hover {
            background-color: #065a92 !important;
            color: white !important;
            border-color: #065a92 !important;
        }

        .btn.btn-primary {
            background-color: #065a92 !important;
            color: white !important;
            border-color: #065a92 !important;
        }

        .btn.btn-primary:hover {
            background-color: transparent !important;
            border-color: #065a92 !important;
            color: #065a92 !important;

        }

        .btn.btn-success {
            color: white !important;
            background-color: #065a92 !important;
            border-color: #065a92 !important;

        }

        .btn.btn-success:hover {
            background-color: transparent !important;
            color: #065a92 !important;
            border-color: #065a92 !important;
        }


        .btn.btn-info {
            color: white !important;
            background-color: #8950FC !important;
            border-color: #8950FC !important;

        }

        .btn.btn-info:hover {
            background-color: transparent !important;
            color: #8950FC !important;
            border-color: #8950FC !important;
        }

        .rounded {
            border-color: #065a92a3 !important;
        }

        .vertical-divider::after {
            display: inline-block;
            content: "";
            height: 50px;
            border-right: 1px solid lightgrey;
            width: 1px;
        }

        .tooltip-inner {
            background-color: #065a92;
            color: white;
        }

        .tooltip.bs-tooltip-right .arrow:before {
            border-right-color: #065a92 !important;
        }

        .tooltip.bs-tooltip-left .arrow:before {
            border-left-color: #065a92 !important;
        }

        .tooltip.bs-tooltip-bottom .arrow:before {
            border-bottom-color: #065a92 !important;
        }

        .tooltip.bs-tooltip-top .arrow:before {
            border-top-color: #065a92 !important;
        }

        .form-control {
            border: 1px solid #065a926b !important;
        }

        .select2-selection {
            border: 1px solid #065a926b !important;
        }

        .pro-tag::before {
            content: "Pro";
            float: right;
            position: absolute;
            left: -5px;
            color: white;
            background: #8950fc;
            padding: 1px 5px;
            font-size: 10px;
            border-radius: 2px;
        }

        .new-tag::before {
            content: "New";
            float: right;
            position: absolute;
            left: -5px;
            color: white;
            background: #065a92;
            padding: 1px 5px;
            font-size: 10px;
            border-radius: 2px;
            -webkit-animation: BLINK 1s infinite; /* Safari 4+ */
            -moz-animation: BLINK 1s infinite; /* Fx 5+ */
            -o-animation: BLINK 1s infinite; /* Opera 12+ */
            animation: BLINK 1s infinite; /* IE 10+, Fx 29+ */
        }

        .pro-tag {
            cursor: no-drop;
            text-decoration: none;
            color: black;
        }


        @-webkit-keyframes BLINK {
            0%, 49% {
                background-color: #065a92;
            }
            50%, 100% {
                background-color: #e50000;
            }
        }

        .category_items {
            display: flex;
            flex-wrap: wrap;
        }

        .category_item {
            width: 105px;
            height: 55px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            background-color: #065a92;
            color: white;
            border: 1px solid #065a92;
            margin-left: 4px;
            margin-right: 4px;
            position: relative;
            line-height: 1.23;
            padding: 2px 4px;
            margin-bottom: 8px;

        }


        .category_item:hover {
            color: #065a92;
            background-color: white;
        }

        .items {
            display: flex;
            flex-wrap: wrap;
        }

        .item {
            margin-left: 4px;
            margin-right: 4px;
            position: relative;
            line-height: 1.23;
            padding: 2px 4px;
            margin-bottom: 8px;
            width: 105px;
            height: 85px;
            font-size: 14px;
            font-weight: bolder;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            color: #232323;
            background-color: #c2e1f3;
            border-color: #c2e1f3;
        }

        .item:hover {
            color: #065a92;
            background-color: white;
        }

        svg:hover {
            color: inherit;
            fill: currentColor;
        }


        .animate_color {
            background: #FCE97F;
            animation: fadebackground 6s 2s;
        }
        @keyframes fadebackground {
            from {background-color: #FCE97F;}
            to {background-color: #065a92;}
        }
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #666b7a;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="">
<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="min-height: 400px">

            <div class="modal-body d-flex align-items-center justify-content-center" style="width: 100%;height: 100%"
                 id="modalContent">

                <img class="m-auto" style="text-align: center;height: 100%;"
                     src="https://cdn.website-editor.net/6c0e2b50d21d4c9eadf0308619dad381/dms3rep/multi/Geduld.gif"
                     alt="" width="100">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="">


    <div class="m-4" style="height: 100vh;position:relative;">

        @yield('content')
        {{ $slot ?? '' }}

    </div>


    <!-- Modal-->
    <div class="modal fade" id="proModal" tabindex="-1" role="dialog" aria-labelledby="proModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="proModal">Upgrade required</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    This is a pro feature. Upgrade to unlock the feature.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-primary font-weight-bold subscribeModal" data-dismiss="modal">
                        Upgrade Pro
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>


<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#065a92",
                    "secondary": "#E5EAEE",
                    "success": "#065a92",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>


<!-- base js -->
<!-- JavaScript Bundle with Popper -->


<script src="https://cdn.jsdelivr.net/npm/ractive"></script>
<script src="https://cdn.jsdelivr.net/npm/ractive-transitions-fade"></script>
<script src="https://cdn.jsdelivr.net/npm/ractive-transitions-slide"></script>
<script src="https://cdn.jsdelivr.net/npm/ractive-transitions-fly"></script>


{{--<script src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.js?v=7.2.8"></script>--}}
<script
    src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/js/scripts.bundle.js?v=7.2.8"></script>


<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/jquery-form/form@4.3.0/dist/jquery.form.min.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"
        integrity="sha512-vCgNjt5lPWUyLz/tC5GbiUanXtLX1tlPXVFaX5KAQrUHjwPcCwwPOLn34YBFqws7a7+62h7FRvQ1T0i/yFqANA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css"
      integrity="sha512-rQESClU96g/m7xFESOEisIKXZapchOd6+HfUTaMzGXtBFfF837IDR0utlmq58hgoAqGUWQn9LeZbw2DtOgaWYg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {


        Date.prototype.addDays = function (days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }


    })
</script>
<script>
    Ractive.DEBUG = true;
    $.fn.select2.defaults.set("theme", "bootstrap");
    var csrf = $('meta[name=csrf-token]').attr('content');
    $(document).ready(function () {

        $('.nav-item').mouseenter(function () {
            $(this).find('.nav-title').css('color', '#065a92')
            $(this).find('.nav-desc').css('color', '#065a92')
        })
        $('.nav-item').mouseleave(function () {

            $(this).find('.nav-title').css('color', 'white')
            $(this).find('.nav-desc').css('color', 'white')

        })

        $('.subscribeModal').on('click', function (e) {
            $('#subscribeModal').modal('show')
            $.ajax({
                url: "{{ route('subscriptions.modal') }}",
                success: function (result) {

                    $("#modalContent").removeClass('d-flex align-items-center justify-content-center');
                    $("#modalContent").html(result);
                    $.getScript('https://js.stripe.com/v3/', function () {
                        $.getScript("{{ asset('js/subscriptions/subscribe.js') }}")
                    })

                }
            });
        })

        $('.pro-tag').attr('href', 'javascript:;')
        $('.pro-tag').on('click', function () {
            $('#proModal').modal('show')
        })


    })

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@yield('js')
@stack('js')

<script>
    $(document).ready(function () {
        $('#ledger_group_id').select2({dropdownParent: $("#ledgerModal")})

    })
</script>

</body>

</html>
