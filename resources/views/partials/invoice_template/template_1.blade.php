<style>
    table, th, td {
        border: 1px solid black;
    }
</style>

<div id="invoice-container" class="container-fluid invoice-container-template-1" contenteditable="true">
    <div class="header_block border border-dark p-2" style="min-height: 100px">
        <div class="row">
            <div class="col-sm-6 text-sm-right order-sm-1"><strong> From:</strong>
                <address>
                    <b>{{ $settings->business_name??'n/a' }}</b>
                    @if($settings->street_1??'')
                        <br> {{ $settings->street_1??'' }}
                    @endif
                    @if($settings->street_2??'')
                        <br> {{ $settings->street_2??'' }}
                    @endif
                    @if(($settings->state??'') || ($settings->zip_post??'') )
                        <br> {{ $settings->state??'' }} {{ $settings->zip_post??'' }}
                    @endif
                    @if($settings->email??'')
                        <br> {{ $settings->email??'' }}
                    @endif
                    @if($settings->phone??'')
                        <br> {{ $settings->phone??'' }}
                    @endif
                </address>
            </div>
            <div class="col-sm-6 order-sm-0"><strong>To:</strong>
                @if($invoice->customer)
                    <address>
                        <b> {{ $invoice->customer->company_name?? $invoice->customer->name??'N/A' }}</b><br>
                        @if($invoice->customer->street_1)
                            {{ $invoice->customer->street_1??'' }} <br>
                        @endif

                        @if($invoice->customer->street_2)
                            {{ $invoice->customer->street_2??'' }}<br>
                        @endif
                        {{ $invoice->customer->state??'' }} {{ $invoice->customer->zip_post??'' }}
                        @if($invoice->customer->email)
                            <br> {{ $invoice->customer->email??'' }}
                        @endif
                        @if($invoice->customer->phone)
                            <br> {{ $invoice->customer->phone??'' }}
                        @endif
                    </address>
                @else
                    <address>
                        No address / No Client Selected
                    </address>
                @endif
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col"></div>
            <div class="col mb-3 mb-sm-0 text-center">
                {{--                @if($settings->business_logo??false)--}}
                {{--                    <img--}}
                {{--                        class="rounded"--}}
                {{--                        src="{{ asset('storage/'.$settings->business_logo) }}"--}}
                {{--                        width="100"--}}
                {{--                        height="100"--}}
                {{--                        alt="">--}}
                {{--                @endif--}}
                @if($settings->business_name ?? false)
                    <h2 class="mt-2"> {{ $settings->business_name ?? '' }}</h2>
                @endif
                <h3>Invoice</h3>
            </div>
            <div class="col">

            </div>


        </div>
    </div>
    <div class="extra_info_block border border-dark p-2">
        <div class="row align-content-between justify-content-between">
            <div class="col-4  my-2">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</div>
            @if($invoice->due_date)
                <div class="col-4  my-2 ">

                    <strong> Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/y') }}

                </div>
            @endif
            <div class="col-4 my-2"><strong>Invoice No:</strong> {{ $invoice->invoice_number }}
            </div>
            @foreach($invoice->extra_fields as $ef)
                <div class="col-4 my-2">
                    <strong>{{ $ef->name }} :</strong> {{ $ef->value }}

                </div>
            @endforeach

        </div>
    </div>


    <!-- Main Content -->
    <main>

        <hr>


        <div class="card">
            <div class="card-body p-0">
                <div class="">
                    <table class="table mb-0 border border-dark">
                        <thead class="card-header">
                        <tr>
                            <td class=" "><strong>SL</strong></td>
                            <td class=" "><strong>Description</strong></td>
                            <td class=" text-center "><strong>Unit</strong></td>

                            <td class=" text-center  "><strong>Rate</strong></td>
                            <td class=" text-center "><strong>QTY</strong></td>
                            <td class=" text-right "><strong>Amount</strong></td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($invoice->invoice_items as $item)

                            <tr class="">
                                <td>{{ $loop->iteration }}</td>
                                <td class="">
                                    <b>{{ optional($item->product)->name??'Item Deleted!' }}</b>
                                    @if($item->description)
                                        <br>
                                        <small> {{ $item->description }} </small>
                                    @endif
                                </td>
                                <td class="text-center ">{{ $item->unit }}</td>

                                <td class="text-center">{{ $invoice->currency }}{{ decent_format($item->price) }}</td>
                                <td class="text-center ">X{{ decent_format($item->qnt) }}</td>
                                <td class="text-right">{{ $invoice->currency }}{{ decent_format($item->amount) }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                        <tfoot class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                            <td class="text-right">{{ $invoice->currency }}{{ decent_format($invoice->sub_total) }}</td>
                        </tr>
                        @if($invoice->discount && $invoice->discount != 0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>
                                        Discount @if($invoice->discount_type == '%') {{ $invoice->discount_value }}{{ $invoice->discount_type }} @endif
                                        :
                                    </strong></td>
                                <td class="text-right">
                                    - {{ $invoice->currency }}{{ decent_format($invoice->discount) }}</td>
                            </tr>
                        @endif
                        @if($invoice->shipping_charge && $invoice->shipping_charge!=0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Shipping Charge :</strong></td>
                                <td class="text-right">
                                    @if(floatval($invoice->shipping_charge)<0)
                                        - @endif {{ $invoice->currency }}{{ decent_format($invoice->shipping_charge) }}</td>
                            </tr>
                        @endif
                        @foreach($invoice->invoice_extra as $ie )
                            @if(!$ie->value)
                                @continue
                            @endif
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $ie->name }}:</strong></td>
                                <td class="text-right"> @if(floatval($ie->value)<0)
                                        - @endif{{ $invoice->currency }} {{ decent_format(floatval(abs($ie->value))) }}</td>
                            </tr>
                        @endforeach
                        @foreach($invoice->taxes as $tax)
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $tax['tax_name'] }}:</strong></td>
                                <td class="text-right"> {{ $invoice->currency }}{{ decent_format(floatval($tax['tax_amount'])) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right">
                                <strong>{{ $invoice->currency }}{{ decent_format($invoice->total) }}</strong>
                            </td>
                        </tr>
                        @if($invoice->payment>0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Paid:</strong></td>
                                <td class="text-right">
                                    <strong>{{ $invoice->currency }}{{ decent_format($invoice->payment) }}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($invoice->due > 0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Due:</strong></td>
                                <td class="text-right">
                                    <strong>{{ $invoice->currency }}{{ decent_format($invoice->due) }}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($invoice->previous_due>0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Previous Due:</strong></td>
                                <td class="text-right">
                                    <strong>{{ $invoice->currency }}{{ decent_format($invoice->previous_due) }}</strong>
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
    <div class="footer_block d-flex">
        <div class="flex-1 mt-4" style="width: 100%">

            <p class="border border-dark p-2"><strong>Terms & Condition :</strong> <br>
                {{ $invoice->terms_condition }}</p>
            <p class="border border-dark p-2"><strong>Notes :</strong> <br>
                {{ $invoice->notes }}</p>
        </div>
        <div class="flex-1 mt-4 ml-4 mb-4" >
            <div id="qr_code">

            </div>
        </div>
    </div>


    <div class="d-flex">
        <div class="col border border-dark  p-2 mr-4">
            <p class=""><strong>Client Signature :</strong> <br>
            </p>
        </div>
        <div class="col border border-dark p-2">
            <p class=""><strong>Authorized Signature :</strong> <br>
            </p>
        </div>
    </div>
</div>


