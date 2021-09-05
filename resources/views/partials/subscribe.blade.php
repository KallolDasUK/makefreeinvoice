@include('partials.ajax-subscription-payment-form')

@if(!auth()->user()->subscribed('default'))
    <div class="">


        <!--begin::Card-->
        <div class="card">
            <!-- begin: Custom background-->
            <div class="d-block d-lg-none rounded-card-top position-absolute w-100 h-25"></div>
            <!-- end: Custom background-->
            <!--begin::Card- body-->
            <div class="card-body position-relative p-0 rounded-card-top">
                <!--begin::Pricing title-->
                <h3 class="p-4 float-left">Transparent &amp; Simple Pricing</h3>
                <div class="p-4 float-right">
                    <div class="stv-radio-buttons-wrapper">
                        <input hidden type="radio" class="" name="duration" value="monthly" id="monthly"
                               checked/>
                        <label for="monthly" class="btn btn-default btn-primary btn-lg "
                               id="monthlyLabel">Monthly</label>
                        <input hidden type="radio" class="" name="duration" value="yearly" id="yearly"/>
                        <label for="yearly" class="btn btn-default" id="yearlyLabel">Yearly</label>

                    </div>

                </div>
                <p class="clearfix"></p>
                <div class="row justify-content-center m-0 position-relative">
                    <!-- begin: Custom background-->


                    <!-- end: Custom background-->
                    <div class="col">
                        <div class="row align-items-center justify-align-items">
                            <!-- begin: Pricing-->
                            <div class="col-12 col-lg-4 bg-white p-0">
                                <div class="py-15 px-0 px-lg-5 text-center">
                                    <div class="d-flex flex-center mb-7">
																<span class="svg-icon svg-icon-5x svg-icon-primary">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/Home/Flower3.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<polygon
                                                                                points="0 0 24 0 24 24 0 24"></polygon>
																			<path
                                                                                d="M1.4152146,4.84010415 C11.1782334,10.3362599 14.7076452,16.4493804 12.0034499,23.1794656 C5.02500006,22.0396582 1.4955883,15.9265377 1.4152146,4.84010415 Z"
                                                                                fill="#000000" opacity="0.3"></path>
																			<path
                                                                                d="M22.5950046,4.84010415 C12.8319858,10.3362599 9.30257403,16.4493804 12.0067693,23.1794656 C18.9852192,22.0396582 22.5146309,15.9265377 22.5950046,4.84010415 Z"
                                                                                fill="#000000" opacity="0.3"></path>
																			<path
                                                                                d="M12.0002081,2 C6.29326368,11.6413199 6.29326368,18.7001435 12.0002081,23.1764706 C17.4738192,18.7001435 17.4738192,11.6413199 12.0002081,2 Z"
                                                                                fill="#000000" opacity="0.3"></path>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
                                    </div>
                                    <h4 class="font-size-h3 mb-10 text-dark">Free Plan</h4>
                                    <div class="d-flex flex-column pb-7 text-dark-50">
                                        <span>For small business </span>
                                        <span>with basic needs</span>
                                    </div>
                                    <span class="font-size-h1 font-weight-boldest text-dark">0
															<sup
                                                                class="font-size-h3 font-weight-normal pl-1">$</sup></span>
                                    <!--begin::Mobile Pricing Table-->
                                    <div class="d-lg-none">
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Number Of Invoices</span>
                                            <span>Unlimited</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Bills</span>
                                            <span>No</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Expense</span>
                                            <span>No</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Stock Management</span>
                                            <span>No</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Accounting</span>
                                            <span>No</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Unlimited Customer</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Unlimited Vendors</span>
                                            <span>Yes</span>
                                        </div>
                                    </div>
                                    <!--end::Mobile Pricing Table-->
                                    <div class="mt-7">
                                        <button type="button"
                                                class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3"
                                                disabled readonly>SUBSCRIBED
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="basic_monthly"
                                 class="col-12 col-lg-4 bg-white border-x-0 border-x-lg border-y border-y-lg-0 p-0">
                                <div class="py-15 px-0 px-lg-5 text-center">
                                    <div class="d-flex flex-center mb-7">
																<span class="svg-icon svg-icon-5x svg-icon-primary">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/Tools/Compass.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<rect x="0" y="0" width="24"
                                                                                  height="24"></rect>
																			<path
                                                                                d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z"
                                                                                fill="#000000" opacity="0.3"></path>
																			<path
                                                                                d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z"
                                                                                fill="#000000"
                                                                                fill-rule="nonzero"></path>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
                                    </div>
                                    <h4 class="font-size-h3 mb-10 text-dark">Basic</h4>
                                    <div class="d-flex flex-column pb-7 text-dark-50">
                                        <span>For Medium Business</span>
                                        <span>Best fits for small business and freelancers</span>
                                    </div>
                                    <span class="font-size-h1 font-weight-boldest text-dark">4.99
															<sup
                                                                class="font-size-h3 font-weight-normal pl-1">$</sup>/Month</span>
                                    <!--begin::Mobile Pricing Table-->
                                    <div class="d-lg-none">
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Number Of Invoices</span>
                                            <span>Unlimited</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Bills</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Expense</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Stock Management</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Accounting</span>
                                            <span>No</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Unlimited Customer</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Unlimited Vendors</span>
                                            <span>Yes</span>
                                        </div>
                                    </div>
                                    <!--end::Mobile Pricing Table-->
                                    <div class="mt-7">
                                        <button data="price_1JWHMFI8TcFb3W7tbHGjC9CA" type="button" id="basicM_btn"
                                                class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">
                                            Subscribe
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="premium_monthly" class="col-12 col-lg-4  bg-white mb-10 mb-lg-0 p-0">
                                <div class="py-15 px-0 px-lg-5 text-center">
                                    <div class="d-flex flex-center mb-7">
																<span class="svg-icon svg-icon-5x svg-icon-primary">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/Shopping/Cart2.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<rect x="0" y="0" width="24"
                                                                                  height="24"></rect>
																			<path
                                                                                d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3"></path>
																			<path
                                                                                d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z"
                                                                                fill="#000000"></path>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
                                    </div>
                                    <h4 class="font-size-h3 mb-10 text-dark">Premium</h4>
                                    <div class="d-flex flex-column pb-7 text-dark-50">
                                        <span>For Large Scale Business</span>
                                        <span>Lots of extensive features</span>
                                    </div>
                                    <span class="font-size-h1 font-weight-boldest text-dark">9.99
															<sup
                                                                class="font-size-h3 font-weight-normal pl-1">$</sup>/Month</span>
                                    <!--begin::Mobile Pricing Table-->
                                    <div class="d-lg-none">
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Number Of Users</span>
                                            <span>Unlimited</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Domains</span>
                                            <span>100</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Projects</span>
                                            <span>500</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Storage</span>
                                            <span>Unlimited</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Supporet</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Tutorials</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Cancelation</span>
                                            <span>Yes</span>
                                        </div>
                                    </div>
                                    <!--end::Mobile Pricing Table-->
                                    <div class="mt-7">
                                        <button data="price_1JWHOeI8TcFb3W7tp4LBX2ZW" type="button" id="premiumM_btn"
                                                class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">
                                            Subscribe
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="basic_yearly" style="display: none"
                                 class="col-12 col-lg-4 bg-white border-x-0 border-x-lg border-y border-y-lg-0 p-0">
                                <div class="py-15 px-0 px-lg-5 text-center">
                                    <div class="d-flex flex-center mb-7">
																<span class="svg-icon svg-icon-5x svg-icon-primary">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/Tools/Compass.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<rect x="0" y="0" width="24"
                                                                                  height="24"></rect>
																			<path
                                                                                d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z"
                                                                                fill="#000000" opacity="0.3"></path>
																			<path
                                                                                d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z"
                                                                                fill="#000000"
                                                                                fill-rule="nonzero"></path>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
                                    </div>
                                    <h4 class="font-size-h3 mb-10 text-dark">Basic</h4>
                                    <div class="d-flex flex-column pb-7 text-dark-50">
                                        <span>For Medium Business</span>
                                        <span>Best fits for small business and freelancers</span>
                                    </div>
                                    <span class="font-size-h1 font-weight-boldest text-dark">49.99
															<sup
                                                                class="font-size-h3 font-weight-normal pl-1">$</sup>/Year</span>
                                    <!--begin::Mobile Pricing Table-->
                                    <div class="d-lg-none">
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Number Of Invoices</span>
                                            <span>Unlimited</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Bills</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Expense</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Stock Management</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Accounting</span>
                                            <span>No</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Unlimited Customer</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Unlimited Vendors</span>
                                            <span>Yes</span>
                                        </div>
                                    </div>
                                    <!--end::Mobile Pricing Table-->
                                    <div class="mt-7">
                                        <button data="price_1JWHMFI8TcFb3W7tnqWx9Wlq" type="button" id="basicY_btn"
                                                class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">
                                            Subscribe
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="premium_yearly" style="display: none"
                                 class="col-12 col-lg-4  bg-white mb-10 mb-lg-0 p-0">
                                <div class="py-15 px-0 px-lg-5 text-center">
                                    <div class="d-flex flex-center mb-7">
																<span class="svg-icon svg-icon-5x svg-icon-primary">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/Shopping/Cart2.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<rect x="0" y="0" width="24"
                                                                                  height="24"></rect>
																			<path
                                                                                d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3"></path>
																			<path
                                                                                d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z"
                                                                                fill="#000000"></path>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
                                    </div>
                                    <h4 class="font-size-h3 mb-10 text-dark">Premium</h4>
                                    <div class="d-flex flex-column pb-7 text-dark-50">
                                        <span>For Large Business </span>
                                        <span>Lots of extensive features</span>
                                    </div>
                                    <span class="font-size-h1 font-weight-boldest text-dark">99.99
															<sup
                                                                class="font-size-h3 font-weight-normal pl-1">$</sup>/Year</span>
                                    <!--begin::Mobile Pricing Table-->
                                    <div class="d-lg-none">
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Number Of Invoices</span>
                                            <span>Unlimited</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Bills</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Expense</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Stock Management</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Accounting</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="py-3">
                                            <span class="font-weight-boldest">Unlimited Customer</span>
                                            <span>Yes</span>
                                        </div>
                                        <div class="bg-gray-100 py-3">
                                            <span class="font-weight-boldest">Unlimited Vendors</span>
                                            <span>Yes</span>
                                        </div>
                                    </div>
                                    <!--end::Mobile Pricing Table-->
                                    <div class="mt-7">
                                        <button data="price_1JWHOeI8TcFb3W7teWIOf8Si" type="button" id="premiumY_btn"
                                                class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">
                                            Subscribe
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- end: Pricing-->
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mx-0 mb-15 d-none d-lg-flex">
                    <div class="col-11">
                        <div class="row bg-gray-100 py-5 font-weight-bold text-center">
                            <div class="col-3 text-left px-5 font-weight-boldest">Plan</div>
                            <div class="col-3 font-weight-boldest">Free</div>
                            <div class="col-3 font-weight-boldest">Basic</div>
                            <div class="col-3 font-weight-boldest">Premium</div>
                        </div>
                        <!-- begin: Bottom Table-->
                        <div class="row bg-gray-100 py-5 font-weight-bold text-center">
                            <div class="col-3 text-left px-5 font-weight-boldest">Invoice</div>
                            <div class="col-3">Yes</div>
                            <div class="col-3">Yes</div>
                            <div class="col-3">Yes</div>

                        </div>
                        <div class="row bg-gray-100 py-5 font-weight-bold text-center">
                            <div class="col-3 text-left px-5 font-weight-boldest">Estimates</div>
                            <div class="col-3">Yes</div>
                            <div class="col-3">Yes</div>
                            <div class="col-3">Yes</div>

                        </div>
                        <div class="row bg-white py-5 font-weight-bold text-center">
                            <div class="col-3 text-left px-5 font-weight-boldest">Bill</div>
                            <div class="col-3">No</div>
                            <div class="col-3">Yes</div>
                            <div class="col-3">Yes</div>
                        </div>
                        <div class="row bg-gray-100 py-5 font-weight-bold text-center">
                            <div class="col-3 text-left px-5 font-weight-boldest">Expense</div>
                            <div class="col-3">No</div>
                            <div class="col-3">Yes</div>
                            <div class="col-3">Yes</div>
                        </div>
                        <div class="row bg-white py-5 font-weight-bold text-center">
                            <div class="col-3 text-left px-5 font-weight-boldest">Stock Management</div>
                            <div class="col-3">No</div>
                            <div class="col-3">Yes</div>
                            <div class="col-3">Yes</div>
                        </div>
                        <div class="row bg-gray-100 py-5 font-weight-bold text-center">
                            <div class="col-3 text-left px-5 font-weight-boldest">Accounting</div>
                            <div class="col-3">No</div>
                            <div class="col-3">No</div>
                            <div class="col-3">Yes</div>
                        </div>

                        <!-- end: Bottom Table-->
                    </div>
                </div>
                <!--end::Pricings-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@else
    <div class="">
        <div class="row mt-4">
            <div class="col-4 align-self-start">
                <div class="my-4"></div>
                <div class="card">
                    <div class="card-body">
                        <h2>{{ $currentPlan->product->name }} </h2>
                        <h3>{{ $currentPlan->plan->amount /100 }} {{ $currentPlan->plan->currency }}
                            / {{ strtoupper($currentPlan->plan->interval) }}</h3>

                        <p class="badge badge-secondary">{{ \Illuminate\Support\Str::title($currentPlan->collection_method) }}</p>
                        <p>Current Period Started
                            At {{ \Carbon\Carbon::createFromTimestamp($currentPlan->current_period_start)->format('d M Y') }}</p>
                        <p>Current Period Ends
                            At {{  \Carbon\Carbon::createFromTimestamp($currentPlan->current_period_end)->format('d M Y')  }}</p>


                        <form action="{{ route('subscriptions.cancel') }}" method="post">
                            @csrf
                            <button class="btn btn-danger btn-sm">Cancel Subscription</button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col">


                <label for="">Next Bill At </label>
                <br>
                <table class="table table-bordered bg-white">

                    <tr>
                        <td>{{ $upcoming_invoice->date()->toFormattedDateString() }}</td>
                        <td>{{ $upcoming_invoice->total() }}</td>
                        {{--                        <td><a href="{{ route('subscriptions.download-invoice',[$upcoming_invoice->id]) }}">Download</a></td>--}}
                    </tr>

                </table>
                <label for="">Paid Bill</label>
                <table class="table table-bordered bg-white">
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                            <td>{{ $invoice->total() }}</td>
                            <td><a href="{{ route('subscriptions.download-invoice',[$invoice->id]) }}">Download</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>


    </div>
@endif
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(document).ready(function () {
        $('input[type=radio][name=duration]').change(function () {
            if (this.value === 'monthly') {
                $('#monthlyLabel').addClass('btn btn-primary')
                $('#monthlyLabel').addClass('btn-lg')
                $('#yearlyLabel').removeClass('btn-primary')
                $('#yearlyLabel').removeClass('btn-lg')

                /* Other Staff */


            } else if (this.value === 'yearly') {
                $('#monthlyLabel').removeClass('btn-primary')
                $('#monthlyLabel').removeClass('btn-lg')
                $('#yearlyLabel').addClass('btn btn-primary')
                $('#yearlyLabel').addClass('btn-lg')
            }
            console.log(this.value)

            $('#basic_monthly').toggle()
            $('#premium_monthly').toggle()
            $('#basic_yearly').toggle()
            $('#premium_yearly').toggle()

        });
    })
</script>
