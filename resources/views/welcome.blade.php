<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>InvoicePedia - Free Online Invoice Generator, Billing & Accounting Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="InvoicePedia - Free Online Invoice Generator, Billing & Accounting Online, Zoho books, Freshbooks, waveapps, "/>
    <meta name="keywords" content="Online Invoices, Estimate, Billing, Online Payment,Online Accounting Software"/>
    <meta name="author" content="InvoicePedia"/>
    <meta name="email" content="invoicepedia@gmail.com"/>
    <meta name="website" content="{{ url('/') }}"/>
    <meta name="Version" content="v3.5.0"/>

    <!-- Bootstrap -->
    <link href="https://shreethemes.in/landrick/layouts/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Icons -->
    <link href="{{ asset('css/materialicons.css') }}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <!-- Slider -->
    <link rel="stylesheet" href="https://shreethemes.in/landrick/layouts/css/tiny-slider.css"/>
    <!-- Date picker -->
    <link rel="stylesheet" href="https://shreethemes.in/landrick/layouts/css/datepicker.min.css">
    <!-- Main Css -->
    <link href="https://shreethemes.in/landrick/layouts/css/style.min.css" rel="stylesheet" type="text/css"
          id="theme-opt"/>
    <link href="https://shreethemes.in/landrick/layouts/css/colors/default.css" rel="stylesheet" id="color-opt">
    <link href="https://shreethemes.in/landrick/layouts/css/materialdesignicons.min.css" rel="stylesheet"
          id="color-opt">
    <script src="https://use.fontawesome.com/715fc6bd34.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

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

        .btn.btn-primary {
            color: #065a92;
            background-color: transparent;
            border-color: #065a92;
        }

        .btn.btn-primary:hover {
            background-color: #053251 !important;
            border-color: #053251;
        }
    </style>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J35PC4G2SJ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-J35PC4G2SJ');
    </script>
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
                            <div class="login-btn-primary">
                                <span class="btn btn-pills btn-primary"><i
                                        class="fa fa-sign-in-alt"> My Account </i> </span>
                            </div>
                            <div class="login-btn-light">
                        <span class="btn btn-pills btn-light">
                            <i class="fa fa-sign-in-alt"> My Account </i> </span>
                            </div>
                        </a>
                    </li>

                </ul>

            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->

