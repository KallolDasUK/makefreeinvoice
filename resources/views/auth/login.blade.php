<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
            var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&amp;l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5FS8GGP');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8"/>
    <title>Login Page 3 | Keenthemes</title>
    <meta name="description" content="Login page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="canonical" href="https://keenthemes.com/metronic"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link
        href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/css/pages/login/classic/login-3.css?v=7.2.8"
        rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link
        href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.css?v=7.2.8"
        rel="stylesheet" type="text/css"/>
    <link
        href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.2.8"
        rel="stylesheet" type="text/css"/>
    <link href="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/css/style.bundle.css?v=7.2.8"
          rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <!-- Hotjar Tracking Code for keenthemes.com -->
    <script>(function (h, o, t, j, a, r) {
            h.hj = h.hj || function () {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {hjid: 1070954, hjsv: 6};
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/media/bg/bg-1.jpg)"
      class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid"
             style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/media/bg/bg-1.jpg);">
            <div class="login-form text-center text-white p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img
                            src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/media/logos/logo-letter-9.png"
                            class="max-h-100px" alt=""/>
                    </a>
                </div>
                <!--end::Login Header-->
                <!--begin::Login Sign in form-->
                <div class="login-signin">
                    <div class="mb-20">
                        <h3>Sign In To Admin</h3>
                        <p class="opacity-60 font-weight-bold">Enter your details to login to your account:</p>
                    </div>
                    <form class="form" id="kt_login_signin_form" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input
                                class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70  @error('email') is-invalid @enderror rounded-pill border-0 py-4 px-8 mb-5"
                                type="email" placeholder="Email"  name="email" value="{{ old('email') }}" autocomplete="off"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5"
                                type="password" placeholder="Password" name="password"/>
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                                    <input type="checkbox" name="remember"/>
                                    <span></span>Remember me</label>
                            </div>
                            <a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">Forget
                                Password ?</a>
                        </div>
                        <div class="form-group text-center mt-10">
                            <button id="kt_login_signin_submit"
                                    class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3">Sign
                                In
                            </button>
                        </div>
                    </form>
                    <div class="mt-10">
                        <span class="opacity-70 mr-4">Don't have an account yet?</span>
                        <a href="{{ route('register') }}" id="kt_login_signup" class="text-white font-weight-bold">Sign
                            Up</a>
                    </div>
                </div>
                <!--end::Login Sign in form-->
                <!--begin::Login Sign up form-->
                <div class="login-signup">
                    <div class="mb-20">
                        <h3>Sign Up</h3>
                        <p class="opacity-60">Enter your details to create your account</p>
                    </div>
                    <form class="form text-center" id="kt_login_signup_form">
                        <div class="form-group">
                            <input
                                class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8"
                                type="text" placeholder="Fullname" name="fullname"/>
                        </div>
                        <div class="form-group">
                            <input
                                class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8"
                                type="text" placeholder="Email" name="email" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <input
                                class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8"
                                type="password" placeholder="Password" name="password"/>
                        </div>
                        <div class="form-group">
                            <input
                                class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8"
                                type="password" placeholder="Confirm Password" name="cpassword"/>
                        </div>
                        <div class="form-group text-left px-8">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                                    <input type="checkbox" name="agree"/>
                                    <span></span>I Agree the
                                    <a href="#" class="text-white font-weight-bold ml-1">terms and
                                        conditions</a>.</label>
                            </div>
                            <div class="form-text text-muted text-center"></div>
                        </div>
                        <div class="form-group">
                            <button id="kt_login_signup_submit"
                                    class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3 m-2">
                                Sign Up
                            </button>
                            <button id="kt_login_signup_cancel"
                                    class="btn btn-pill btn-outline-white font-weight-bold opacity-70 px-15 py-3 m-2">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
                <!--end::Login Sign up form-->
                <!--begin::Login forgot password form-->
                <div class="login-forgot">
                    <div class="mb-20">
                        <h3>Forgotten Password ?</h3>
                        <p class="opacity-60">Enter your email to reset your password</p>
                    </div>
                    <form class="form" id="kt_login_forgot_form">
                        <div class="form-group mb-10">
                            <input
                                class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8"
                                type="text" placeholder="Email" name="email" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <button id="kt_login_forgot_submit"
                                    class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3 m-2">
                                Request
                            </button>
                            <button id="kt_login_forgot_cancel"
                                    class="btn btn-pill btn-outline-white font-weight-bold opacity-70 px-15 py-3 m-2">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
                <!--end::Login forgot password form-->
            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<script>var HOST_URL = "/metronic/theme/html/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {"breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
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
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script
    src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/global/plugins.bundle.js?v=7.2.8"></script>
<script
    src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.2.8"></script>
<script
    src="https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/js/scripts.bundle.js?v=7.2.8"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
{{--<script src="https://preview.keenthemes.com/metronic/theme/html/demo-panel-right2/dist/distassets/js/pages/custom/login/login-general.js?v=7.2.8"></script>--}}
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
