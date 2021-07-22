<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>InvoicePedia - Free Invoice Generator , Billing & Accounting Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Bootstrap 5 Landing Page Template"/>
    <meta name="keywords" content="Saas, Software, multi-uses, HTML, Clean, Modern"/>
    <meta name="author" content="Shreethemes"/>
    <meta name="email" content="support@shreethemes.in"/>
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
</head>

<body>
<!-- Loader -->
<!-- <div id="preloader">
    <div id="status">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
</div> -->
<!-- Loader -->

<!-- Navbar STart -->
<header id="topnav" class="defaultscroll sticky">
    <div class="container">
        <!-- Logo container-->
        <a class="logo" href="{{ url('/') }}">
                    <span class="logo-light-mode">
                        <img src="{{ asset('images/invoicepedia.png') }}" class="l-dark" height="80" alt="">
                        <img src="{{ asset('images/invoicepedia-white.png') }}" class="l-light" height="80" alt="">
                    </span>
            <img src="https://test.io/wp-content/uploads/2019/02/testIO-logo-rgb-2.png" height="24"
                 class="logo-dark-mode" alt="">
        </a>

        <!-- End Logo container-->
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
        <ul class="buy-button list-inline mb-0">
            <li class="list-inline-item mb-0">
                <a href="{{ route('acc.home') }}">
                    <div class="login-btn-primary">
                        <span class="btn btn-pills btn-primary"><i class="fa fa-sign-in-alt"> My Account </i> </span>
                    </div>
                    <div class="login-btn-light">
                        <span class="btn btn-pills btn-light">
                            <i class="fa fa-sign-in-alt"> My Account </i> </span>
                    </div>
                </a>
            </li>

        </ul>
        <!--Login button End-->

        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu nav-light">
                <li class="d-none has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Pricing</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="documentation.html" class="sub-menu-item">Documentation</a></li>
                        <li><a href="changelog.html" class="sub-menu-item">Changelog</a></li>
                        <li><a href="components.html" class="sub-menu-item">Components</a></li>
                        <li><a href="widget.html" class="sub-menu-item">Widget</a></li>
                    </ul>
                </li>
                <li class="d-none has-submenu parent-menu-item">
                    <a href="#pricing">Pricing</a>

                </li>
            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->