<!-- Hero Start -->
<section class="bg-half-170 d-table w-100"
         style="background: url('{{ asset('images/invoicess.PNG') }}') center center;padding-top: 100px">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <div class="title-heading mt-4">
                    <h1 class="display-4 fw-bold text-white title-dark mb-3"><strong>Invoicing & Billing</strong><br>
                        made easy</h1>
                    <p class="para-desc text-white-50">Free online invoicing and billing software for small and large
                        business. Accounting, Invoice, Billing, Sales, Purchase, Inventory Management, Send & Print
                        Invoice Online is so simple in invoicepedia. InvoicePedia makes creating professional looking
                        invoices for your business ridiculously easy</p>

                </div>
            </div><!--end col-->

            <div class="col-lg-5 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="card shadow rounded border-0 ms-lg-5">
                    <div class="card-body">
                        <h5 class="card-title">Join Now</h5>

                        <div>
                            <form class="login-form mt-4" action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-user fea icon-sm icons">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                                <input type="email" class="form-control ps-5" placeholder="Email"
                                                       name="email" required="" autocomplete="off"
                                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Password <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-key fea icon-sm icons">
                                                    <path
                                                        d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
                                                </svg>
                                                <input type="password" class="form-control ps-5" placeholder="Password"
                                                       required="" autocomplete="off"
                                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                            </div>
                                        </div>
                                    </div><!--end col-->


                                    <div class="col-lg-12 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary">Try For Free</button>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12 mt-4 text-center">
                                        <h6>Or Login With</h6>
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="{{ route('social.redirect','facebook') }}"
                                                       class="btn btn-primary"><i
                                                            class="fab fa-facebook-f"></i> Facebook</a>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="{{ route('social.redirect','google') }}"
                                                       class="btn btn-danger"><i class="fab fa-google"></i></i>
                                                        Google</a>
                                                </div>
                                            </div><!--end col-->
                                        </div>
                                    </div><!--end col-->

                                </div><!--end row-->
                            </form>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section><!--end section-->
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
<!-- Hero End -->

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-left">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4 text-center">Benefit for users using <strong class="font-weight-bolder" style="font-weight: 900;font-family: system-ui"><span style="color: #0d71bb">Invoice</span><span style="color: red">Pedia</span></strong></h4>
                    <span class="text-muted para-desc mb-0 mx-auto">Start working with <span class="text-primary fw-bold"><span style="color: #0d71bb">Invoice</span><span style="color: red">Pedia</span></span>
                        that can provide easy solution to <h1 class="d-inline" style="font-size: 16px !important;display: inline"> <strong>create invoices online</strong></h1> and send it to your
                        business client.
                        Making an invoice is sometimes like a hard-nut-crack for almost every business person. A lot of
                        work needs to be done, like, itemizing charges, calculating taxes, managing online payments and
                        many more. Exactly this is why we are here.
                        <br>

                        Just with a couple of clicks you can add and save products, create clients, and send them
                        invoices with online payment options. Any data once inserted manually, is instantly saved in the
                        database. You don’t have to write the same thing twice later. Tracking invoices is also a great
                        convenience. This software is definitely free and free for lifetime. There is no invoice limit
                        or client limit. Use it as many times as you need.
                    </span>
                </div>
            </div><!--end col-->
        </div><!--end row-->

        <div class="row">
            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-shield-check"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>Secure Payment</h5>
                        <p class="para text-muted mb-0">Receive payment by sharing invoice online instantly and billing
                            as well</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-shield-check"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-thumbs-up"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>Easy Accounting</h5>
                        <p class="para text-muted mb-0">It is a long established fact that a user can simply manage
                            accounting / bookkeeping with no pressure. </p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-thumbs-up"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-keyboard-show"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>Free of use</h5>
                        <p class="para text-muted mb-0">You can always create invoices , estimate and billing for
                            free.</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-keyboard-show"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-award"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>Invoices</h5>
                        <p class="para text-muted mb-0">Manage Invoices , Edit anytime, Share online, Send Invoice
                            Online by just one click.</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-award"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-bookmark"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>Cheap than Other</h5>
                        <p class="para text-muted mb-0">It is the cheapest invoicing software ever on the internet.</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-bookmark"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-favorite"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>Estimate Invoice</h5>
                        <p class="para text-muted mb-0"> Create estimate and send to your client and turn the estimate
                            to invoice within a moment.</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-favorite"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-clock"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>24/7 Support</h5>
                        <p class="para text-muted mb-0">Invoicepedia team is always on to help you at anytime.</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-clock"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div
                    class="card features fea-primary rounded p-4 bg-light text-center position-relative overflow-hidden border-0">
                            <span class="h1 icon2 text-primary">
                                <i class="uil uil-process"></i>
                            </span>
                    <div class="card-body p-0 content">
                        <h5>Billing/Purchase</h5>
                        <p class="para text-muted mb-0">Create a billing or purchase invoice and send online with few
                            steps.</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-process"></i>
                            </span>
                </div>
            </div><!--end col-->

        </div><!--end row-->
    </div><!--end container-->


</section><!--end section-->


<!-- Footer Start -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-60">
                    <div class="row">
                        <div class="col-12 ">
                            <a href="#" class="logo-footer">
                                <img src="{{ asset('images/invoicepedia-white.png') }}" height="24" alt="">
                            </a>
                            <p class="mt-4">InvoicePedia makes small and large business invoicing and billing so simple.
                                Its the best invoicing software online for free. Invoicepedia is inspired by Scoro,
                                QuickBooks, Freshbooks, Zoho Books, Xero, Sage 50c, Wave, Invoice2go, OneUp, SliQ
                                Invoicing, BillQuick Online, FinancialForce Billing, Chargebee, WORKetc, Harvest,
                                PaySimple, Zervant, KashFlow, Bill.com. Invoicepedia extends all features from existing
                                online software in the market and added some exciting features to make your business
                                running smothly.</p>
                        </div><!--end col-->

                    </div><!--end row-->
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class="footer-py-30 footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-start">
                        <p class="mb-0">©
                            <script>document.write(new Date().getFullYear())</script>
                            InvoicePedia.com . Design with <i class="mdi mdi-heart text-danger"></i> by <a
                                href="{{ url('/') }}" target="_blank" class="text-reset">Invoice Pedia</a>.
                        </p>
                    </div>
                </div><!--end col-->

                <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <ul class="list-unstyled text-sm-end mb-0">
                        <li class="list-inline-item"><a href="javascript:void(0)"><img
                                    src="images/payments/american-ex.png" class="avatar avatar-ex-sm"
                                    title="American Express" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img
                                    src="images/payments/discover.png" class="avatar avatar-ex-sm" title="Discover"
                                    alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img
                                    src="images/payments/master-card.png" class="avatar avatar-ex-sm"
                                    title="Master Card" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/paypal.png"
                                                                                       class="avatar avatar-ex-sm"
                                                                                       title="Paypal" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/visa.png"
                                                                                       class="avatar avatar-ex-sm"
                                                                                       title="Visa" alt=""></a></li>
                    </ul>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </div>
