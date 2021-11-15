@php($title="Instant Invoice Generator - InvoicePedia")
@extends('landing.layouts.app')


@section('css')
    <link rel="stylesheet" href="https://invoicepedia.com/wp-content/themes/bloggist/style.css?ver=5.8.1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="https://www.zoho.com/invoice/styles/invoicegenerator.css">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>


    <style>
        b, body, div, h1, h2, h3, h4, h5, h6, img, li, p, span, ul {
            margin: 0;
            padding: 0
        }

        .b-div {
            background-color: #f2f3f5
        }

        b, body, input, p, textarea {
            font-family: Zoho Puvi Regular, -apple-system, BlinkMacSystemFont, San Francisco, Helvetica Neue, Helvetica, Ubuntu, Roboto, Noto, Segoe UI, Arial, sans-serif
        }

        li, ul {
            list-style: none
        }

        input, textarea {
            border: none
        }

        .main-div {
            margin: 0 auto;
            overflow: hidden;
            width: 1200px
        }

        .top-band-div {
            clear: both;
            margin: 0 auto;
            position: relative;
            width: 1100px
        }

        .top-band-div > div {
            padding: 20px 15px 20px 0
        }

        .comp-addr-outer div {
            display: inline-block
        }

        .comp-addr-inner {
            width: 54%
        }

        .comp-addr-invoice {
            width: 45%;
            float: right
        }

        .bill-addr {
            /*margin-top: 50px;*/
            width: 100%
        }

        .row {
            margin: auto
        }

        .inv-generator {
            min-height: 1100px;
            padding: 40px 33px 0 35px;
            background: #fff;
            -webkit-box-shadow: 0 0 17px 0 rgba(16, 40, 73, .09);
            box-shadow: 0 0 17px 0 rgba(16, 40, 73, .09)
        }

        .btn-main {
            background-color: #fff;
            font-size: 17px;
            border: 1px solid #ddd
        }

        .btn-main.btn-save {
            background-color: #f46e3e;
            color: #fff
        }

        .btn-plain {
            width: 90%;
            background-color: rgba(0, 0, 0, 0);
            border: 1px solid #d6f669 !important;
            color: #d6f669 !important;
            display: block
        }

        .link-print {
            color: #83c0f5;
            cursor: pointer
        }

        .column td {
            /*padding: 4px 8px;*/
            vertical-align: top
        }

        tr {
            border-bottom: 0px solid #000;
        }

        .hd td {
            background-color: #0e566c;
            border-bottom: 1px solid #ddd
        }

        .hd td input, .taxsummary .hd td {
            background-color: #0e566c;
            text-align: right;
            color: #fff
        }

        .hd td input:not([READONLY]):focus {
            background: #fdf4db;
            border: 1px dotted #444;
            color: #444
        }

        .bill td {
            padding: 2px
        }

        .amount {
            text-align: right;
            width: 100px
        }

        .sav-amo td {
            padding: 10px;
            border-top: 2px solid #ddd
        }

        .tot, .tot input {
            /*background: #e3e3e3;*/
            /*border: 1px solid #e3e3e3*/
        }

        .tot ts {
            border-top: 1px solid #c7c7c7;
            border-bottom: 1px solid #c7c7c7
        }

        .tot input:focus {
            border: 1px dotted #444
        }

        input, textarea {
            border: 1px dotted #fff;
            margin-bottom: 2px
        }

        .tot td {
            /*padding: 10px;*/
            /*border-top: 1px solid #c7c7c7;*/
            text-align: right
        }

        td.bdr-non {
            border: none
        }

        .note {
            width: 100%;
            min-height: 22px;
            margin-top: 2px
        }

        .terms {
            margin-top: 20px;
            text-align: left
        }

        .bld, .terms {
            font-weight: 700;
            font-size: 14px
        }

        .bld {
            margin: 2px 0
        }

        .adr {
            font-size: 14px;
            width: 98%
        }

        .adr.error {
            border: 1px solid #a94442
        }

        .adr-lft {
            width: 55%;
            text-align: left
        }

        .adr-rgt {
            text-align: right;
            width: 42%
        }

        .c-name {
            font-size: 45px;
            font-weight: 300;
            width: 100%;
            color: #666;
            text-align: right;
            color: #38342c;
            margin: 0 27px 0 auto
        }

        .bdr-non {
            border: none
        }

        input:focus, textarea:focus {
            background: #fdf4db;
            border: 1px dotted #444
        }

        input[READONLY]:focus {
            background: none;
            border: 1px dotted #fff
        }

        .form-control {
            height: 25px;
            padding-left: 0;
            border: inherit;
            -webkit-box-shadow: inherit;
            box-shadow: inherit;
            -webkit-transition: inherit;
            -o-transition: inherit
        }

        .highlight-transition-duration {
            -webkit-transition-duration: .6s;
            -o-transition-duration: .6s;
            transition-duration: .6s;
            -webkit-transition-timing-function: ease-in-out;
            -o-transition-timing-function: ease-in-out;
            transition-timing-function: ease-in-out
        }

        .highlight {
            background-color: #fffbd7
        }

        .c-name.form-control {
            height: inherit
        }

        .form-control:focus {
            -webkit-box-shadow: inherit;
            box-shadow: inherit
        }

        .bill-to {
            color: #000;
            margin-bottom: 10px
        }

        .row-item td {
            border-bottom: 1px solid #e3e3e3;
            padding-bottom: 10px
        }

        .f20 {
            font-size: 20px
        }

        .vtop {
            vertical-align: top
        }

        .lineItemDIV {
            clear: both;
            margin-top: 30px;
            float: left
        }

        .add, .del, [class^=mobile-] {
            background-image: url(/invoice/inv-gen/icon-blk-1x.png);
            background-repeat: no-repeat;
            background-size: 809px 393px
        }

        .add {
            background-position: -404px -256px;
            color: #00f;
            padding-left: 23px;
            font-size: 12px;
            padding-top: 4px
        }

        .add, .del {
            height: 16px;
            margin-top: 2px;
            width: 16px
        }

        .del {
            background-position: -404px -216px
        }

        .logo-tp {
            background-image: url(/invoice/images/home/zoho-logo.png);
            height: 29px;
            width: 82px;
            margin-right: 5px;
            background-size: contain;
            background-repeat: no-repeat
        }

        [class^=mobile-] {
            display: inline-block;
            width: 155px;
            height: 46px;
            margin: 5px 44px
        }

        .mobile-iphone {
            background-position: -445px -113px
        }

        .mobile-android {
            background-position: -445px -173px
        }

        .mobile-windows {
            background-position: -445px -234px
        }

        .footer {
            padding: 50px 0 20px
        }

        .copy {
            color: #fff;
            font-size: 11px
        }

        .currencycodetxt {
            width: 45px;
            text-align: right;
            font-size: 12px;
            padding-right: 4px
        }

        .top-band-div h1 {
            vertical-align: bottom
        }

        .stat-nor {
            background-color: #273344;
            background: -webkit-gradient(linear, left top, right top, from(#2970cf), to(#53a0fd));
            background: -o-linear-gradient(left, #2970cf, #53a0fd);
            background: linear-gradient(90deg, #2970cf, #53a0fd)
        }

        .total-label {
            width: 150px
        }

        .top-tab td {
            vertical-align: top;
            padding-top: 20px
        }

        .body-div {
            margin-top: 25px
        }

        .free-invoice-line {
            margin-top: 15px;
            color: #f0483e;
            font-size: 15px
        }

        .powered-by-link {
            text-decoration: none
        }

        .powered-by-text {
            margin-top: 4px;
            font-size: 13px;
            color: #11b4d7
        }

        .powered-by-logo {
            height: 23px;
            margin-left: 9px;
            width: 127px
        }

        .rhs-info {
            margin-bottom: 15px;
            font-weight: 100;
            font-size: 14px;
            padding-left: 30px;
            opacity: .7
        }

        .rhs-strikethrough-info {
            text-decoration: line-through;
            color: #0fbd4f
        }

        .btn:focus, .btn:hover {
            outline: 0
        }

        .actions-block {
            background-color: #fff;
            padding: 20px;
            margin: 20px 0 10px;
            display: inline-block;
            width: 77%
        }

        .actions-block .select-action-txt {
            margin-bottom: 20px;
            color: #c7c4d4;
            font-weight: 100;
            font-size: 13px
        }

        .mbl-app-block {
            border: 2px solid #3b506a;
            width: 70%;
            padding: 20px 15px
        }

        .mbl-app-block h4 {
            display: inline;
            font-weight: lighter;
            color: #bad952
        }

        .mbl-app-block h4 span {
            color: #c7c4d4
        }

        .actions-block-btn {
            padding: 20px 10px 20px 15px
        }

        .mbl-actions-block {
            display: none
        }

        .actions-block-btn .btn, .mbl-actions-block .btn {
            margin-right: 10px
        }

        .highlight-content {
            color: #0fbd4f
        }

        .contact-us {
            margin: 20px 10px;
            color: #e1e2e5
        }

        .contact-us a {
            text-decoration: underline;
            color: #e1e2e5
        }

        .cursor-disabled {
            cursor: not-allowed
        }

        .select-currency {
            width: 70px;
            height: 23px;
            -webkit-appearance: menulist-button
        }

        .title {
            color: #fff;
            font-weight: 300;
            display: inline;
            font-size: 24px
        }

        .w100 {
            width: 100%
        }

        .signup-bg {
            position: absolute;
            height: 100%;
            right: 0;
            padding: 40px 55px;
            border-left: 1px solid #a9cdf0;
            background: #e3eaf0;
            border-radius: 0 6px 6px 0
        }

        .signup-benefits {
            padding-left: 10px;
            font-size: 13px
        }

        .signup-benefits div {
            margin-bottom: 10px
        }

        @media screen and (max-width: 1200px) {
            .main-div {
                width: 100%
            }

            .top-band-div > div {
                padding: 20px 15px
            }

            .actions-block-btn {
                width: 99%
            }

            .rgt-main-div {
                display: none
            }

            .lft-main-div, .top-band-div {
                width: 100%
            }

            .mbl-actions-block {
                display: inline-block;
                width: 100%;
                padding: 20px 15px;
                margin: 0 auto
            }

            .signup-bg {
                height: auto
            }
        }

        .ZI-form input:focus {
            border: 1px solid #ccc
        }

        .field-msg .error {
            color: #a94442;
            font-size: 12px
        }

        .ZI-load {
            background: url(../images/bg.png) repeat;
            width: 100%;
            height: 100%;
            position: absolute;
            z-index: 23
        }

        .ZI-loading {
            background: url(../images/loading.gif) no-repeat;
            background-position: 16px 17px;
            height: 37px;
            width: 230px;
            clear: both;
            margin: 10px auto
        }

        .ZI-popup {
            top: 33%;
            margin-left: 33%;
            width: 450px;
            background: #fff;
            z-index: 222;
            position: fixed;
            padding: 30px
        }

        .ZI-popup h3 {
            color: #555454;
            font-size: 24px;
            font-weight: lighter
        }

        .ZI-con-desc {
            color: #666;
            clear: both;
            margin: 10px 0 30px;
            line-height: 24px;
            float: left
        }

        .logo-icon {
            width: 250px;
            height: 70px
        }

        .title-icon {
            width: 100px;
            height: 50px
        }

        .action-icon {
            width: 20px;
            height: 20px;
            vertical-align: top
        }

        .social-icon {
            width: 28px;
            height: 28px;
            padding: 10px 10px 0 0
        }

        .footer-cta-section {
            background-color: #29374b;
            background-image: url(/invoice/inv-gen/footer-bg-1x.png);
            background-repeat: no-repeat;
            background-size: 100%
        }

        .promotion-section {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            padding-top: 80px
        }

        .promotion-section .btn-main {
            margin: 20px 0;
            min-width: 150px;
            background-color: #309de3;
            color: #fff;
            padding: 10px 20px;
            border-color: rgba(0, 0, 0, 0)
        }

        .promotion-section .btn-main:hover {
            background-color: #227eb9
        }

        .promotion-section a {
            position: relative
        }

        .promotion-heading {
            color: #fff;
            font-size: 26px;
            padding: 0 20px
        }

        .promotion-features, .promotion-heading {
            -webkit-align-self: center;
            -ms-flex-item-align: center;
            align-self: center
        }

        .promotion-features {
            border-top: 1px solid #6f7b8a;
            border-bottom: 1px solid #6f7b8a;
            color: #d8e1ec;
            font-weight: lighter;
            font-size: 14px;
            padding: 12px;
            margin: 20px
        }

        .faq {
            color: #000
        }

        .faq-section {
            margin-top: 125px;
            background-color: #fff
        }

        .faq h1 {
            padding: 15px 75px 15px 15px;
            font-size: 30px;
            margin-bottom: 20px;
            font-weight: 600
        }

        .faq-container a:hover {
            color: #428bca
        }

        .faq-container blockquote {
            display: none;
            margin: 0;
            padding: 0 20px 15px;
            font-weight: 300;
            background-color: #fff;
            border-left: none
        }

        .faq-container h2.active + blockquote {
            display: block
        }

        .faq-container h2 {
            position: relative;
            cursor: pointer;
            font-weight: 500;
            font-size: 21px;
            padding: 35px 75px 35px 20px;
            border-bottom: 1px solid #eee
        }

        .faq-container h2:hover {
            background-color: #fcfdff
        }

        .faq-container h2.active {
            background-color: #fcfdff;
            padding-bottom: 25px;
            border-bottom: 0
        }

        .faq-container h2:after {
            content: "";
            clear: both
        }

        .faq-container h2.active:after, .faq-container h2:after {
            background-image: url(/invoice/images/arrow-sprite-1x.png);
            background-repeat: no-repeat;
            background-size: 104px 40px;
            position: absolute;
            top: 40px;
            right: 35px
        }

        .faq-container h2:after {
            background-position: -26px -15px;
            width: 14px;
            height: 9px
        }

        .faq-container h2.active:after {
            background-position: -65px -17px;
            width: 12px;
            height: 8px
        }

        .faq-container p {
            font-size: 16px;
            line-height: 26px
        }

        .actions-block-border {
            position: relative
        }

        .actions-block-border:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 3px;
            background: -webkit-gradient(linear, left top, right top, from(#2970cf), color-stop(#53a0fd), to(#b4ec51));
            background: -o-linear-gradient(left, #2970cf, #53a0fd, #b4ec51);
            background: linear-gradient(90deg, #2970cf, #53a0fd, #b4ec51);
            top: -3px;
            left: 0
        }

        .menu-icon {
            background: url(/invoice/images/menu.svg) no-repeat;
            cursor: pointer;
            display: inline-block;
            width: 20px;
            height: 20px;
            vertical-align: text-bottom;
            margin-left: 10px
        }

        .generator-links {
            position: fixed;
            overflow: auto;
            top: 0;
            bottom: 0;
            right: -300px;
            background-color: #fff;
            -webkit-transition: all .2s ease-out;
            -o-transition: all .2s ease-out;
            transition: all .2s ease-out;
            width: 300px;
            z-index: 1000001;
            padding: 15px 0 0
        }

        .open-links {
            right: 0
        }

        .generator-links h4 {
            padding-left: 25px
        }

        .generator-links li {
            padding: 11px 0 11px 25px;
            font-size: 16px
        }

        .generator-links a:hover, .generator-links a:visited {
            text-decoration: none
        }

        .links-close {
            font-size: 24px;
            color: #7f7f7f;
            cursor: pointer;
            padding-right: 40px
        }

        .body-dark-overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            opacity: .7;
            z-index: 10;
            background-color: #000
        }

        .za-newsletter-container input {
            vertical-align: top
        }

        .za-newsletter-container label {
            max-width: 96%
        }

        .free-tag {
            position: absolute;
            width: 70px;
            top: 27px;
            left: 265px
        }

        @media screen and (max-width: 767px) {
            .menu-icon {
                background: url(/invoice/images/menu.svg) no-repeat;
                cursor: pointer;
                display: inline-block;
                width: 14px;
                height: 14px;
                vertical-align: baseline;
                margin: 0 0 7px 10px
            }

            .column td:first-child {
                padding: 4px 2px
            }

            .lineItemDIV table {
                table-layout: fixed !important
            }

            .taxsummary table {
                table-layout: unset !important
            }

            .title {
                font-size: 18px
            }

            .logo-tp {
                height: auto;
                width: 50px;
                margin-right: 5px
            }

            .container {
                width: auto;
                padding: 0
            }

            .comp-addr-outer div {
                display: block;
                width: auto
            }

            .comp-addr-invoice {
                float: none;
                text-align: left;
                margin-bottom: 20px
            }

            .c-name.form-control {
                text-align: left;
                font-size: 30px
            }

            .adr-lft, .adr-rgt {
                float: none !important;
                width: auto
            }

            .bill-addr, .faq-section {
                margin-top: 0
            }

            .footer-cta-section, .poweredby {
                text-align: center
            }

            .actions-block-btn {
                padding: 15px;
                width: auto
            }

            .faq h1 {
                padding: 0;
                font-size: 24px;
                text-align: center
            }

            .faq-container h2, .promotion-heading {
                font-size: 17px;
                line-height: 25px
            }

            .logo-icon {
                width: 180px;
                height: 70px
            }

            .footer {
                padding: 30px 20px
            }

            .inv-generator {
                padding: 40px 20px
            }

            .free-tag {
                width: 50px;
                top: 30px;
                left: 190px
            }
        }

        @media screen and (max-width: 420px) {
            .btn-save {
                float: none !important
            }

            .btn-main {
                margin-bottom: 10px
            }

            .total-label {
                width: 34px
            }
        }

        @media only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 2dppx), only screen and (min-resolution: 192dpi) {
            .faq-container h5.active:after, .faq-container h5:hover:after {
                background-image: url(/invoice/images/arrow-sprite-2x.png)
            }

            .footer-cta-section {
                background-image: url(/invoice/inv-gen/footer-bg-2x.png)
            }

            .add, .del, [class^=mobile-] {
                background-image: url(/invoice/inv-gen/icon-blk-2x.png)
            }
        }</style>
    <style type="text/css">
        .loading-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
        }

        .loading-popup {
            top: 22%;
            margin: 100px auto 0;
            max-width: 450px;
            background: #fff;
            padding: 30px;
            z-index: 1200;
            position: relative;
            box-shadow: 0 0 10px #cdcdcd;
            -webkit-box-shadow: 0 0 10px #cdcdcd
        }

        .loading-popup h3 {
            color: #555454;
            font-size: 20px;
            text-align: center;
            margin: 20px auto 8px
        }

        .loading-popup p {
            color: #666;
            clear: both;
            margin: 10px 0;
            font-size: 12px;
            text-align: center;
            line-height: 24px
        }

        .loading-bg {
            background: url(/invoice/images/bg.png) repeat;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            z-index: 1100
        }

        .loading-progress {
            width: 8%;
            margin: 0 auto;
            text-align: center
        }

        .z-access {
            margin-top: 100px;
            text-align: center
        }

        .z-access h3 {
            color: #333
        }

        .z-access .btn-signup {
            width: 220px
        }

        .za-newsletter-container {
            margin-bottom: 0;
            font-size: 11px;
            font-family: Zoho Puvi SemiBold, -apple-system, BlinkMacSystemFont, San Francisco, Helvetica Neue, Helvetica, Ubuntu, Roboto, Noto, Segoe UI, Arial, sans-serif
        }

        .form-grp {
            margin-bottom: 10px;
            position: relative
        }

        .form-field {
            display: block;
            width: 92%;
            height: 32px;
            padding: 5px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #eee;
            border-radius: 2px
        }

        .form-field:focus {
            outline: 0;
            border-color: #1da1f2
        }

        .form-field::-moz-placeholder {
            color: #777;
            opacity: 1
        }

        .form-field:-ms-input-placeholder {
            color: #777
        }

        .form-field::-webkit-input-placeholder {
            color: #777
        }

        .form-field[disabled], .form-field[readonly], fieldset[disabled] .form-field {
            cursor: not-allowed;
            background-color: #eee;
            opacity: 1
        }

        select.form-field {
            -webkit-box-sizing: content-box;
            box-sizing: content-box;
            border-radius: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            border-radius: 2px
        }

        select.ZI-country {
            border-radius: 0;
            font-weight: lighter;
            font-family: Zoho Puvi Regular, -apple-system, BlinkMacSystemFont, San Francisco, Helvetica Neue, Helvetica, Ubuntu, Roboto, Noto, Segoe UI, Arial, sans-serif;
            font-size: 13px;
            color: #d6d6d6;
            padding: 5px 12px;
            border: 1px solid #e0e0e0;
            font-weight: 400;
            color: #444
        }

        .select-placeholder-color {
            color: #999;
            font-size: 15px
        }

        .btn-signup {
            display: inline-block;
            padding: 0 25px;
            color: #fff;
            font-weight: 400;
            font-size: 15px;
            letter-spacing: -.03em;
            line-height: 48px;
            border: none;
            text-transform: uppercase;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, .05);
            -webkit-transition: all .25s ease-in-out;
            -o-transition: all .25s ease-in-out;
            transition: all .25s ease-in-out;
            cursor: pointer;
            width: 95%
        }

        .btn-signup:focus, .btn-signup:hover {
            outline: none
        }

        .social-signup {
            color: #b3b3b3;
            text-align: center;
            border-top: 1px dashed #b3b3b3;
            cursor: pointer
        }

        .social-signup p {
            margin-bottom: 15px;
            color: #b3b3b3
        }

        .social-signup li {
            width: 22px;
            height: 22px;
            text-align: center;
            display: inline-block;
            vertical-align: middle
        }

        .social-signup li:first-child {
            width: 105px;
            height: 47px
        }

        .social-signup li + li {
            margin-left: 15px
        }

        [class^=social-icon-] {
            background-image: url(/invoice/images/signup/zoho-social-icons-1x.png);
            background-repeat: no-repeat;
            background-size: 251px 150px;
            display: inline-block
        }

        .social-icon-google {
            background-position: -3px -81px;
            width: 112px;
            height: 47px
        }

        .social-icon-yahoo {
            background-position: -44px -12px;
            width: 21px;
            height: 21px
        }

        .social-icon-fb {
            background-position: -74px -12px;
            width: 21px;
            height: 21px
        }

        .social-icon-linkedin {
            background-position: -104px -12px;
            width: 21px;
            height: 21px
        }

        .social-icon-twitter {
            background-position: -134px -12px;
            width: 21px;
            height: 21px
        }

        .social-icon-windows {
            background-position: -165px -13px;
            width: 18px;
            height: 18px
        }

        @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2) {
            [class^=social-icon-] {
                background-image: url(/invoice/images/signup/zoho-social-icons-2x.png)
            }
        }

        .password-strength {
            background: none repeat scroll 0 0 #f7f7f7;
            display: block;
            float: right;
            margin-left: 351px;
            margin-top: -35px;
            width: 50px;
            display: none;
            position: absolute;
            top: 43px;
            right: 30px
        }

        .password-strength, .password-strength div {
            border-radius: 5px;
            height: 13px
        }

        .password-strength {
            right: 39px
        }

        .field-msg {
            text-align: left;
            width: 98%
        }

        .field-msg .error {
            color: #ed3d3d;
            font-size: 12px
        }

        .field-error .error {
            display: inline-block !important
        }

        .field-error .form-field {
            -webkit-box-shadow: 0 2px 0 #eb7c7c;
            box-shadow: 0 2px 0 #eb7c7c
        }

        .field-error .form-field:focus {
            -webkit-box-shadow: 0 2px 0 #eb7c7c;
            box-shadow: 0 2px 0 #eb7c7c
        }

        .field-error .field-msg {
            display: block !important
        }

        .field-error .s-icon-name {
            background-position: -10px -523px
        }

        .field-error .s-icon-email {
            background-position: -8px -644px
        }

        .field-error .s-icon-pswd {
            background-position: -8px -768px
        }

        .field-error .s-icon-cname {
            background-position: -9px -584px
        }

        .field-error .s-icon-portal {
            background-position: -9px -827px
        }

        .field-error .s-icon-flag {
            background-position: -4px -1344px
        }

        .field-error .s-icon-phone {
            background-position: -9px -705px
        }

        .field-error .s-icon-country {
            background-position: -14px -768px
        }

        .field-error .s-icon-seg {
            background-position: -10px -949px
        }

        :-moz-placeholder, ::-moz-placeholder {
            color: #999;
            font-weight: 400;
            font-size: 14px
        }

        ,
        ::-webkit-input-placeholder {
            color: #999;
            font-size: 14px;
            font-weight: 200
        }

        :-ms-input-placeholder {
            color: #999;
            font-size: 14px;
            font-weight: 200
        }

        .za-tos-container {
            line-height: 18px;
            font-size: 11px;
            margin-bottom: 15px
        }

        .za-tos-container .tos-checkbox, .za-tos-container .tos-label {
            cursor: pointer;
            font-family: Zoho Puvi SemiBold, -apple-system, BlinkMacSystemFont, San Francisco, Helvetica Neue, Helvetica, Ubuntu, Roboto, Noto, Segoe UI, Arial, sans-serif
        }

        .za-tos-container .tos-label {
            margin-left: 5px
        }

        .za-tos-container .change-country-link {
            text-decoration: underline;
            margin-left: 3px
        }

        .za-tos-container .tos-checkbox {
            float: left
        }

        .za-domain-error {
            margin-left: 40px;
            font-size: 13px
        }

        .sign_agree a, .za-donami-error a {
            color: #298ff6;
            text-decoration: underline;
            cursor: pointer
        }

        .za-captcha-container input[type=text] {
            width: 220px;
            margin-top: 6px
        }

        .loader {
            font-size: 10px;
            margin: 0;
            text-indent: -9999em;
            width: 5em;
            height: 5em;
            border-radius: 50%;
            background: #453e70;
            background: -o-linear-gradient(left, #453e70 10%, rgba(69, 62, 112, 0) 42%);
            background: -webkit-gradient(linear, left top, right top, color-stop(10%, #453e70), color-stop(42%, rgba(69, 62, 112, 0)));
            background: linear-gradient(90deg, #453e70 10%, rgba(69, 62, 112, 0) 42%);
            position: relative;
            -webkit-animation: load3 1.4s linear infinite;
            animation: load3 1.4s linear infinite;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0)
        }

        .loader:before {
            width: 50%;
            height: 50%;
            background: #453e70;
            border-radius: 100% 0 0 0;
            position: absolute;
            top: 0;
            left: 0;
            content: ""
        }

        .loader:after {
            background: #fff;
            width: 75%;
            height: 75%;
            border-radius: 50%;
            content: "";
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0
        }

        @-webkit-keyframes load3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg)
            }
            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }

        @keyframes load3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg)
            }
            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }</style>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print, #section-to-print * {
                visibility: visible;
            }

            #add-new-item {
                visibility: hidden;
                display: none;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }

        }

        .test {
            color: red;
        }

        input[type=text], input[type=email], input[type=url], input[type=password], input[type=tel], input[type=range], input[type=date], input[type=month], input[type=week], input[type=time], input[type=datetime], input[type=datetime-local], input[type=color], input[type=number], input[type=search], textarea {
            color: #666;
            border: none;
            padding: 1px;
        }


        input:focus {
            background: yellow !important;
            border: 1px solid #0e566c !important;

        }

        textarea:focus {
            background: yellow !important;
            border: none !important;
            outline: 1px solid #0e566c !important;

        }

        .hd {
            background: #0e566c !important;
        }


        .print {
            color: white;
        }

    </style>