<!-- Hero Start -->
<section class="bg-half-170 d-table w-100"
         style="background: url('{{ asset('images/invoicess.PNG') }}') center center;padding: 100px">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <div class="title-heading mt-4">
                    <h1 class="display-4 fw-bold text-white title-dark mb-3">Invoicing & Billing<br> made easy</h1>
                    <p class="para-desc text-white-50">Launch your campaign and benefit from our expertise on designing
                        and managing conversion centered bootstrap v5 html page.</p>

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
                                            <button class="btn btn-primary">Sign Up</button>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12 mt-4 text-center">
                                        <h6>Or Login With</h6>
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="javascript:void(0)" class="btn btn-primary"><i class="fab fa-facebook-f"></i> Facebook</a>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="javascript:void(0)" class="btn btn-danger"><i class="fab fa-google"></i></i> Google</a>
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
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Benefit for Traveller</h4>
                    <p class="text-muted para-desc mb-0 mx-auto">Start working with <span class="text-primary fw-bold">Landrick</span>
                        that can provide everything you need to generate awareness, drive traffic, connect.</p>
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
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
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
                        <h5>Easy Book</h5>
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
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
                        <h5>Free Amenities</h5>
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
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
                        <h5>Best Offers</h5>
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
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
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
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
                        <h5>Top Rated</h5>
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
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
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
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
                        <h5>Fast Refund</h5>
                        <p class="para text-muted mb-0">It is a long established fact that a reader.</p>
                    </div>
                    <span class="big-icon text-center">
                                <i class="uil uil-process"></i>
                            </span>
                </div>
            </div><!--end col-->

            <div class="col-lg-12 text-center col-md-4 mt-4 pt-2">
                <a href="javascript:void(0)" class="btn btn-primary">See more <i data-feather="arrow-right"
                                                                                 class="fea icon-sm"></i></a>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class="container mt-100 mt-60">
        <div class="row align-items-end mb-4 pb-2">
            <div class="col-md-8">
                <div class="section-title text-center text-md-start">
                    <h6 class="text-primary">Find Out Most</h6>
                    <h4 class="title mb-4">Popular Destination</h4>
                    <p class="text-muted mb-0 para-desc">Start working with <span
                            class="text-primary fw-bold">Landrick</span> that can provide everything you need to
                        generate awareness, drive traffic, connect.</p>
                </div>
            </div><!--end col-->

            <div class="col-md-4 mt-4 mt-sm-0">
                <div class="text-center text-md-end">
                    <a href="javascript:void(0)" class="text-primary h6">See More <i data-feather="arrow-right"
                                                                                     class="fea icon-sm"></i></a>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4 pt-2">
                <div class="tiny-six-item">
                    <div class="tiny-slide">
                        <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                            <img src="images/travel/dubai.jpg" class="img-fluid" alt="">
                            <div class="overlay-work bg-dark"></div>
                            <div class="content">
                                <a href="javascript:void(0)" class="title text-white h4 title-dark">Dubai</a>
                            </div>
                        </div><!--end tour post-->
                    </div>

                    <div class="tiny-slide">
                        <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                            <img src="images/travel/thailand.jpg" class="img-fluid" alt="">
                            <div class="overlay-work bg-dark"></div>
                            <div class="content">
                                <a href="javascript:void(0)" class="title text-white h4 title-dark">Thailand</a>
                            </div>
                        </div><!--end tour post-->
                    </div>

                    <div class="tiny-slide">
                        <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                            <img src="images/travel/india.jpg" class="img-fluid" alt="">
                            <div class="overlay-work bg-dark"></div>
                            <div class="content">
                                <a href="javascript:void(0)" class="title text-white h4 title-dark">India</a>
                            </div>
                        </div><!--end tour post-->
                    </div>

                    <div class="tiny-slide">
                        <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                            <img src="images/travel/london.jpg" class="img-fluid" alt="">
                            <div class="overlay-work bg-dark"></div>
                            <div class="content">
                                <a href="javascript:void(0)" class="title text-white h4 title-dark">Londan</a>
                            </div>
                        </div><!--end tour post-->
                    </div>

                    <div class="tiny-slide">
                        <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                            <img src="images/travel/paris.jpg" class="img-fluid" alt="">
                            <div class="overlay-work bg-dark"></div>
                            <div class="content">
                                <a href="javascript:void(0)" class="title text-white h4 title-dark">Paris</a>
                            </div>
                        </div><!--end tour post-->
                    </div>

                    <div class="tiny-slide">
                        <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                            <img src="images/travel/singapore.jpg" class="img-fluid" alt="">
                            <div class="overlay-work bg-dark"></div>
                            <div class="content">
                                <a href="javascript:void(0)" class="title text-white h4 title-dark">Singapore</a>
                            </div>
                        </div><!--end tour post-->
                    </div>

                    <div class="tiny-slide">
                        <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                            <img src="images/travel/dubai.jpg" class="img-fluid" alt="">
                            <div class="overlay-work bg-dark"></div>
                            <div class="content">
                                <a href="javascript:void(0)" class="title text-white h4 title-dark">Dubai</a>
                            </div>
                        </div><!--end tour post-->
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
</section><!--end section-->

