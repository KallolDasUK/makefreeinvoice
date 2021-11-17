@php($title="Instant Invoice Generator - InvoicePedia")
@extends('landing.layouts.app')


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

                        <div class="row align-items-center justify-content-center">
                            <div class="col pl-4">
                                <button class="btn print mt-4" v-on:click="print" style="width: 150px">Print
                                </button>
                            </div>

                            <div class="col" style="text-align: right" v-on:click="save">
                                <button class="btn save mt-4">Save as PDF</button>

                            </div>
                        </div>

                        <div id="section-to-print" class="bg-white lft-main-div " style="width: 100%"
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
                                       style="height: 30px;margin-left: 10px;"
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

                                                   name="company_country" data-json-node="company_country"
                                                   data-is-array="false"
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


                                                           name="invoice_number_label"
                                                           data-json-node="invoice_number_label"
                                                           data-is-array="false">
                                                </td>
                                                <td>
                                                    <input type="text" class="w100 form-control" id="invNumber"
                                                           tabindex="13"
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
                                                    <input class="w100 form-control" type="text" id="invoiceDate"
                                                           tabindex="15"
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
                                                    <input id="dueDate" class="w100 form-control" tabindex="17"
                                                           type="text"
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
                                               style="text-align: right"
                                               tabindex="6">
                                        <input type="text" id="billingAddress1" class="adr form-control" tabindex="6"
                                               placeholder="Your Client’s Company"
                                               name="customer_name"
                                               v-model="bill.company" style="text-align: right">
                                        <small id="billingAddress1_err" class="text-danger hide">Please fill in your
                                            client’s
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
                                                <input type="text" value="Rate" id="itemRateLabel"
                                                       class="bld w100 text-left"
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
                                                       style="font-weight: bolder;text-align: center"
                                                       v-model="items[index].qnt"
                                                       @blur="items[index].qnt = items[index].qnt.toFixed(2)"

                                                       tabindex="20">
                                            </td>
                                            <td>
                                                <input
                                                    type="number" step="any" class=" form-control "
                                                    style="font-weight: bolder;text-align: center"
                                                    v-model="items[index].price"
                                                    @blur="items[index].price = items[index].price.toFixed(2)"
                                                    tabindex="20">
                                            </td>


                                            <td>
                                                <input type="number" step="any" class=" form-control text-right"
                                                       style="font-weight: bolder;text-align: center"
                                                       :value="items[index].amount"
                                                       readonly
                                                       tabindex="20">
                                            </td>
                                            <td>
                                                <input type="number" step="any" class=" form-control text-right"
                                                       style="font-weight: bolder;text-align: center"
                                                       v-model="items[index].vat"
                                                       @blur="items[index].vat = items[index].vat.toFixed(2)"
                                                       tabindex="20">
                                            </td>
                                            <td>
                                                <input type="number" step="any" class=" form-control text-right"
                                                       style="font-weight: bolder;text-align: center"
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

                                                <div id="add-new-item" class="hideFromPrint">
                                                    <a
                                                        class=" btn btn-outline-primary btn-sm hideFromPrint"
                                                        style="cursor:pointer;margin-left:0px;margin-top: -1px;"
                                                        title="Add Row"
                                                        v-on:click="addItem"><span class="fa fa-plus">&nbsp;</span>Add
                                                        Line Item</a>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Sub Total</td>
                                            <td style="text-align: right">{{ sub_total }}
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>

                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Vat</td>
                                            <td style="text-align: right">{{ vat }}</td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Discount
                                                <select class="hideFromPrint" name="" id="" v-model="discount_type">
                                                    <option value="flat">Flat</option>
                                                    <option value="%">%</option>
                                                </select>
                                            </td>
                                            <td class=" ">

                                                <input type="number"
                                                       v-model="discount"
                                                       step="any"
                                                       style="font-size: 16px;color:black;margin-left:15px;text-align: right"
                                                       class="form-control text-right hideFromPrint" tabindex="20"
                                                       @blur="discount = discount.toFixed(2)"
                                                >
                                                <input type="number"
                                                       readonly
                                                       v-model="discountValue"
                                                       step="any"
                                                       style="font-size: 16px;color:black;margin-left:15px;text-align: right"
                                                       class="form-control text-right " tabindex="20"

                                                >


                                            </td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Total</td>
                                            <td style="text-align: right">{{ total }}</td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Paid</td>
                                            <td style="text-align: right">{{ total }}</td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Due</td>
                                            <td style="text-align: right">0.00</td>

                                        </tr>

                                        </tbody>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div>


                                    <div style="width: 50%;float: left">
                                        <div>
                                            <input class="terms form-control" value="Notes" id="notesLabel"
                                                   tabindex="28"
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
                                            <input class="terms form-control" value="Terms &amp; Conditions"
                                                   id="termsLabel"
                                                   tabindex="30"
                                                   name="terms_and_conditions_label"
                                                   data-json-node="terms_and_conditions_label"
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

                    <h5 class="card-title"><b  style="color: #065a92">Join Now</b>, <b>Why should you log in?</b></h5>


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
                        <li>Save Product to our Database</li>
                        <li>Save Customer to our Database</li>
                        <li>Save your logo and address</li>
                        <li>Use unlimited times</li>
                        <li>Track your invoice</li>
                        <li>Super User Friendly</li>
                        <li>All features are absolutely FREE</li>
                    </ul>


                    <p>&nbsp</p>
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
                        </div> <div class="item">
                            <div class="item-label">
                                All features are absolutely FREE
                            </div>
                        </div>
                    </div>


                    <div>
                        <form class="login-form mt-4" action="{{ route('register') }}" method="post">
                            @csrf
                            @honeypot
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
                                                   style="height:40px;background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
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
                                                   style="height:40px;background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
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
                                                   style="height:40px;background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
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
        </div>
    </div>




@endsection

@section('js')
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"
            integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                    $('input:text').each(function () {
                        let el = $(this).val();
                        if (!el) {
                            console.log($(this))
                            $(this).toggle()
                        }

                    })

                    window.print()
                    $('input:text').each(function () {
                        let el = $(this).val();
                        if (!el) {
                            console.log($(this))
                            $(this).toggle()
                        }

                    })
                    // $('input:text[value=""]').show()

                },
                save() {
                    $('input:text').each(function () {
                        let el = $(this).val();
                        if (!el) {
                            console.log($(this))
                            $(this).toggle()
                        }

                    })
                    $('.hideFromPrint').toggle()
                    var element = document.getElementById('section-to-print');
                    let invoice_number = "InvoicePedia"
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
                            console.log($(this))
                            $(this).toggle()
                        }

                    })


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
    <script>


        jQuery(function(){ // on DOM load

            $('#headline').fallingtextrotator({
                pause: 3000,
                cycles: 2,
                ontextchange:function(msgindex, msg, eachchar){
                    //console.log(msgindex, msg, eachchar)
                }
            })
        })

    </script>
@endsection