@endsection
@section('content')
    @verbatim
        <div style="background: #efefef">
            <h1 class="d-none">Invoice Generator - Free Invoice Pedia</h1>
            <p class="d-none">The world's simplest way to invoice customers, from your phone or laptop. Save time, stay
                organized and look professional!</p>

            <div id="app" style="margin-top: 118px;">

                <div class="row align-items-center justify-content-center">
                    <div class="col pl-4">
                        <button class="btn btn-primary mt-4" v-on:click="print" style="width: 150px">Print</button>
                    </div>

                    <div class="col" style="text-align: right">
                        <button class="btn btn-success mt-4">Save as PDF</button>

                    </div>
                </div>

                <div id="section-to-print" class="bg-white lft-main-div  mx-auto" style="width: 770px"
                     contenteditable="true">
                    <form name="invoiceGenerator" class="inv-generator">

                        <div class="row">
                            <div class="col">
                                <div class="">
                                    <input hidden id="logo" type='file' v-on:change="readURL"/>
                                    <label for="logo">
                                        <div
                                            style="height: 110px;width: 120px;margin-bottom: 10px;border: 1px dotted black"
                                            class="border mb-2">
                                            <img id="blah"
                                                 src="https://1.bp.blogspot.com/-vrj3yghszZg/YZI_MdCtD8I/AAAAAAAAFP0/tTH3EvnTLYI96mY3aHofbIsOwyBEImgyACLcBGAsYHQ/s16000/Group%2B5.png"
                                                 alt="Update Your Logo" width="120" height="110"/>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <input class="c-name form-control ml-2" type="text"
                                       v-model="title"
                                       tabindex="5" id="title"
                                       name="title"
                                       data-json-node="title" data-is-array="false"
                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">

                            </div>
                        </div>
                        <input type="text" id="company_name" class="adr bld f20 form-control"
                               style="height: 30px"
                               tabindex="1"
                               autofocus="focus"
                               placeholder="Your Company"
                               name="company_name"
                               v-model="company.company">

                        <ul class="row justify-content-around align-items-center">
                            <div class="col-4">
                                <div class="">


                                    <input type="text" id="custName" class="adr form-control" tabindex="2"
                                           placeholder="Your Name"
                                           v-model="company.name"

                                           name="user_name"
                                           data-json-node="user_name" data-is-array="false">

                                    <input type="text" id="address2" class="adr form-control" tabindex="3"
                                           placeholder="Company’s Address"
                                           v-model="company.address1"
                                           name="company_address_1"/>
                                    <input type="text" class="adr form-control" tabindex="4"
                                           placeholder="City, State Zip"
                                           v-model="company.address2"

                                           name="company_address_2">

                                    <input type="text" class="adr form-control" tabindex="4" id="companyCountry"
                                           placeholder="Country"
                                           v-model="company.country"

                                           name="company_country" data-json-node="company_country" data-is-array="false"
                                    >
                                    <br>
                                </div>

                            </div>

                            <li class="col-4">
                                <table width="100%" cellpadding="0" cellspacing="0" class="bill"
                                       style="table-layout: fixed">
                                    <tbody>
                                    <tr>
                                        <td class="lft-txt" width="40%">
                                            <input type="text" value="Invoice#" id="invNumberLabel"
                                                   class="bld text-left w100 form-control" tabindex="12"


                                                   name="invoice_number_label" data-json-node="invoice_number_label"
                                                   data-is-array="false">
                                        </td>
                                        <td>
                                            <input type="text" class="w100 form-control" id="invNumber" tabindex="13"
                                                   placeholder="INV-12"


                                                   name="invoice_number" data-json-node="invoice_number"
                                                   data-is-array="false">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="lft-txt">
                                            <input type="text" value="Invoice Date" id="invoiceDateLabel"
                                                   class="bld text-left w100 form-control" tabindex="14"


                                                   name="invoice_date_label" data-json-node="invoice_date_label"
                                                   data-is-array="false">
                                        </td>
                                        <td>
                                            <input class="w100 form-control" type="text" id="invoiceDate" tabindex="15"
                                                   placeholder="Nov 14, 2021"

                                                   name="invoice_date"
                                                   data-json-node="invoice_date" data-is-array="false">
                                        </td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td class="lft-txt">
                                            <input value="Due Date" id="dueDateLabel"
                                                   class="bld text-left w100 form-control"
                                                   type="text" tabindex="16"


                                                   name="due_date_label" data-json-node="due_date_label"
                                                   data-is-array="false">

                                        </td>
                                        <td>
                                            <input id="dueDate" class="w100 form-control" tabindex="17" type="text"
                                                   placeholder="Nov 14, 2021"
                                                   name="due_date"
                                                   data-json-node="due_date" data-is-array="false">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </li>
                            <li class="col-4" style="text-align: right">
                                <input type="text" value="Bill To:" id="billToLabel"
                                       class="adr bill-to bld form-control text-right"
                                       tabindex="6">
                                <input type="text" id="billingAddress1" class="adr form-control" tabindex="6"
                                       placeholder="Your Client’s Company"
                                       name="customer_name"
                                       v-model="bill.company" style="text-align: right">
                                <small id="billingAddress1_err" class="text-danger hide">Please fill in your client’s
                                    name
                                    or
                                    their
                                    company name</small>

                                <input type="text" id="billingAddress2" class="adr form-control" tabindex="7"
                                       placeholder="Client’s Address"

                                       v-model="bill.address1"
                                       style="text-align: right">
                                <input type="text" class="adr form-control" id="billingAddress3" tabindex="8"
                                       placeholder="City, State Zip"

                                       v-model="bill.address2"
                                       style="text-align: right">


                                <input type="text" class="adr form-control" tabindex="10" id="customerCountry"
                                       placeholder="Country"
                                       v-model="bill.country"
                                       style="text-align: right">
                            </li>
                        </ul>

                        <div class="lineItemDIV">
                            <table width="100%" cellpadding="0" cellspacing="0" class="column"
                                   style="table-layout: fixed">
                                <thead>
                                <tr class="hd " style="text-align: center">

                                    <td width="40%">
                                        <input style="text-align:left; margin-left: 10px!important;" type="text"
                                               id="itemDescLabel"
                                               value="Item Description"
                                               class="bld w100 form-control" tabindex="19"

                                               name="name"
                                               data-json-node="name" data-is-array="false"
                                               data-parent-json="line_items_header">
                                    </td>
                                    <td width="17%">
                                        <input type="text" value="Qty" id="itemQtyLabel" class="bld w100 input"
                                               tabindex="19"


                                               style="height: 20px!important;text-align: center"
                                               name="quantity"
                                               data-json-node="quantity" data-is-array="false"
                                               data-parent-json="line_items_header">
                                    </td>
                                    <td width="17%">
                                        <input type="text" value="Rate" id="itemRateLabel" class="bld w100 text-left"
                                               tabindex="19"

                                               style="height: 20px!important;text-align: center"

                                               name="rate"
                                               data-json-node="rate" data-is-array="false"
                                               data-parent-json="line_items_header">
                                    </td>


                                    <td width="18%">
                                        <input type="text" value="Amount" id="itemAmtLabel"
                                               class="bld w100 text-right form-control"
                                               style="text-align:center;" tabindex="19"
                                        >
                                    </td>
                                    <td width="18%">
                                        <input type="text" value="VAT %" id="itemAmtLabel"
                                               class="bld w100 text-right form-control"
                                               style="text-align:center;" tabindex="19"
                                        >
                                    </td>
                                    <td width="18%">
                                        <input type="text" value="TOTAL" id="itemAmtLabel"
                                               class="bld w100 text-right form-control"
                                               style="text-align:center;" tabindex="19"
                                        >
                                    </td>

                                    <td style="border-bottom:none;background:none;border-top:none" width="2%"
                                        class="dele-icon">
                                        &nbsp;
                                    </td>
                                </tr>
                                </thead>

                                <tbody class="lineItems">


                                <tr v-for="(item, index) in items" class="row-item trClone " id="lineItem.0"
                                    v-on:mouseover="showCloseIcon(index,true)"
                                    v-on:mouseout="showCloseIcon(index,false)"

                                >
                                    <td>
                            <textarea type="text" class="w100" tabindex="20" id="itemDesc.0"
                                      rows="1"
                                      v-model="items[index].name"
                                      placeholder="Enter item name/description"> </textarea>

                                    </td>
                                    <td>
                                        <input type="number" step="any" class=" form-control text-right"
                                               style="font-size: 18px;font-weight: bolder;text-align: center"
                                               v-model="items[index].qnt"
                                               @blur="items[index].qnt = items[index].qnt.toFixed(2)"

                                               tabindex="20">
                                    </td>
                                    <td>
                                        <input
                                            type="number" step="any" class=" form-control "
                                            style="font-size: 18px;font-weight: bolder;text-align: center"
                                            v-model="items[index].price"
                                            @blur="items[index].price = items[index].price.toFixed(2)"
                                            tabindex="20">
                                    </td>


                                    <td>
                                        <input type="number" step="any" class=" form-control text-right"
                                               style="font-size: 18px;font-weight: bolder;text-align: center"
                                               :value="items[index].amount"
                                               readonly
                                               tabindex="20">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class=" form-control text-right"
                                               style="font-size: 18px;font-weight: bolder;text-align: center"
                                               v-model="items[index].vat"
                                               @blur="items[index].vat = items[index].vat.toFixed(2)"
                                               tabindex="20">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class=" form-control text-right"
                                               style="font-size: 18px;font-weight: bolder;text-align: center"
                                               readonly
                                               :value="items[index].total"
                                               tabindex="20">
                                    </td>

                                    <td>

                                <span v-on:click="removeItem(index)" v-show="item.showCloseButton" class="close-btn"
                                      style="cursor:pointer;display: none">
                                    ❌
                                </span>


                                    </td>


                                </tr>


                                </tbody>

                                <tbody>
                                <tr>
                                    <td>

                                        <div id="add-new-item">
                                            <a
                                                class=" btn btn-outline-primary"
                                                style="cursor:pointer;margin-left:0px;margin-top: -1px;" title="Add Row"
                                                v-on:click="addItem"><span class="fa fa-plus">&nbsp;</span>Add Line Item</a>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class=" text-right"><b class="font-weight-bolder" style="font-size: 18px">Sub
                                            Total</b></td>
                                    <td class=" text-right"><b class="font-weight-bolder "
                                                               style="font-size: 18px;margin-right: 15px">{{ sub_total }}</b>
                                    </td>

                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class=" text-right"><b class="font-weight-bolder" style="font-size: 18px">
                                            Vat</b></td>
                                    <td class=" text-right"><b class="font-weight-bolder "
                                                               style="font-size: 18px;margin-right: 15px">{{ vat }}</b>
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class=" text-right"><b class="font-weight-bolder" style="font-size: 18px">Discount</b>
                                        <select name="" id="" v-model="discount_type">
                                            <option value="flat">Flat</option>
                                            <option value="%">%</option>
                                        </select>
                                    </td>
                                    <td class=" text-right">
                                        <b class="font-weight-bolder " style="font-size: 18px;margin-right: 15px">
                                            <input type="number"
                                                   v-model="discount"
                                                   step="any"
                                                   class="form-control text-right d-inline" tabindex="20"
                                                   @blur="discount = discount.toFixed(2)"
                                                   style="font-size: 18px; font-weight: bolder;">
                                            ({{ discountValue }})
                                        </b>
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class=" text-right"><b class="font-weight-bolder"
                                                               style="font-size: 18px">Total</b></td>
                                    <td class=" text-right"><b class="font-weight-bolder "
                                                               style="font-size: 18px;margin-right: 15px">{{ total }}</b>
                                    </td>

                                </tr>

                                </tbody>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div>


                            <div style="width: 50%;float: left">
                                <div>
                                    <input class="terms form-control" value="Notes" id="notesLabel" tabindex="28"
                                           name="notes_label"
                                           data-json-node="notes_label" data-is-array="false">
                                </div>
                                <div>
                <textarea class="note form-control" id="customerNotes" tabindex="29" name="notes" data-json-node="notes"
                          data-is-array="false"
                          v-model="notes"
                          style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 52px;">It was great doing business with you.</textarea>
                                </div>
                                <div>
                                    <input class="terms form-control" value="Terms &amp; Conditions" id="termsLabel"
                                           tabindex="30"
                                           name="terms_and_conditions_label" data-json-node="terms_and_conditions_label"
                                           data-is-array="false">
                                </div>
                                <div>
                            <textarea
                                class="note form-control" id="terms" tabindex="31" name="terms_and_conditions"
                                data-json-node="terms_and_conditions" data-is-array="false"
                                v-model="terms"
                                style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 52px;">Please make the payment by the due date.</textarea>
                                </div>
                            </div>
                            <div style="float: right;margin-top: 50px">
                                Powered By
                                <img
                                    src="https://app.invoicepedia.com/images/invoicepedia.png"
                                    width="122" height="20"
                                    alt="Invoice Pedia">
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    @endverbatim



