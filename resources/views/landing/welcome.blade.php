@extends('landing.layouts.app')

@section('content')
    <!-- Hero Start -->
    <section class="bg-half-170 d-table w-100"
             style="background: url('{{ asset('images/invoicess.PNG') }}') center center;padding-top: 100px">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="title-heading mt-4">
                        <h1 class="display-4 fw-bold text-white title-dark mb-3"><strong>Invoicing &
                                Billing</strong><br>
                            made easy</h1>
                        <p class="para-desc text-white-50">Free online invoicing and billing software for small and
                            large
                            business. Accounting, Invoice, Billing, Sales, Purchase, Inventory Management, Send & Print
                            Invoice Online is so simple in invoicepedia. InvoicePedia makes creating professional
                            looking
                            invoices for your business ridiculously easy</p>

                    </div>
                </div><!--end col-->

                <div class="col-lg-5 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                    <div class="card shadow rounded border-0 ms-lg-5">
                        <div class="card-body">
                            <h5 class="card-title">Join Now</h5>
                            {{--                            @if($errors->any())--}}
                            {{--                                {{ implode('', $errors->all('<div>:message</div>')) }}--}}
                            {{--                            @endif--}}
                            <div>
                                <form class="login-form mt-4" action="{{ route('register') }}" method="post">
                                    @csrf
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-user fea icon-sm icons">
                                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                        <circle cx="12" cy="7" r="4"></circle>
                                                    </svg>
                                                    <input type="text" class="form-control ps-5" placeholder="Name"
                                                           value="{{ old('email') }}"
                                                           name="name" autocomplete="off"
                                                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                                    @error('name')
                                                    <small class="text-danger"> {{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-mail fea icon-sm icons">
                                                        <path
                                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                        <polyline points="22,6 12,13 2,6"></polyline>
                                                    </svg>
                                                    <input type="email" class="form-control ps-5" placeholder="Email"
                                                           value="{{ old('email') }}"
                                                           name="email" autocomplete="off"
                                                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                                    @error('email')
                                                    <small class="text-danger"> {{ $message }}</small>
                                                    @enderror
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
                                                    <input id="password" type="password" class="form-control ps-5"
                                                           placeholder="Password"
                                                           autocomplete="off"
                                                           name="password"
                                                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                                    @error('password')
                                                    <small class="text-danger"> {{ $message }}</small>
                                                    @enderror
                                                    <input type="password" id="password_confirmation"
                                                           name="password_confirmation" hidden>
                                                </div>
                                            </div>
                                        </div><!--end col-->


                                        <div class="col-lg-12 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary">Try For Free</button>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12 mt-4 text-center">
                                            <h6>Or Join With</h6>
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
                        <h4 class="title mb-4 text-center">Benefit for users using <strong class="font-weight-bolder"
                                                                                           style="font-weight: 900;font-family: system-ui"><span
                                    style="color: #0d71bb">Invoice</span><span style="color: red">Pedia</span></strong>
                        </h4>
                        <span class="text-muted para-desc mb-0 mx-auto">Start working with <span
                                class="text-primary fw-bold"><span style="color: #0d71bb">Invoice</span><span
                                    style="color: red">Pedia</span></span>
                        that can provide easy solution to <h2 class="d-inline"
                                                              style="font-size: 16px !important;display: inline"> <strong>create invoices online</strong></h2> and send it to your
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
                            <p class="para text-muted mb-0">Receive payment by sharing invoice online instantly and
                                billing
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
                            <p class="para text-muted mb-0">It is the cheapest invoicing software ever on the
                                internet.</p>
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
                            <p class="para text-muted mb-0"> Create estimate and send to your client and turn the
                                estimate
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
                            <p class="para text-muted mb-0">Create a billing or purchase invoice and send online with
                                few
                                steps.</p>
                        </div>
                        <span class="big-icon text-center">
                                <i class="uil uil-process"></i>
                            </span>
                    </div>
                </div><!--end col-->

            </div><!--end row-->
        </div><!--end container-->


    </section><!--end section--> <h2 class="text-center">Blog Resources</h2>
    <section class="section bg-dark">

        <div class="container">

            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card blog border-0 rounded shadow overflow-hidden">
                            {{--                            <img src="#" class="img-fluid" alt="">--}}

                            <div class="card-body content">
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    @foreach($post->blog_tags as $tag)
                                        <span class="badge bg-soft-primary">{{ $tag->name }}</span>

                                    @endforeach
                                    <small class="text-muted">{{ $post->updated_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ route('blogs.blog.show',$post->slug) }}"
                                   class="title text-dark h5">{{ $post->title }}</a>

                                <div class="mt-3">
                                    <a href="{{ route('blogs.blog.show',$post->slug) }}" class="link">Read More <i
                                            class="uil uil-arrow-right align-middle"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                @endforeach

            </div><!--end row-->

        </div><!--end container-->
    </section>

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
                                <p class="mt-4">InvoicePedia makes small and large business invoicing and billing so
                                    simple.
                                    Its the best invoicing software online for free. Invoicepedia is inspired by Scoro,
                                    QuickBooks, Freshbooks, Zoho Books, Xero, Sage 50c, Wave, Invoice2go, OneUp, SliQ
                                    Invoicing, BillQuick Online, FinancialForce Billing, Chargebee, WORKetc, Harvest,
                                    PaySimple, Zervant, KashFlow, Bill.com. Invoicepedia extends all features from
                                    existing
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
                            <li class="list-inline-item"><a href="javascript:void(0)"><img
                                        src="images/payments/paypal.png"
                                        class="avatar avatar-ex-sm"
                                        title="Paypal" alt=""></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><img
                                        src="images/payments/visa.png"
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
                                            <label class="form-label">Your Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input name="name" id="name" type="text" class="form-control ps-5"
                                                       placeholder="Name :">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Your Email <span
                                                    class="text-danger">*</span></label>
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
                                            <label class="form-label">Comments <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="message-circle" class="fea icon-sm icons clearfix"></i>
                                                <textarea name="comments" id="comments" rows="4"
                                                          class="form-control ps-5"
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
                <li class="list-inline-item mb-0"><a href="https://1.envato.market/4n73n" target="_blank"
                                                     class="rounded"><i
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
                <li class="list-inline-item mb-0"><a href="https://twitter.com/shreethemes" target="_blank"
                                                     class="rounded"><i
                            class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                <li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i
                            class="uil uil-envelope align-middle" title="email"></i></a></li>
                <li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i
                            class="uil uil-globe align-middle" title="website"></i></a></li>
            </ul><!--end icon-->
        </div>
    </div>
    <!-- Offcanvas End -->

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#password').on('input', function () {
                $('#password_confirmation').val($(this).val())
            })
        })
    </script>
@endsection