</footer><!--end footer-->
<!-- Footer End -->

<!-- Offcanvas Start -->
<div class="offcanvas offcanvas-end bg-white shadow" tabindex="-1" id="offcanvasRight"
     aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header p-4 border-bottom">
        <h5 id="offcanvasRightLabel" class="mb-0">
            <img src="images/logo-dark.png" height="24" class="light-version" alt="">
            <img src="images/logo-light.png" height="24" class="dark-version" alt="">
        </h5>
        <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas"
                aria-label="Close"><i class="uil uil-times fs-4"></i></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="row">
            <div class="col-12">
                <img src="images/contact.svg" class="img-fluid d-block mx-auto" style="max-width: 256px;" alt="">
                <div class="card border-0 mt-5" style="z-index: 1">
                    <div class="card-body p-0">
                        <form method="post" name="myForm" onsubmit="return validateForm()">
                            <p id="error-msg" class="mb-0"></p>
                            <div id="simple-msg"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="name" id="name" type="text" class="form-control ps-5"
                                                   placeholder="Name :">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input name="email" id="email" type="email" class="form-control ps-5"
                                                   placeholder="Email :">
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Subject</label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="book" class="fea icon-sm icons"></i>
                                            <input name="subject" id="subject" class="form-control ps-5"
                                                   placeholder="subject :">
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Comments <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="message-circle" class="fea icon-sm icons clearfix"></i>
                                            <textarea name="comments" id="comments" rows="4" class="form-control ps-5"
                                                      placeholder="Message :"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" id="submit" name="send" class="btn btn-primary">Send
                                            Message
                                        </button>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>

    <div class="offcanvas-footer p-4 border-top text-center">
        <ul class="list-unstyled social-icon social mb-0">
            <li class="list-inline-item mb-0"><a href="https://1.envato.market/4n73n" target="_blank" class="rounded"><i
                        class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank"
                                                 class="rounded"><i class="uil uil-dribbble align-middle"
                                                                    title="dribbble"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank"
                                                 class="rounded"><i class="uil uil-facebook-f align-middle"
                                                                    title="facebook"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank"
                                                 class="rounded"><i class="uil uil-instagram align-middle"
                                                                    title="instagram"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://twitter.com/shreethemes" target="_blank" class="rounded"><i
                        class="uil uil-twitter align-middle" title="twitter"></i></a></li>
            <li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i
                        class="uil uil-envelope align-middle" title="email"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i
                        class="uil uil-globe align-middle" title="website"></i></a></li>
        </ul><!--end icon-->
    </div>
</div>
<!-- Offcanvas End -->

<!-- Back to top -->
<a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up"
                                                                                 class="fea icon-sm icons align-middle"></i></a>
<!-- Back to top -->


<!-- javascript -->
<script src="https://shreethemes.in/landrick/layouts/js/bootstrap.bundle.min.js"></script>
<!-- SLIDER -->
<script src="https://shreethemes.in/landrick/layouts/js/tiny-slider.js "></script>
<!-- Datepicker -->
<script src="https://shreethemes.in/landrick/layouts/js/datepicker.min.js"></script>
<!-- Icons -->
<script src="https://shreethemes.in/landrick/layouts/js/feather.min.js"></script>
<!-- Switcher -->
<script src="https://shreethemes.in/landrick/layouts/js/switcher.js"></script>
<!-- Main Js -->
<script src="https://shreethemes.in/landrick/layouts/js/plugins.init.js"></script>
<!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
<script src="https://shreethemes.in/landrick/layouts/js/app.js"></script>
<!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
</body>
</html>
