<style>
    table, th, td, tr {
        border: 1px solid black;
        padding: 5px;
    }

    .border-dark {
        border: 0.5px solid #777676 !important;

    }

    .border_bottom {
        border-bottom: 1px dashed black;

    }
</style>
<div id="invoice-container" class="container-fluid invoice-container">


    <table style="margin-top: 200px;font-size: 16px">
        <tr class="text-center">
            <th colspan="5"><h2>Tax Invoice</h2></th>
            <th colspan="5"><h2>فاتورة ضريبية
                </h2></th>
        </tr>
        <tr>
            <td colspan="5" style="height: 200px;width: 50%">
                <p
                    id="supplier_name">
                    <b>Supplier Name</b> :
                    @if($settings->business_name ?? false) {{ $settings->business_name ?? '' }} @endif

                </p>

                <p id="supplier_address"><b>Address</b> : {{ auth()->user()->address??'' }}</p>

                <p id="supplier_vat"><b>Supplier VAT No</b> : {{ $settings->vat_reg??'' }}</p>

                <p id="supplier_vat"><b>Customer Name </b>: {{ $contact_invoice->customer->name }}</p>

                <p id="supplier_vat"><b>Customer Address</b> : {{ $contact_invoice->customer->address }}</p>
                <p id="subject" contenteditable="true"><b>Subject </b> : <span>Bill of</span></p>
                <p id="month" contenteditable="true">
                    <span>Invoice for the month of {{ \Carbon\Carbon::parse($contact_invoice->invoice_date)->monthName }} {{ \Carbon\Carbon::parse($contact_invoice->invoice_date)->year }}</span>
                </p>
            </td>
            <td colspan="5" style="min-height: 200px;text-align: right;direction: rtl;font-weight: bolder">
                <p id="supplier_name_ar" class="border_bottom" contenteditable="true">
                    &nbsp; {{ $settings->supplier_name_ar??'' }} </p>

                <p id="supplier_address_ar" class="border_bottom" contenteditable="true">
                    &nbsp; {{ $settings->supplier_address_ar??'' }}</p>

                <p id="supplier_vat_ar" class="border_bottom" contenteditable="true">
                    &nbsp; {{ $settings->supplier_vat_ar??'' }}</p>

                <p id="customer_name_ar" class="border_bottom"
                   contenteditable="true"> {{ optional($contact_invoice->customer)->customer_name_ar??'' }}</p>

                <p id="customer_address_ar" class="border_bottom"
                   contenteditable="true"> {{ optional($contact_invoice->customer)->customer_address_ar??'' }}</p>
                <p id="subject_ar" class="border_bottom"
                   contenteditable="true">{{ $contact_invoice->subject_ar??'' }}</p>
                <p id="month_ar" class="border_bottom" contenteditable="true">{{ $contact_invoice->month_ar??'' }}</p>

            </td>
        </tr>
        <tr class="text-center">
            <th colspan="5"><span>Invoice No (رقم الفاتورة): <span
                        class="ml-4">{{ $contact_invoice->invoice_number }}</span></span></th>
            <th colspan="5"><span>Date (تاريخ): <span class="ml-4">{{ $contact_invoice->invoice_date }}</span></span>
            </th>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td colspan="5"></td>
        </tr>
        <tr class="text-black font-weight-bold" style="background-color: #ffe699">
            <th>SL No م</th>
            <th>Category <br> الفئة</th>
            <th>Total Workers <br>العدد العمال</th>
            <th>Monthly Cost <br> التكلفة الشهرية</th>
            <th>Daily Cost <br> لتكلفة اليومية</th>
            <th>Working Days <br>عدد أيام العمل</th>
            <th>Total <br>ل االج</th>
            <th>Vat <br>ضريبة</th>
            <th>Total <br>ل االجما يل ا</th>
        </tr>

        @foreach($contact_invoice->invoice_items as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ optional($item->product)->name }}</td>
                <td>{{ $item->workers }}</td>
                <td>{{ $item->monthly_cost }}</td>
                <td>{{ $item->daily_cost }}</td>
                <td>{{ $item->working_days }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ decent_format($item->tax_amount) }}</td>
                <td>{{ decent_format($item->total)   }}</td>
            </tr>
        @endforeach

        <tr class="text-center">
            <td colspan="3">Total Amount Before Tax</td>
            <th colspan="3" style="direction: rtl">ة
                المبلغ قبل الضريبة الإجمالي
            </th>
            <td colspan="3">{{ $contact_invoice->sub_total }}</td>
        </tr>
        <tr class="text-center">
            <td colspan="3">Cash</td>
            <th colspan="3" style="direction: rtl"> نقد
            </th>
            <td colspan="3">{{ $contact_invoice->payment }}</td>
        </tr>
        @foreach($contact_invoice->invoice_extra as $ie )
            @if(!$ie->value)
                @php($ie->value = 0)
            @endif
            <tr class="text-center">
                <td colspan="3">{{ $ie->first }} </td>
                <th colspan="3" style="direction: rtl">
                    {{ $ie->last }}
                </th>
                <td colspan="3"
                    @if(floatval($ie->value)<0) - @endif{{ $contact_invoice->currency }}>{{ decent_format(floatval(abs($ie->value))) }}</td>
            </tr>

        @endforeach

        <tr class="text-center">
            <td colspan="3">Total Before Tax @ 15%</td>
            <th colspan="3" style="direction: rtl">الإجمالي قبل ضريبة 15%
            </th>
            <td colspan="3">{{ $contact_invoice->sub_total }}</td>
        </tr>
        <tr class="text-center">
            <td colspan="3">Value Added Tax @ 15%</td>
            <th colspan="3" style="direction: rtl">15% @ ضريبة القيمة المضافة
            </th>
            <td colspan="3">{{ $contact_invoice->taxable_amount }}</td>
        </tr>
        <tr class="text-center" style="background-color: #ddebf7">
            <td colspan="3">Total</td>
            <th colspan="3" style="direction: rtl">إجمالي
            </th>
            <td colspan="3">{{ $contact_invoice->due }}</td>
        </tr>
        <tr class="text-center">
            <td colspan="9">

                <p><b>{{ $contact_invoice->notes }}</b></p>

            </td>
        </tr>

    </table>
    <div class="row p-4 m-4 align-items-center justify-content-between text-center">
        <div class="col">Regards</div>
        <div class="col font-weight-bolder">شاكرين و مقررين</div>
    </div>
    <div class="row p-4 m-4 align-items-center justify-content-between text-center">
        <div class="col">
            <p><b>Chief Executive Officer المدير لتنفيذي </b></p>
            <p class=" font-weight-bolder">Majed Al Otaibi
                ماجد العتيبي</p></div>
        <div class="col">
            <div id="qr_code" class="mx-auto" style="width: 120px"></div>
        </div>
    </div>


    <!-- Header -->
    <header class="d-none">
        <div class="row align-items-center">
            <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
                @if($settings->business_logo??false)
                    <img
                        class="rounded"
                        src="{{ asset('storage/'.$settings->business_logo) }}"
                        width="100"
                        alt="">
                @endif
            </div>
            <div class="col-sm-5 text-center text-sm-right">
                <h4 class="text-7 mb-0">Bill</h4>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main class="d-none">
        <div class="row">
            <div class="col-sm-6">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($contact_invoice->invoice_date)->format('d M Y') }}
            </div>
            <div class="col-sm-6 text-sm-right"><strong>Bill No:</strong> {{ $contact_invoice->invoice_number }}
            </div>

        </div>
        <hr>
        <div class="row">

            <div class="col-sm-6 order-sm-0"><strong>Vendor:</strong>
                @if($contact_invoice->customer)
                    <address>
                        {{ $contact_invoice->customer->company_name?? $contact_invoice->customer->name??'N/A' }}<br>
                        @if($contact_invoice->customer->street_1)
                            {{ $contact_invoice->customer->street_1??'' }} <br>
                        @endif

                        @if($contact_invoice->customer->street_2)
                            {{ $contact_invoice->customer->street_2??'' }}<br>
                        @endif
                        {{ $contact_invoice->customer->state??'' }} {{ $contact_invoice->customer->zip_post??'' }}
                        @if($contact_invoice->customer->email)
                            <br> {{ $contact_invoice->customer->email??'' }}
                        @endif
                        @if($contact_invoice->customer->phone)
                            <br> {{ $contact_invoice->customer->phone??'' }}
                        @endif
                    </address>
                @else
                    <address>
                        No address / No Client Selected
                    </address>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="card-header">
                        <tr>
                            <td class=" border-0"><strong>SL</strong></td>
                            <td class=" border-0"><strong>Description</strong></td>
                            <td class=" text-center border-0"><strong>Unit</strong></td>

                            <td class=" text-center border-0"><strong>Rate</strong></td>
                            <td class=" text-center border-0"><strong>QTY</strong></td>
                            <td class=" text-right border-0"><strong>Amount</strong></td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($contact_invoice->invoice_items as $item)

                            <tr class="">
                                <td>{{ $loop->iteration }}</td>
                                <td class="">
                                    {{ optional($item->product)->name??'Item Deleted!' }}
                                    @if($item->description)
                                        <br>
                                        <small> {{ $item->description }} </small>
                                    @endif
                                </td>
                                <td class="text-center ">{{ $item->unit }}</td>

                                <td class="text-center">{{ $contact_invoice->currency }}{{ decent_format($item->price) }}</td>
                                <td class="text-center ">X{{ decent_format($item->qnt) }}</td>
                                <td class="text-right">{{ $contact_invoice->currency }}{{ decent_format($item->amount) }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                        <tfoot class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                            <td class="text-right">{{ $contact_invoice->currency }}{{ decent_format($contact_invoice->sub_total) }}</td>
                        </tr>
                        @if($contact_invoice->discount && $contact_invoice->discount != 0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>
                                        Discount @if($contact_invoice->discount_type == '%') {{ $contact_invoice->discount_value }}{{ $contact_invoice->discount_type }} @endif
                                        :
                                    </strong></td>
                                <td class="text-right">
                                    - {{ $contact_invoice->currency }}{{ decent_format($contact_invoice->discount) }}</td>
                            </tr>
                        @endif
                        @if($contact_invoice->shipping_charge && $contact_invoice->shipping_charge!=0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Shipping Charge :</strong></td>
                                <td class="text-right">
                                    @if(floatval($contact_invoice->shipping_charge)<0)
                                        - @endif {{ $contact_invoice->currency }}{{ decent_format($contact_invoice->shipping_charge) }}</td>
                            </tr>
                        @endif
                        @foreach($contact_invoice->invoice_extra as $ie)
                            @if(!$ie->value)
                                @continue
                            @endif
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $ie->name }}:</strong></td>
                                <td class="text-right"> @if(floatval($ie->value)<0)
                                        - @endif{{ $contact_invoice->currency }} {{ decent_format(floatval(abs($ie->value))) }}</td>
                            </tr>
                        @endforeach
                        @foreach($contact_invoice->taxes as $tax)
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $tax['tax_name'] }}:</strong></td>
                                <td class="text-right"> {{ $contact_invoice->currency }}{{ decent_format(floatval($tax['tax_amount'])) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right">
                                <strong>{{ $contact_invoice->currency }}{{ decent_format($contact_invoice->total) }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Paid:</strong></td>
                            <td class="text-right">
                                <strong>{{ $contact_invoice->currency }}{{ decent_format($contact_invoice->payment) }}</strong>
                            </td>
                        </tr>
                        @if($contact_invoice->due>0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Due:</strong></td>
                                <td class="text-right">
                                    <strong>{{ $contact_invoice->currency }}{{ decent_format($contact_invoice->due) }}</strong>
                                </td>
                            </tr>
                        @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->

    <div class=" mt-4 d-none">
        <div class="col">
            <p class=""><strong>Terms & Condition :</strong> <br>
                {{ $contact_invoice->terms_condition }}</p>
            <p class=""><strong>Notes :</strong> <br>
                {{ $contact_invoice->notes }}</p>
        </div>
        <div class="col text-right">
            @foreach($contact_invoice->extra_fields as $ef)
                <p class=""><strong>{{ $ef->name }} :</strong> <br>
                    {{ $ef->value }}</p>
            @endforeach
        </div>
    </div>

</div>
