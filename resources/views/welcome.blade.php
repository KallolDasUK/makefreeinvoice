@extends('layouts.frontend')


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
                                                    <input type="password" class="form-control ps-5"
                                                           placeholder="Password"
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
                        <h4 class="title mb-4 text-center">Benefit for users using <strong class="font-weight-bolder"
                                                                                           style="font-weight: 900;font-family: system-ui"><span
                                    style="color: #0d71bb">Invoice</span><span style="color: red">Pedia</span></strong>
                        </h4>
                        <span class="text-muted para-desc mb-0 mx-auto">Start working with <span
                                class="text-primary fw-bold"><span style="color: #0d71bb">Invoice</span><span
                                    style="color: red">Pedia</span></span>
                        that can provide easy solution to <h1 class="d-inline"
                                                              style="font-size: 16px !important;display: inline"> <strong>create invoices online</strong></h1> and send it to your
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


    </section><!--end section-->


@endsection
