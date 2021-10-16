<div id="invoice-container" class="container-fluid invoice-container" contenteditable="true">

    <!-- Header -->
    <header>
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
                <h4 class="text-7 mb-0">Purchase Order</h4>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row">
            <div class="col-sm-4">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($purchase_order->purchase_order_date)->format('d/m/y') }}
            </div>
            <div class="col-sm-4">
                <strong>Delivery
                    Date:</strong> {{ \Carbon\Carbon::parse($purchase_order->delivery_date)->format('d/m/y') }}
            </div>
            <div class="col-sm-4 text-sm-right"><strong>Order No:</strong> {{ $purchase_order->purchase_order_number }}
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 text-sm-right order-sm-1"><strong>Client</strong>
                <address>
                    {{ $settings->business_name??'n/a' }}
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
            <div class="col-sm-6 order-sm-0"><strong>Vendor:</strong>
                @if($purchase_order->vendor)
                    <address>
                        {{ $purchase_order->vendor->company_name?? $purchase_order->vendor->name??'N/A' }}<br>
                        @if($purchase_order->vendor->street_1)
                            {{ $purchase_order->vendor->street_1??'' }} <br>
                        @endif

                        @if($purchase_order->vendor->street_2)
                            {{ $purchase_order->vendor->street_2??'' }}<br>
                        @endif
                        {{ $purchase_order->vendor->state??'' }} {{ $purchase_order->vendor->zip_post??'' }}
                        @if($purchase_order->vendor->email)
                            <br> {{ $purchase_order->vendor->email??'' }}
                        @endif
                        @if($purchase_order->vendor->phone)
                            <br> {{ $purchase_order->vendor->phone??'' }}
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

                        @foreach($purchase_order->purchase_order_items as $item)

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

                                <td class="text-center">{{ $purchase_order->currency }}{{ decent_format($item->price) }}</td>
                                <td class="text-center ">X{{ decent_format($item->qnt) }}</td>
                                <td class="text-right">{{ $purchase_order->currency }}{{ decent_format($item->amount) }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                        <tfoot class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                            <td class="text-right">{{ $purchase_order->currency }}{{ decent_format($purchase_order->sub_total) }}</td>
                        </tr>
                        @if($purchase_order->discount && $purchase_order->discount != 0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>
                                        Discount @if($purchase_order->discount_type == '%') {{ $purchase_order->discount_value }}{{ $purchase_order->discount_type }} @endif
                                        :
                                    </strong></td>
                                <td class="text-right">
                                    - {{ $purchase_order->currency }}{{ decent_format($purchase_order->discount) }}</td>
                            </tr>
                        @endif
                        @if($purchase_order->shipping_charge && $purchase_order->shipping_charge!=0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Shipping Charge :</strong></td>
                                <td class="text-right">
                                    @if(floatval($purchase_order->shipping_charge)<0)
                                        - @endif {{ $purchase_order->currency }}{{ decent_format($purchase_order->shipping_charge) }}</td>
                            </tr>
                        @endif
                        @foreach($purchase_order->purchase_order_extra as $ie)
                            @if(!$ie->value)
                                @continue
                            @endif
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $ie->name }}:</strong></td>
                                <td class="text-right"> @if(floatval($ie->value)<0)
                                        - @endif{{ $purchase_order->currency }} {{ decent_format(floatval(abs($ie->value))) }}</td>
                            </tr>
                        @endforeach
                        @foreach($purchase_order->taxes as $tax)
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $tax['tax_name'] }}:</strong></td>
                                <td class="text-right"> {{ $purchase_order->currency }}{{ decent_format(floatval($tax['tax_amount'])) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right">
                                <strong>{{ $purchase_order->currency }}{{ decent_format($purchase_order->total) }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Paid:</strong></td>
                            <td class="text-right">
                                <strong>{{ $purchase_order->currency }}{{ decent_format($purchase_order->payment) }}</strong>
                            </td>
                        </tr>
                        @if($purchase_order->due>0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Due:</strong></td>
                                <td class="text-right">
                                    <strong>{{ $purchase_order->currency }}{{ decent_format($purchase_order->due) }}</strong>
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

    <div class="row mt-4">
        <div class="col">
            <p class=""><strong>Terms & Condition :</strong> <br>
                {{ $purchase_order->terms_condition }}</p>
            <p class=""><strong>Notes :</strong> <br>
                {{ $purchase_order->notes }}</p>
        </div>
        <div class="col text-right">
            @foreach($purchase_order->extra_fields as $ef)
                <p class=""><strong>{{ $ef->name }} :</strong> <br>
                    {{ $ef->value }}</p>
            @endforeach
        </div>
    </div>

</div>
