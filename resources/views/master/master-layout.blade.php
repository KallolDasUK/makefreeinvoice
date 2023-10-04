<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Master | MakeFreeInvoice</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="">

    <!-- page css -->

    <!-- Core css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/2.1.0/select2.css" integrity="sha512-CeTclULLWLJj+H3XVCR+ZLGX2qK0f9SoPyjspqIg4s7ZnD5mWZ5oaTcuHr3lOXWk/FIUXD2JsvEj/ITqq8TAHQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2-bootstrap.min.css" integrity="sha512-eNfdYTp1nlHTSXvQD4vfpGnJdEibiBbCmaXHQyizI93wUnbCZTlrs1bUhD7pVnFtKRChncH5lpodpXrLpEdPfQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    <!-- Add DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    @yield('css')
    @push('css')

    @routes

</head>
<body>
<div class="app">
    <div class="layout">
        <!-- Header START -->
        <div class="header">
            <div class="logo logo-dark">
                <a href="{{ route('acc.home') }}">
                    <img height="50px" width="100" src="{{ asset('assets/images/logo/invoicepedia.png') }}" alt="Logo">

                </a>
            </div>
            <div class="logo logo-white">

            </div>
            <div class="nav-wrap">
{{--                <ul class="nav-left">--}}

{{--                    <nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0">--}}
{{--                        <input class="form-control form-control-dark w-100" type="text" placeholder="Search"--}}
{{--                               aria-label="Search">--}}

{{--                    </nav>--}}


{{--                </ul>--}}
                <div class="mt-3 ml-auto">
                    <ul class="navbar-nav float-right">
                        <li class="nav-item text-nowrap">
                            <a class="btn btn-outline" href=" {{ route('acc.home') }}" onclick="return confirm('Confirm Sign Out??')">Sign Out</a>

                        </li>
                    </ul>
                </div>



            </div>
        </div>
        <!-- Header END -->


        <!-- Side Nav START -->
        <div class="side-nav">
            <div class="side-nav-inner">
                <ul class="side-nav-menu scrollable">


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master.users') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-home"></i>
                            </span>
                            <span class="title"> Dashboard </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master.subscriptions') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-setting"></i>
                            </span>
                            <span class="title"> Subscription Settings </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master.contact.subscriptions') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-setting"></i>
                            </span>
                            <span class="title"> Contact Settings </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master.users') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-user"></i>
                            </span>
                            <span class="title"> Users </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('collect_payments.collect_payment.index') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-dollar"></i>
                            </span>
                            <span class="title"> Collect Payment </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('payment_requests.payment_request.index') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-dollar"></i>
                            </span>
                            <span class="title"> Withdraw Request </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user_notifications.user_notification.index') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-notification"></i>
                            </span>
                            <span class="title"> Send Notification </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('banner_ads.banner_ad.index') }}">
                            <span class="icon-holder">
                                    <i class="anticon anticon-setting"></i>
                            </span>
                            <span class="title"> Banner Settings </span>
                        </a>
                    </li>

                    <li class="nav-item dropdown open">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                    <i class="anticon anticon-message"></i>
                                </span>
                            <span class="title">Blog</span>
                            <span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="">
                                <a href=" {{route('blog.category.index')}}">Categories</a>
                            </li>
                            <li class="">
                                <a href=" {{route('post.index')}}">Posts</a>
                            </li>
                            {{--                            <li>--}}
                            {{--                                <a href="  {{route('blog.category.index')}}">Manage Blog</a>--}}
                            {{--                            </li>--}}
                        </ul>
                    </li>


                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span> Advance Ops</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                            <span class="icon-holder">
                                    <i class="anticon anticon-plus-circle"></i>
                            </span>
                        </a>
                    </h6>
                    <ul id="log" class="nav flex-column mx-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clear_cache') }}">
                                <span class="icon-holder">
                                    <i class="anticon anticon-delete"></i>
                                </span>
                                <span class="title"> Clear Cache </span>
                            </a>
                        </li>
                    </ul>

                </ul>
            </div>
        </div>
        <!-- Side Nav END -->

        <!-- Page Container START -->
        <div class="page-container">


            <!-- Content Wrapper START -->
            <div class="main-content">
                @yield('content')
            </div>
            <!-- Content Wrapper END -->

            <!-- Footer START -->

        <!-- Footer END -->

        </div>
        <!-- Page Container END -->

        <!-- Search Start-->

    <!-- Search End-->

        <!-- Quick View START -->
        <div class="modal modal-right fade quick-view" id="quick-view">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-between align-items-center">
                        <h5 class="modal-title">Theme Config</h5>
                    </div>
                    <div class="modal-body scrollable">
                        <div class="m-b-30">
                            <h5 class="m-b-0">Header Color</h5>
                            <p>Config header background color</p>
                            <div class="theme-configurator d-flex m-t-10">
                                <div class="radio">
                                    <input id="header-default" name="header-theme" type="radio" checked value="default">
                                    <label for="header-default"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-primary" name="header-theme" type="radio" value="primary">
                                    <label for="header-primary"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-success" name="header-theme" type="radio" value="success">
                                    <label for="header-success"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-secondary" name="header-theme" type="radio" value="secondary">
                                    <label for="header-secondary"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-danger" name="header-theme" type="radio" value="danger">
                                    <label for="header-danger"></label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <h5 class="m-b-0">Side Nav Dark</h5>
                            <p>Change Side Nav to dark</p>
                            <div class="switch d-inline">
                                <input type="checkbox" name="side-nav-theme-toogle" id="side-nav-theme-toogle">
                                <label for="side-nav-theme-toogle"></label>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <h5 class="m-b-0">Folded Menu</h5>
                            <p>Toggle Folded Menu</p>
                            <div class="switch d-inline">
                                <input type="checkbox" name="side-nav-fold-toogle" id="side-nav-fold-toogle">
                                <label for="side-nav-fold-toogle"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick View END -->
    </div>
</div>


<!-- Core Vendors JS -->
<script src="{{ asset('assets/js/vendors.min.js') }}"></script>


<!-- Core JS -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/2.1.0/select2.js" integrity="sha512-m0AH4GQVgqi3hR6REkdh/p4FJK7xRlRKwS2FI/YES4NkseOD8Q1fyhY9TUKDozfQFhI4ewglFVwTsdGBoaR69Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>



{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}

<!-- Add DataTables -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<!-- Add DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>


@if( Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
    {{ Session:: forget('success') }}
@endif

@stack('scripts')
@yield('scripts')
@yield('js')
</body>

</html>