@endsection

@section('js')
    <script src="https://unpkg.com/vue@next"></script>
    <script>

        const App = {
            data() {
                return {
                    discount_type: 'flat',
                    discount: '0.00',
                    discountValue: '0.00',
                    items: [{
                        name: 'Apple',
                        qnt: '1.00',
                        price: '155.00',
                        amount: '0.00',
                        vat: '0.00',
                        total: '0.00',
                        showCloseButton: false
                    }, {
                        name: '',
                        qnt: '1.00',
                        price: '0.00',
                        amount: '0.00',
                        vat: '0.00',
                        total: '0.00',
                        showCloseButton: false
                    }],
                    company: {
                        company: '',
                        name: '',
                        address1: '',
                        address2: '',
                        country: ''
                    },
                    bill: {
                        company: '',
                        address1: '',
                        address2: '',
                        country: ''
                    }, invoice_date: '', due_date: '',
                    title: 'INVOICE',
                    notes: 'It was great doing business with you.',
                    terms: 'Please make the payment by the due date.'

                }
            },
            watch: {
                company: {
                    handler: function (val, oldVal) {
                        localStorage.setItem('company', JSON.stringify(val))
                    },
                    deep: true
                },
                bill: {
                    handler: function (val, oldVal) {
                        localStorage.setItem('bill', JSON.stringify(val))
                    },
                    deep: true
                },
                invoice_date: function (val, oldVal) {
                    localStorage.setItem('invoice_date', val)

                },
                due_date: function (val, oldVal) {
                    localStorage.setItem('due_date', val)

                },
                'title': function (val, oldVal) {
                    localStorage.setItem('title', val)
                    console.log(val, oldVal)
                },
                'notes': function (val, oldVal) {
                    localStorage.setItem('notes', val)

                },
                'terms': function (val, oldVal) {
                    localStorage.setItem('terms', val)

                },
                'discount_type': function (val, oldVal) {
                    this.calculateDiscount()
                },
                'discount': function (val, oldVal) {
                    this.calculateDiscount()

                },
                items: {
                    handler: function (newItems, oldVal) {
                        for (let i = 0; i < newItems.length; i++) {
                            newItems[i].amount = (newItems[i].qnt * newItems[i].price).toFixed(2)
                            let vatAmount = newItems[i].amount * (parseFloat(newItems[i].vat) / 100)
                            newItems[i].vatAmount = vatAmount;
                            newItems[i].total = (parseFloat(newItems[i].amount) + parseFloat(vatAmount)).toFixed(2);
                        }
                        this.items = newItems
                        this.calculateDiscount()
                    },
                    deep: true
                },
            },
            methods: {
                showCloseIcon(index, state) {
                    this.items[index].showCloseButton = state;
                },
                removeItem(index) {
                    if (this.items.length <= 1) return;
                    this.items.splice(index, 1)
                },
                addItem() {
                    this.items.push({
                        name: '',
                        qnt: '1.00',
                        price: '0.00',
                        amount: '0.00',
                        vat: '0.00',
                        total: '0.00',
                        showCloseButton: false
                    })
                },
                print() {
                    window.print()
                },
                calculateDiscount() {
                    let discount_type = this.discount_type
                    let discount = this.discount
                    if (discount_type === "flat") {
                        this.discountValue = discount;
                        this.total = parseFloat(this.total) + discount;
                    } else {
                        this.discountValue = (parseFloat(this.sub_total) / 100) * discount
                        this.total = parseFloat(this.total) + this.discountValue;
                    }
                },
                readURL(input) {
                    input = document.getElementById('logo')
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#blah')
                                .attr('src', e.target.result)
                                .width(120)
                                .height(110);
                            localStorage.setItem('logo', $('#blah').attr('src'))
                        };

                        reader.readAsDataURL(input.files[0]);

                    }
                }
            },
            computed: {
                sub_total() {
                    let sum = 0;
                    for (let i = 0; i < this.items.length; i++) {
                        sum += (parseFloat(this.items[i].price) * parseFloat(this.items[i].qnt));
                    }

                    return sum.toFixed(2);
                },
                vat() {
                    let sum = 0;
                    for (let i = 0; i < this.items.length; i++) {
                        sum += parseFloat(this.items[i].vatAmount || '0');
                    }
                    return sum.toFixed(2);
                },
                total() {
                    return parseFloat(parseFloat(this.sub_total) + parseFloat(this.vat) - parseFloat(this.discountValue)).toFixed(2);
                }

            },
            mounted: function () {
                let companyCache = localStorage.getItem('company')
                let billCache = localStorage.getItem('bill')
                let titleCache = localStorage.getItem('title')
                let notesCache = localStorage.getItem('notes')
                let logoCache = localStorage.getItem('logo')
                let termsCache = localStorage.getItem('terms')
                let invoice_dateCache = localStorage.getItem('invoice_date')
                let due_dateCache = localStorage.getItem('due_date')
                if (companyCache) {
                    this.company = JSON.parse(companyCache);
                }
                if (billCache) {
                    this.bill = JSON.parse(billCache);
                }
                if (invoice_dateCache) {
                    this.invoice_date = invoice_dateCache;
                }
                if (due_dateCache) {
                    this.invoice_date = due_dateCache;
                }
                if (titleCache) {
                    this.title = titleCache;
                }
                if (notesCache) {
                    this.notes = notesCache;
                }
                if (termsCache) {
                    this.terms = termsCache;
                }
                if (logoCache) {

                    $('#blah').attr('src', logoCache)
                }
            }
        }

        Vue.createApp(App).mount('#app')
        $("#invoiceDate").datepicker();
        $('#invoiceDate').datepicker("option", "dateFormat", "M d, yy");
        $("#dueDate").datepicker();
        $('#dueDate').datepicker("option", "dateFormat", "M d, yy");
        $(document).ready(function () {
            $('#company_name').focus()
        })
    </script>
@endsection

