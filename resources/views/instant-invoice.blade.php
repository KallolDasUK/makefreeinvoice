@php($title = 'Instant Invoice Generator - MakeFreeInvoice')
@extends('landing.layouts.app', ['hide_messenger' => true])


@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/instant-invoice.css') }}">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
@endsection

@section('content')
    <h1 class="d-none">Invoice Generator - Free Invoice Pedia</h1>
    <p class="d-none">The world's simplest way to invoice customers, from your phone or laptop. Save time, stay
        organized and look professional!</p>
    <div class="d-flex invoice" style="background: #efefef;">

        @verbatim
            <div style="width: 868px">
                <div class="flex mx-auto" style="width: 788px">

                    <div id="app" style="margin-top: 80px;">
                        <div class="row align-items-center justify-content-center mb-3">
                            <div class="col pl-4">
                                <a class="btn btn-primary mt-4 print-btn" href="javascript:window.print();">Print <i class="fa fa-print" aria-hidden="true"></i></a>
                            </div>

                            <div class="col text-right"  onclick="save()">
                                <button class="btn save mt-4">Save as PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>

                            </div>
                        </div>

                        <div id="section-to-print" class="bg-white lft-main-div " style="width: 100%" contenteditable="true">
                            <form name="invoiceGenerator" class="inv-generator">

                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <input hidden id="logo" type='file' onchange="readURL()" />
                                            <label for="logo">
                                                <div style="height: 110px;width: 120px;margin-bottom: 10px;border: 1px dotted black"
                                                    class="border mb-2">
                                                    <img id="blah" src="<?= asset('logo.webp') ?>" alt="Update Your Logo"
                                                        width="120" height="110" />
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input class="c-name form-control ml-2" type="text" tabindex="5" id="title"
                                            name="title" value="Invoice" data-json-node="title" data-is-array="false"
                                            style="cursor: auto;">

                                    </div>
                                </div>
                                <input type="text" id="company_name" class="adr bld f20 form-control shadow-none"
                                    style="height: 30px;margin-left: 10px;" tabindex="1" placeholder="Your Company"
                                    name="company_name" value="<?= config('app.name') ?>">

                                <div class="row border-top border-bottom py-1 my-2 free-invoice-date-due">
                                    <div>
                                        <div class="invoice-date-section">
                                            <span id="invoiceDateLabelHidden" class="invoiceDateLabelHidden">Date:</span>
                                            <input type="text" value="Date:" id="invoiceDateLabel"
                                                class="font-weight-700 text-left w100 form-control invoiceDateLabel"
                                                tabindex="14" name="invoice_date_label" data-json-node="invoice_date_label"
                                                data-is-array="false">
                                            <input class="w100 form-control" type="text" id="invoiceDate" tabindex="15"
                                                placeholder="May 14, 2024" name="invoice_date" data-json-node="invoice_date"
                                                data-is-array="false">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="invoice-date-section">
                                            <input value="Due Date:" id="dueDateLabel"
                                                class="font-weight-700 text-left w100 form-control text-right" type="text"
                                                tabindex="16" name="due_date_label" data-json-node="due_date_label"
                                                data-is-array="false">

                                            <input id="dueDate" class="w100 form-control" tabindex="17" type="text"
                                                placeholder="June 14, 2024" name="due_date" data-json-node="due_date"
                                                data-is-array="false">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="invoice-date-section">
                                            <input type="text" value="Invoice No:" id="invNumberLabel"
                                                class="font-weight-700 text-left w100 form-control text-right" tabindex="12"
                                                name="invoice_number_label" data-json-node="invoice_number_label"
                                                data-is-array="false">
                                            <span id="invoice_number_hidden" class="invoice_number_hidden">INV-01</span>
                                            <input type="text" class="w100 form-control invoice_number" id="invNumber"
                                                tabindex="13" placeholder="INV-12" name="invoice_number"
                                                data-json-node="invoice_number" data-is-array="false" value="INV-01">
                                        </div>
                                    </div>


                                </div>


                                <ul class="row">
                                    <li class="col-4">
                                        <input type="text" value="Bill To:" id="billToLabel"
                                            class="adr bill-to bld form-control" tabindex="6">
                                        <input type="text" id="billingAddress1" class="adr form-control" tabindex="6"
                                            placeholder="Your Client’s Company" name="customer_name" v-model="bill.company">
                                        <small id="billingAddress1_err" class="text-danger hide">Please fill in your
                                            client’s
                                            name
                                            or
                                            their
                                            company name</small>

                                        <input type="text" id="billingAddress2" class="adr form-control" tabindex="7"
                                            placeholder="Client’s Address" v-model="bill.address1">
                                        <input type="text" class="adr form-control" id="billingAddress3" tabindex="8"
                                            placeholder="City, State Zip" v-model="bill.address2">

                                        <input type="text" class="adr form-control" tabindex="10" id="customerCountry"
                                            placeholder="Country" v-model="bill.country">
                                    </li>


                                    <li class="col-4">
                                        <input type="text" value="Tax Id:" id="taxIdLabel" class="adr bld form-control text-center" tabindex="6">
                                        <input type="text" id="taxId" class="adr form-control text-center" tabindex="6" placeholder="77GH32" name="taxid">
                                    </li>


                                    <div class="col-4">
                                        <div class="text-right">
                                            <input type="text" value="From:" id="billToLabel"
                                                class="adr bill-to bld form-control text-right" tabindex="6">
                                            <input type="text" id="custName" class="adr form-control text-right"
                                                tabindex="2" placeholder="Your Name" v-model="company.name"
                                                name="user_name" data-json-node="user_name" data-is-array="false">

                                            <input type="text" id="address2" class="adr form-control text-right"
                                                tabindex="3" placeholder="Company’s Address" v-model="company.address1"
                                                name="company_address_1" />
                                            <input type="text" class="adr form-control text-right" tabindex="4"
                                                placeholder="City, State Zip" v-model="company.address2"
                                                name="company_address_2">

                                            <input type="text" class="adr form-control text-right" tabindex="4"
                                                id="companyCountry" placeholder="Country" v-model="company.country"
                                                name="company_country" data-json-node="company_country"
                                                data-is-array="false">
                                            <br>
                                        </div>

                                    </div>

                                </ul>

                                <div class="lineItemDIV">
                                    <table width="100%" cellpadding="0" cellspacing="0" class="column"
                                        style="table-layout: fixed">
                                        <thead>
                                            <tr class="hd " style="text-align: center">

                                                <td width="40%">
                                                    <input style="text-align:left; margin-left: 10px!important;"
                                                        type="text" id="itemDescLabel" value="Description"
                                                        class="bld w100 " tabindex="19" name="name"
                                                        data-json-node="name" data-is-array="false"
                                                        data-parent-json="line_items_header">
                                                </td>
                                                <td width="17%">
                                                    <input type="text" value="Unit" id="itemUnitLabel"
                                                        class="bld w100 input" tabindex="19" style="text-align: center"
                                                        name="unit" data-json-node="unit" data-is-array="false"
                                                        data-parent-json="line_items_header">
                                                </td>

                                                <td width="17%">
                                                    <input type="text" value="Rate" id="itemRateLabel"
                                                        class="bld w100 text-left" tabindex="19" style="text-align: center"
                                                        name="rate" data-json-node="rate" data-is-array="false"
                                                        data-parent-json="line_items_header">
                                                </td>
                                                <td width="17%">
                                                    <input type="text" value="Qty" id="itemQtyLabel"
                                                        class="bld w100 input" tabindex="19" style="text-align: center"
                                                        name="quantity" data-json-node="quantity" data-is-array="false"
                                                        data-parent-json="line_items_header">
                                                </td>


                                                <td width="18%">
                                                    <input type="text" value="Tax" id="itemAmtLabel"
                                                        class="bld w100 text-right " style="text-align:center;"
                                                        tabindex="19">
                                                </td>
                                                <td width="18%">
                                                    <input type="text" value="Amount" id="itemAmtLabel"
                                                        class="bld w100 text-right " style="text-align:center;"
                                                        tabindex="19">
                                                </td>

                                                <td style="border-bottom:none;background:none;border-top:none" width="2%"
                                                    class="dele-icon">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </thead>

                                        <tbody class="lineItems" id="lineItems">
                                            <tr class="row-item trClone " id="row0" onmouseover="showCloseIcon(0,true)"
                                                onmouseout="showCloseIcon(0,false)">
                                                <td>
                                                    <textarea type="text" class="w100" tabindex="20" id="itemDesc.0" rows="1"
                                                        placeholder="Enter item name/description" style="margin: 10px 0px"></textarea>

                                                </td>
                                                <td>
                                                    <input type="text" step="any" class=" form-control text-right instant"
                                                        style="font-weight: bolder;text-align: center" tabindex="20"
                                                        placeholder="Unit/Pcs">
                                                </td>
                                                <td>
                                                    <input type="number" step="any" class=" form-control instant"
                                                        style="font-weight: bolder;text-align: center" tabindex="20"
                                                        placeholder="$100">
                                                </td>
                                                <td>
                                                    <input type="number" step="any" class=" form-control text-right instant"
                                                        style="font-weight: bolder;text-align: center" tabindex="20"
                                                        placeholder="20">
                                                </td>
                                                <td>
                                                    <input type="number" step="any" class=" form-control text-right instant"
                                                        style="font-weight: bolder;text-align: center" tabindex="20"
                                                        placeholder="0">
                                                </td>
                                                <td>
                                                    <input type="number" step="any" class=" form-control text-right instant"
                                                        style="font-weight: bolder;" tabindex="20" placeholder="$2000">
                                                </td>

                                                <td>
                                                    <span onclick="removeItem('row0')" class="close-btn"
                                                        style="cursor:pointer;display: none">
                                                        ❌
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tbody>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>
                                                <td colspan="2" class="border-bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <div id="add-new-item" class="hideFromPrint">
                                                        <a class="btn btn-primary btn-xs hideFromPrint add-new-item"
                                                            title="Add Row" onclick="addLineItems()"><span
                                                                class="fa fa-plus">&nbsp;</span>Add Item</a>
                                                    </div>
                                                </td>
                                                <td class="border-bottom">
                                                    <input type="text" class=" form-control text-right"
                                                        style="font-weight: bolder;" tabindex="20" placeholder="Sub Total:"
                                                        value="Sub Total:">
                                                </td>
                                                <td class="border-bottom"> <input type="number"
                                                        class="form-control  text-right" style="font-weight: bolder;"
                                                        tabindex="20" placeholder="$2000"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="border-bottom"> <input type="text"
                                                        class=" form-control text-right" style="font-weight: bolder;"
                                                        tabindex="20" placeholder="Total:" value="Total:"> </td>
                                                <td class="border-bottom"> <input type="number"
                                                        class="form-control text-right" style="font-weight: bolder;"
                                                        tabindex="20" placeholder="$2000"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="border-bottom">
                                                    <input type="text" class=" form-control text-right"
                                                        style="font-weight: bolder;" tabindex="20" placeholder="Paid:"
                                                        value="Paid:">
                                                </td>
                                                <td class="border-bottom"> <input type="number"
                                                        class="form-control text-right" style="font-weight: bolder;"
                                                        tabindex="20" placeholder="$1000"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="border-bottom">
                                                    <input type="text" class=" form-control text-right"
                                                        style="font-weight: bolder;" tabindex="20" placeholder="Due:"
                                                        value="Due:">
                                                </td>
                                                <td class="border-bottom"> <input type="number"
                                                        class="form-control text-right" style="font-weight: bolder;"
                                                        tabindex="20" placeholder="$1000"></td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div>


                                    <div style="width: 50%;float: left">
                                        <div>
                                            <input class="terms form-control" value="Inword Number" id="inWordLabel"
                                                tabindex="28" name="Inword Number"
                                                data-json-node="terms_and_conditions_label" data-is-array="false">
                                        </div>
                                        <div>
                                            <input class="form-control" value="Inword" id="inWord"
                                                tabindex="29" name="Inword"
                                                data-json-node="terms_and_conditions_label" data-is-array="false">
                                        </div>
                                        <div>
                                            <input class="terms form-control" value="Terms &amp; Conditions" id="termsLabel"
                                                tabindex="30" name="terms_and_conditions_label"
                                                data-json-node="terms_and_conditions_label" data-is-array="false">
                                        </div>
                                        <div>
                                            <textarea class="note form-control" id="terms" tabindex="31" name="terms_and_conditions"
                                                data-json-node="terms_and_conditions" data-is-array="false" v-model="terms"
                                                style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 52px;">Please make the payment by the due date.</textarea>
                                        </div>
                                        <div>
                                            <input class="terms form-control" value="Notes" id="notesLabel" tabindex="28"
                                                name="notes_label" data-json-node="notes_label" data-is-array="false">
                                        </div>
                                        <div>
                                            <textarea class="note form-control" id="customerNotes" tabindex="29" name="notes" data-json-node="notes"
                                                data-is-array="false" v-model="notes"
                                                style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 52px;">It was great doing business with you.</textarea>
                                        </div>
                                    </div>
                                    <div style="float: right;margin-top: 50px">

                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>

        @endverbatim
        <div class="login col mr-4" style="width: 100%;margin-top: 140px;margin-right: 10px">

            <div class="card shadow rounded border-0  ">
                <div class="card-body">

                    <h5 class="card-title"><b style="color: #065a92">Join Now</b>, <b>Why should you log in?</b></h5>


                    {{--
                    Save Product to our Database
                    Save Customer to our Database
                    Save your logo and address
                    Use unlimited times
                    Track your invoice
                    Super User Friendly
                    &
                    All features are absolutely FREE
                    --}}
                    <ul id="headline" class="fallingtextrotator" style="height:1em;">
                        <li>Save Product</li>
                        <li>Save Customer</li>
                        <li>Save logo and address</li>
                        <li>Track your invoice</li>
                        <li>Use unlimited times</li>
                        <li>Super User Friendly</li>
                        <li>ABSOLUTELY FREE</li>
                    </ul>


                    <div class="item-list d-none mt-4">
                        <div class="item">
                            <div class="item-label">
                                Save Product to our Database
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-label">
                                Save Customer to our Database
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-label">
                                Save your logo and address
                            </div>
                        </div>

                        <div class="item">
                            <div class="item-label">
                                Use unlimited times
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-label">
                                Track your invoice
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-label">
                                Super User Friendly
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-label">
                                All features are absolutely FREE
                            </div>
                        </div>
                    </div>


                    <div>
                        <form class="login-form mt-4" action="{{ route('register') }}" method="post">
                            @honeypot
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
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password<span
                                                class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-key fea icon-sm icons">
                                                <path
                                                    d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
                                            </svg>
                                            @error('password_confirmation')
                                            <small class="text-danger"> {{ $message }}</small>
                                            @enderror
                                            <input style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="password" id="password_confirmation" name="password_confirmation" class="form-control ps-5" autocomplete="off" placeholder="Confirm Password">
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
                                <div class="col-12 text-center">
                                    <p class="mb-0 mt-3"><small class="text-dark me-2">Already have an account
                                            ?</small>
                                        <a href="{{ route('login') }}" class="text-dark fw-bold">Login</a></p>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script src="https://unpkg.com/vue@next"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"
        integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function readURL(input) {
            input = document.getElementById('logo')
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(120)
                        .height(110);
                    localStorage.setItem('logo', $('#blah').attr('src'))
                };

                reader.readAsDataURL(input.files[0]);

            }
        }


        let rowIndex = 0;

        function addLineItems() {
            rowIndex++;
            const newRowId = `row${rowIndex}`;

            const data = `
                <tr class="row-item trClone" id="${newRowId}"
                    onmouseover="showCloseIcon(${rowIndex}, true)"
                    onmouseout="showCloseIcon(${rowIndex}, false)">
                    <td>
                        <textarea type="text" class="w100" tabindex="20" id="itemDesc.${rowIndex}" rows="1" placeholder="Enter item name/description" style="margin: 10px 0px;"></textarea>
                    </td>
                    <td>
                        <input type="text" step="any" class="form-control text-right" style="font-weight: bolder; text-align: center" tabindex="20" placeholder="Unit/Pcs">
                    </td>
                    <td>
                        <input type="number" step="any" class="form-control" style="font-weight: bolder; text-align: center" tabindex="20" placeholder="$100">
                    </td>
                    <td>
                        <input type="number" step="any" class="form-control text-right" style="font-weight: bolder; text-align: center" tabindex="20" placeholder="20">
                    </td>
                    <td>
                        <input type="number" step="any" class="form-control text-right" style="font-weight: bolder; text-align: center" tabindex="20" placeholder="0">
                    </td>
                    <td>
                        <input type="number" step="any" class="form-control text-right" style="font-weight: bolder;" tabindex="20" placeholder="$2000">
                    </td>
                    <td>
                        <span onclick="removeItem('${newRowId}')" class="close-btn" style="cursor:pointer; display:none">❌</span>
                    </td>
                </tr>
            `;

            $('#lineItems').append(data);
        }

        function showCloseIcon(index, show) {
            const row = document.getElementById(`row${index}`);
            const closeBtn = row.querySelector('.close-btn');
            closeBtn.style.display = show ? 'inline' : 'none';
        }

        function removeItem(rowId) {

            console.log('rowId: ', rowId);
            const row = document.getElementById(rowId);
            row.parentNode.removeChild(row);
        }
        function save() {
            $('input:text').each(function () {
                let el = $(this).val();
                if (!el) {
                    // console.log($(this))
                    $(this).toggle()
                }

            })
            $('.hideFromPrint').toggle()
            var element = document.getElementById('section-to-print');
            let invoice_number = $('#invNumber').val() ? $('#invNumber').val() : "Invoice"
            var opt = {
                filename: invoice_number + '.pdf',
                image: {type: 'jpeg', quality: 0.98},
                html2canvas: {scale: 2},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
            };
            html2pdf(element, opt);
            $('.hideFromPrint').toggle()
            $('input:text').each(function () {
                let el = $(this).val();
                if (!el) {
                    // console.log($(this))
                    $(this).toggle()
                }

            })


        }
        // function print() {

        //     window.print();
        //     return;


        //     // $('input:text').each(function () {
        //     //     let el = $(this).val();
        //     //     if (!el) {
        //     //         console.log($(this))
        //     //         $(this).toggle()
        //     //     }

        //     // })

        //     // window.print()
        //     // $('input:text').each(function () {
        //     //     let el = $(this).val();
        //     //     if (!el) {
        //     //         console.log($(this))
        //     //         $(this).toggle()
        //     //     }

        //     // })
        //     // $('input:text[value=""]').show()

        // }



        // const App = {
        //     data() {
        //         return {
        //             discount_type: 'flat',
        //             discount: '0.00',
        //             discountValue: '0.00',
        //             items: [{
        //                 name: 'Apple',
        //                 qnt: '1.00',
        //                 price: '155.00',
        //                 amount: '0.00',
        //                 vat: '0.00',
        //                 total: '0.00',
        //                 showCloseButton: false
        //             }, {
        //                 name: '',
        //                 qnt: '1.00',
        //                 price: '0.00',
        //                 amount: '0.00',
        //                 vat: '0.00',
        //                 total: '0.00',
        //                 showCloseButton: false
        //             }],
        //             company: {
        //                 company: '',
        //                 name: '',
        //                 address1: '',
        //                 address2: '',
        //                 country: ''
        //             },
        //             bill: {
        //                 company: '',
        //                 address1: '',
        //                 address2: '',
        //                 country: ''
        //             }, invoice_date: '', due_date: '',
        //             title: 'INVOICE',
        //             notes: 'It was great doing business with you.',
        //             terms: 'Please make the payment by the due date.'

        //         }
        //     },
        //     watch: {
        //         company: {
        //             handler: function (val, oldVal) {
        //                 localStorage.setItem('company', JSON.stringify(val))
        //             },
        //             deep: true
        //         },
        //         bill: {
        //             handler: function (val, oldVal) {
        //                 localStorage.setItem('bill', JSON.stringify(val))
        //             },
        //             deep: true
        //         },
        //         invoice_date: function (val, oldVal) {
        //             localStorage.setItem('invoice_date', val)

        //         },
        //         due_date: function (val, oldVal) {
        //             localStorage.setItem('due_date', val)

        //         },
        //         'title': function (val, oldVal) {
        //             localStorage.setItem('title', val)
        //             console.log('title: ', title);
        //             console.log(val, oldVal)
        //         },
        //         'notes': function (val, oldVal) {
        //             localStorage.setItem('notes', val)

        //         },
        //         'terms': function (val, oldVal) {
        //             localStorage.setItem('terms', val)

        //         },
        //         'discount_type': function (val, oldVal) {
        //             this.calculateDiscount()
        //         },
        //         'discount': function (val, oldVal) {
        //             this.calculateDiscount()

        //         },
        //         items: {
        //             handler: function (newItems, oldVal) {
        //                 for (let i = 0; i < newItems.length; i++) {
        //                     newItems[i].amount = (newItems[i].qnt * newItems[i].price).toFixed(2)
        //                     let vatAmount = newItems[i].amount * (parseFloat(newItems[i].vat) / 100)
        //                     newItems[i].vatAmount = vatAmount;
        //                     newItems[i].total = (parseFloat(newItems[i].amount) + parseFloat(vatAmount)).toFixed(2);
        //                 }
        //                 this.items = newItems
        //                 this.calculateDiscount()
        //             },
        //             deep: true
        //         },
        //     },
        //     methods: {
        //         showCloseIcon(index, state) {
        //             this.items[index].showCloseButton = state;
        //         },
        //         removeItem(index) {
        //             if (this.items.length <= 1) return;
        //             this.items.splice(index, 1)
        //         },
        //         addItem() {
        //             this.items.push({
        //                 name: '',
        //                 qnt: '1.00',
        //                 price: '0.00',
        //                 amount: '0.00',
        //                 vat: '0.00',
        //                 total: '0.00',
        //                 showCloseButton: false
        //             })
        //         },
        //         print() {
        //             $('input:text').each(function () {
        //                 let el = $(this).val();
        //                 if (!el) {
        //                     console.log($(this))
        //                     $(this).toggle()
        //                 }

        //             })

        //             window.print()
        //             $('input:text').each(function () {
        //                 let el = $(this).val();
        //                 if (!el) {
        //                     console.log($(this))
        //                     $(this).toggle()
        //                 }

        //             })
        //             // $('input:text[value=""]').show()

        //         },
        //         save() {
        //             $('input:text').each(function () {
        //                 let el = $(this).val();
        //                 if (!el) {
        //                     console.log($(this))
        //                     $(this).toggle()
        //                 }

        //             })
        //             $('.hideFromPrint').toggle()
        //             var element = document.getElementById('section-to-print');
        //             let invoice_number = "InvoicePedia"
        //             var opt = {
        //                 filename: invoice_number + '.pdf',
        //                 image: {type: 'jpeg', quality: 0.98},
        //                 html2canvas: {scale: 2},
        //                 jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
        //             };
        //             html2pdf(element, opt);
        //             $('.hideFromPrint').toggle()
        //             $('input:text').each(function () {
        //                 let el = $(this).val();
        //                 if (!el) {
        //                     console.log($(this))
        //                     $(this).toggle()
        //                 }

        //             })


        //         },
        //         calculateDiscount() {
        //             let discount_type = this.discount_type
        //             let discount = this.discount
        //             if (discount_type === "flat") {
        //                 this.discountValue = discount;
        //                 this.total = parseFloat(this.total) + discount;
        //             } else {
        //                 this.discountValue = (parseFloat(this.sub_total) / 100) * discount
        //                 this.total = parseFloat(this.total) + this.discountValue;
        //             }
        //         },
        //         readURL(input) {
        //             input = document.getElementById('logo')
        //             if (input.files && input.files[0]) {
        //                 var reader = new FileReader();

        //                 reader.onload = function (e) {
        //                     $('#blah')
        //                         .attr('src', e.target.result)
        //                         .width(120)
        //                         .height(110);
        //                     localStorage.setItem('logo', $('#blah').attr('src'))
        //                 };

        //                 reader.readAsDataURL(input.files[0]);

        //             }
        //         }
        //     },
        //     computed: {
        //         sub_total() {
        //             let sum = 0;
        //             for (let i = 0; i < this.items.length; i++) {
        //                 sum += (parseFloat(this.items[i].price) * parseFloat(this.items[i].qnt));
        //             }

        //             return sum.toFixed(2);
        //         },
        //         vat() {
        //             let sum = 0;
        //             for (let i = 0; i < this.items.length; i++) {
        //                 sum += parseFloat(this.items[i].vatAmount || '0');
        //             }
        //             return sum.toFixed(2);
        //         },
        //         total() {
        //             return parseFloat(parseFloat(this.sub_total) + parseFloat(this.vat) - parseFloat(this.discountValue)).toFixed(2);
        //         }

        //     },
        //     mounted: function () {
        //         let companyCache = localStorage.getItem('company')
        //         let billCache = localStorage.getItem('bill')
        //         let titleCache = localStorage.getItem('title')
        //         let notesCache = localStorage.getItem('notes')
        //         let logoCache = localStorage.getItem('logo')
        //         let termsCache = localStorage.getItem('terms')
        //         let invoice_dateCache = localStorage.getItem('invoice_date')
        //         let due_dateCache = localStorage.getItem('due_date')
        //         if (companyCache) {
        //             this.company = JSON.parse(companyCache);
        //         }
        //         if (billCache) {
        //             this.bill = JSON.parse(billCache);
        //         }
        //         if (invoice_dateCache) {
        //             this.invoice_date = invoice_dateCache;
        //         }
        //         if (due_dateCache) {
        //             this.invoice_date = due_dateCache;
        //         }
        //         if (titleCache) {
        //             this.title = titleCache;
        //         }
        //         if (notesCache) {
        //             this.notes = notesCache;
        //         }
        //         if (termsCache) {
        //             this.terms = termsCache;
        //         }
        //         if (logoCache) {

        //             $('#blah').attr('src', logoCache)
        //         }
        //     }
        // }

        // Vue.createApp(App).mount('#app')
        $("#invoiceDate").datepicker();
        $('#invoiceDate').datepicker("option", "dateFormat", "M d, yy");
        $("#dueDate").datepicker();
        $('#dueDate').datepicker("option", "dateFormat", "M d, yy");

        $(document).ready(function() {
            elemInvoiceDateLabel = document.getElementById('invoiceDateLabel');
            elemInvoiceDateLabelHidden = document.getElementById('invoiceDateLabelHidden');

            elemInvoiceDateLabel.oninput = function() {
                elemInvoiceDateLabelHidden.innerText = elemInvoiceDateLabel.value;
                elemInvoiceDateLabel.style.width = elemInvoiceDateLabelHidden.clientWidth + 'px';
            }


            elem_invoice_number = document.getElementById('invNumber');
            elem_invoice_number_hidden = document.getElementById('invoice_number_hidden');

            elem_invoice_number.oninput = function() {
                elem_invoice_number_hidden.innerText = elem_invoice_number.value;
                elem_invoice_number.style.width = elem_invoice_number_hidden.clientWidth + 'px';
            }
        })
    </script>
    <script>
        jQuery(function() { // on DOM load

            $('#headline').fallingtextrotator({
                pause: 3000,
                cycles: 2,
                ontextchange: function(msgindex, msg, eachchar) {
                    //console.log(msgindex, msg, eachchar)
                }
            })
        })
    </script>
@endsection