<section class="section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title">
                    <h4 class="title fw-bold mb-4">Everyone Needs Travel. <br> Want to Break Free for a While</h4>
                    <p class="text-muted para-desc mb-0 mx-auto">Start working with <span class="text-primary fw-bold">Landrick</span>
                        that can provide everything you need to generate awareness, drive traffic, connect.</p>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class="container mt-100 mt-60">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6">
                <div class="card blog rounded border-0 shadow overflow-hidden">
                    <div class="position-relative">
                        <img src="images/travel/1.jpg" class="card-img-top" alt="...">
                        <div class="overlay rounded-top bg-dark"></div>
                    </div>
                    <div class="card-body content">
                        <h5><a href="javascript:void(0)" class="card-title title text-dark">Conversations, Feedback,
                                Recognition</a></h5>
                        <div class="post-meta d-flex justify-content-between mt-3">
                            <ul class="list-unstyled mb-0">
                                <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)"
                                                                          class="text-muted like"><i
                                            class="uil uil-heart me-1"></i>33</a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i
                                            class="uil uil-comment me-1"></i>08</a></li>
                            </ul>
                            <a href="blog-detail.html" class="text-muted readmore">Read More <i
                                    class="uil uil-angle-right-b align-middle"></i></a>
                        </div>
                    </div>
                    <div class="author">
                        <small class="text-light user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>
                        <small class="text-light date"><i class="uil uil-calendar-alt"></i> 25th June 2021</small>
                    </div>
                </div>
            </div><!--end col-->

            <div class="col-lg-7 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="section-title ms-lg-4">
                    <h4 class="title mb-4">Experience Luxury & <br> Find Your Base</h4>
                    <p class="text-muted">You can combine all the Landrick templates into a single one, you can take a
                        component from the Application theme and use it in the Website.</p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-0"><span class="text-primary h5 me-2"><i
                                    class="uil uil-check-circle align-middle"></i></span>Digital Marketing Solutions for
                            Tomorrow
                        </li>
                        <li class="mb-0"><span class="text-primary h5 me-2"><i
                                    class="uil uil-check-circle align-middle"></i></span>Our Talented & Experienced
                            Marketing Agency
                        </li>
                        <li class="mb-0"><span class="text-primary h5 me-2"><i
                                    class="uil uil-check-circle align-middle"></i></span>Create your own skin to match
                            your brand
                        </li>
                    </ul>
                    <a href="javascript:void(0)" class="mt-3 h6 text-primary">Search Destination <i
                            class="uil uil-angle-right-b"></i></a>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class="container mt-100 mt-60">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6 order-1 order-md-2">
                <img src="images/travel/3.jpg" class="img-fluid rounded shadow-md" alt="">
            </div><!--end col-->

            <div class="col-lg-7 col-md-6 order-2 order-md-1 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="section-title me-lg-5">
                    <h4 class="title mb-4">100% Money back <br> Guarantee if You Cancel</h4>
                    <p class="text-muted">You can combine all the Landrick templates into a single one, you can take a
                        component from the Application theme and use it in the Website.</p>
                </div>

                <div class="accordion mt-4 pt-2" id="accordionExample">
                    <div class="accordion-item rounded shadow">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button border-0 bg-light" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                How does it work ?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse border-0 collapse show"
                             aria-labelledby="headingOne"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body text-muted bg-white">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item rounded shadow mt-2">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                Do I need a designer to use Landrick ?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse border-0 collapse" aria-labelledby="headingTwo"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body text-muted bg-white">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item rounded shadow mt-2">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What do I need to do to start selling ?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse border-0 collapse"
                             aria-labelledby="headingThree"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body text-muted bg-white">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item rounded shadow mt-2">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                What happens when I receive an order ?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse border-0 collapse"
                             aria-labelledby="headingFour"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body text-muted bg-white">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form.
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class="container mt-100 mt-60">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6">
                <img src="images/travel/2.jpg" class="img-fluid rounded shadow-md" alt="">
            </div><!--end col-->

            <div class="col-lg-7 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="section-title ms-lg-4">
                    <h4 class="title mb-4">We have More than 500 <br> Selected Destination</h4>
                    <p class="text-muted">You can combine all the Landrick templates into a single one, you can take a
                        component from the Application theme and use it in the Website.</p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-0"><span class="text-primary h5 me-2"><i
                                    class="uil uil-check-circle align-middle"></i></span>Digital Marketing Solutions for
                            Tomorrow
                        </li>
                        <li class="mb-0"><span class="text-primary h5 me-2"><i
                                    class="uil uil-check-circle align-middle"></i></span>Our Talented & Experienced
                            Marketing Agency
                        </li>
                        <li class="mb-0"><span class="text-primary h5 me-2"><i
                                    class="uil uil-check-circle align-middle"></i></span>Create your own skin to match
                            your brand
                        </li>
                    </ul>
                    <a href="javascript:void(0)" class="mt-3 h6 text-primary">Search Destination <i
                            class="uil uil-angle-right-b"></i></a>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class="container mt-100 mt-60">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Whats Our Clients Said About <span class="text-primary">Landrick</span>
                        Project</h4>
                    <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">Landrick</span>
                        that can provide everything you need to generate awareness, drive traffic, connect.</p>
                </div>
            </div><!--end col-->
        </div><!--end row-->

        <div class="row justify-content-center">
            <div class="col-lg-12 mt-4">
                <div class="tiny-three-item">
                    <div class="tiny-slide">
                        <div class="d-flex client-testi m-2">
                            <img src="images/client/01.jpg" class="avatar avatar-small client-image rounded shadow"
                                 alt="">
                            <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                </ul>
                                <p class="text-muted mt-2">" It seems that only fragments of the original text remain in
                                    the Lorem Ipsum texts used today. "</p>
                                <h6 class="text-primary">- Thomas Israel <small class="text-muted">C.E.O</small></h6>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="d-flex client-testi m-2">
                            <img src="images/client/02.jpg" class="avatar avatar-small client-image rounded shadow"
                                 alt="">
                            <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star-half text-warning"></i></li>
                                </ul>
                                <p class="text-muted mt-2">" One disadvantage of Lorum Ipsum is that in Latin certain
                                    letters appear more frequently than others. "</p>
                                <h6 class="text-primary">- Barbara McIntosh <small class="text-muted">M.D</small></h6>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="d-flex client-testi m-2">
                            <img src="images/client/03.jpg" class="avatar avatar-small client-image rounded shadow"
                                 alt="">
                            <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                </ul>
                                <p class="text-muted mt-2">" The most well-known dummy text is the 'Lorem Ipsum', which
                                    is said to have originated in the 16th century. "</p>
                                <h6 class="text-primary">- Carl Oliver <small class="text-muted">P.A</small></h6>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="d-flex client-testi m-2">
                            <img src="images/client/04.jpg" class="avatar avatar-small client-image rounded shadow"
                                 alt="">
                            <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                </ul>
                                <p class="text-muted mt-2">" According to most sources, Lorum Ipsum can be traced back
                                    to a text composed by Cicero. "</p>
                                <h6 class="text-primary">- Christa Smith <small class="text-muted">Manager</small></h6>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="d-flex client-testi m-2">
                            <img src="images/client/05.jpg" class="avatar avatar-small client-image rounded shadow"
                                 alt="">
                            <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                </ul>
                                <p class="text-muted mt-2">" There is now an abundance of readable dummy texts. These
                                    are usually used when a text is required. "</p>
                                <h6 class="text-primary">- Dean Tolle <small class="text-muted">Developer</small></h6>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="d-flex client-testi m-2">
                            <img src="images/client/06.jpg" class="avatar avatar-small client-image rounded shadow"
                                 alt="">
                            <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                </ul>
                                <p class="text-muted mt-2">" Thus, Lorem Ipsum has only limited suitability as a visual
                                    filler for German texts. "</p>
                                <h6 class="text-primary">- Jill Webb <small class="text-muted">Designer</small></h6>
                            </div>
                        </div>
                    </div>
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
                        <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                            <a href="#" class="logo-footer">
                                <img src="{{ asset('images/invoicepedia-white.png') }}" height="24" alt="">
                            </a>
                            <p class="mt-4">Start working with Landrick that can provide everything you need to generate
                                awareness, drive traffic, connect.</p>
                            <ul class="list-unstyled social-icon foot-social-icon mb-0 mt-4">
                                <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                            data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                            data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                            data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                            data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                            </ul><!--end icon-->
                        </div><!--end col-->

                        <div class="col-lg-2 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Company</h5>
                            <ul class="list-unstyled footer-list mt-4">
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> About us</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Services</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Team</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Pricing</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Project</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Careers</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Blog</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Login</a></li>
                            </ul>
                        </div><!--end col-->

                        <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Usefull Links</h5>
                            <ul class="list-unstyled footer-list mt-4">
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Terms of Services</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Privacy Policy</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Documentation</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Changelog</a></li>
                                <li><a href="javascript:void(0)" class="text-foot"><i
                                            class="uil uil-angle-right-b me-1"></i> Components</a></li>
                            </ul>
                        </div><!--end col-->

                        <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Newsletter</h5>
                            <p class="mt-4">Sign up and receive the latest tips via email.</p>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="foot-subscribe mb-3">
                                            <label class="form-label">Write your email <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                                <input type="email" name="email" id="emailsubscribe"
                                                       class="form-control ps-5 rounded" placeholder="Your email : "
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-grid">
                                            <input type="submit" id="submitsubscribe" name="send"
                                                   class="btn btn-soft-primary" value="Subscribe">
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                            Landrick. Design with <i class="mdi mdi-heart text-danger"></i> by <a
                                href="https://shreethemes.in/" target="_blank" class="text-reset">Shreethemes</a>.
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
