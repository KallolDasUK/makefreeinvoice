<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title> {{ $title??'InvoicePedia - Free Online Invoice Generator, Billing & Accounting Online' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

{!! SEOMeta::generate() !!}
{!! OpenGraph::generate() !!}
{!! Twitter::generate() !!}
{!! JsonLd::generate() !!}
{!! JsonLdMulti::generate() !!}
<!-- Bootstrap -->
    {{--    <link href="https://shreethemes.in/landrick/layouts/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>--}}
    <link href="https://shreethemes.in/landrick/landing/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    @php($hide_messenger=$hide_messenger??false)
<!-- Icons -->
    <link href="{{ asset('css/materialicons.css') }}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <!-- Slider -->
    <link rel="stylesheet" href="https://shreethemes.in/landrick/landing/css/tiny-slider.css"/>
    <!-- Date picker -->
    <link rel="stylesheet" href="https://shreethemes.in/landrick/landing/css/datepicker.min.css">
    <!-- Main Css -->

    <link href="https://shreethemes.in/landrick/landing/css/style.min.css" rel="stylesheet" type="text/css"
          id="theme-opt"/>
    <link href="https://shreethemes.in/landrick/landing/css/colors/default.css" rel="stylesheet" id="color-opt">
    <link href="https://shreethemes.in/landrick/landing/css/materialdesignicons.min.css" rel="stylesheet"
          id="color-opt">
    <script src="https://use.fontawesome.com/715fc6bd34.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link href='http://fonts.googleapis.com/css?family=Orbitron:400,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fallingtextrotator.css') }}"/>

    <script src="{{ asset('js/jquery.lettering-0.6.1.min.js') }}"></script>

    <script src="{{ asset('js/fallingtextrotator.js') }}"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}"/>
    <style>
        .bg-overlay {
            background-color: #065a92;
        }

        .btn.btn-outline-primary {
            color: #065a92;
            background-color: transparent;
            border-color: #065a92;
        }

        .btn.btn-outline-success {
            color: #065a92;
            background-color: transparent;
            border-color: #065a92;
        }

        .btn.btn-primary {
            color: #065a92;
            background-color: transparent;
            border-color: #065a92;
        }

        .btn.btn-success {
            color: white;
            background-color: #065a92;
            border-color: #065a92;
        }

        .btn.btn-primary:hover {
            background-color: #053251 !important;
            border-color: #053251;
        }

        .sticky {
            background-color: #065a92 !important;
        }

        .nav-sticky {
            background-color: white !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.1/js.cookie.min.js"
            integrity="sha512-Meww2sXqNHxI1+5Dyh/9KAtvI9RZSA4c1K2k5iL02oiPO/RH3Q30L3M1albtqMg50u4gRTYdV4EXOQqXEI336A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('css')
</head>
<body>

<header id="topnav" class="defaultscroll sticky">
    <div class="container">
        <a class="logo" href="{{ url('/') }}">
                    <span class="logo-light-mode">
                        <img src="{{ asset('images/invoicepedia.png') }}" class="l-dark" height="80" alt="">
                        <img src="{{ asset('images/invoicepedia-white.png') }}" class="l-light" height="80" alt="">
                    </span>

        </a>

        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <!--Login button Start-->
        <!--Login button End-->

        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu nav-light" style="display: inline!important;">
                <li class="d-none has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Pricing</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="changelog.html" class="sub-menu-item">Changelog</a></li>

                    </ul>
                </li>
                <li class="d-none has-submenu parent-menu-item">
                    <a href="#pricing">Pricing</a>

                </li>
                <ul class="buy-button list-inline mb-0">
                    <li class="list-inline-item mb-0">

                        <a href="{{ route('acc.home') }}">

                            <div class="login-btn-light">
                        <span class="btn btn-pills btn-light">

                            @auth
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path
                                        d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7"
                                                                                                     r="4"></circle></svg>
                                My Account @else <i class="fa fa-sign-in-alt"></i>  Login @endauth   </span>
                            </div>
                            <div class="login-btn-primary">
                                <span class="btn btn-pills btn-primary">

                                    @auth
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path
                                                d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12"
                                                                                                             cy="7"
                                                                                                             r="4"></circle></svg>
                                        My Account @else <i class="fa fa-sign-in-alt"></i>  Login @endauth </span>
                            </div>
                        </a>
                    </li>

                </ul>

            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->
<div>
    @yield('content')
</div>

<!-- Back to top -->
<a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up"
                                                                                 class="fea icon-sm icons align-middle"></i></a>
<!-- Back to top -->


<!-- javascript -->
<script src="https://shreethemes.in/landrick/landing/js/bootstrap.bundle.min.js"></script>
<!-- SLIDER -->
<script src="https://shreethemes.in/landrick/landing/js/tiny-slider.js "></script>
<!-- Datepicker -->
<script src="https://shreethemes.in/landrick/landing/js/datepicker.min.js"></script>
<!-- Icons -->
<script src="https://shreethemes.in/landrick/landing/js/feather.min.js"></script>
<!-- Switcher -->
<script src="https://shreethemes.in/landrick/landing/js/switcher.js"></script>
<!-- Main Js -->
<script src="https://shreethemes.in/landrick/landing/js/plugins.init.js"></script>
<!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
<script src="https://shreethemes.in/landrick/landing/js/app.js"></script>
@yield('js')
<!-- Global Settings -->
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        })

    })
    var via = new URL(location.href).searchParams.get('via')
    // console.clear()
    console.log(via)
    if (via) {
        Cookies.set('invoicepedia_affiliate', via)
    }
</script>


<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>
@if(!$hide_messenger)
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "108404041579131");
        chatbox.setAttribute("attribution", "biz_inbox");

        window.fbAsyncInit = function () {
            FB.init({
                xfbml: true,
                version: 'v11.0'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endif
</body>
</html>
