<div id="invoice-container" class="container-fluid invoice-container"  contenteditable="true">

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
                <h4 class="text-7 mb-0">Purchase Return Invoice</h4>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row">
            <div class="col-sm-6">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($purchaseReturn->date)->format('d/m/y') }}</div>
            <div class="col-sm-6 text-sm-right"><strong>Purchase Return No:</strong> {{ $purchaseReturn->bill_number }}
            </div>

        </div>
        <hr>
        <div class="row">

            <div class="col-sm-6 order-sm-0"><strong>Vendor:</strong>
                @if($purchaseReturn->vendor)
                    <address>
                        {{ $purchaseReturn->vendor->company_name?? $purchaseReturn->vendor->name??'N/A' }}<br>
                        @if($purchaseReturn->vendor->street_1)
                            {{ $purchaseReturn->vendor->street_1??'' }} <br>
                        @endif

                        @if($purchaseReturn->vendor->street_2)
                            {{ $purchaseReturn->vendor->street_2??'' }}<br>
                        @endif
                        {{ $purchaseReturn->vendor->state??'' }} {{ $purchaseReturn->vendor->zip_post??'' }}
                        @if($purchaseReturn->vendor->email)
                            <br> {{ $purchaseReturn->vendor->email??'' }}
                        @endif
                        @if($purchaseReturn->vendor->phone)
                            <br> {{ $purchaseReturn->vendor->phone??'' }}
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

                        @foreach($purchaseReturn->bill_items as $item)

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

                                <td class="text-center">{{ $purchaseReturn->currency }}{{ decent_format($item->price) }}</td>
                                <td class="text-center ">X{{ decent_format($item->qnt) }}</td>
                                <td class="text-right">{{ $purchaseReturn->currency }}{{ decent_format($item->amount) }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                        <tfoot class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                            <td class="text-right">{{ $purchaseReturn->currency }}{{ decent_format($purchaseReturn->sub_total) }}</td>
                        </tr>
                        @if($purchaseReturn->discount && $purchaseReturn->discount != 0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>
                                        Discount @if($purchaseReturn->discount_type == '%') {{ $purchaseReturn->discount_value }}{{ $purchaseReturn->discount_type }} @endif
                                        :
                                    </strong></td>
                                <td class="text-right">
                                    - {{ $purchaseReturn->currency }}{{ decent_format($purchaseReturn->discount) }}</td>
                            </tr>
                        @endif
                        @if($purchaseReturn->shipping_charge && $purchaseReturn->shipping_charge!=0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Shipping Charge :</strong></td>
                                <td class="text-right">
                                    @if(floatval($purchaseReturn->shipping_charge)<0)
                                        - @endif {{ $purchaseReturn->currency }}{{ decent_format($purchaseReturn->shipping_charge) }}</td>
                            </tr>
                        @endif
                        @foreach($purchaseReturn->bill_extra as $ie)
                            @if(!$ie->value)
                                @continue
                            @endif
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $ie->name }}:</strong></td>
                                <td class="text-right"> @if(floatval($ie->value)<0)
                                        - @endif{{ $purchaseReturn->currency }} {{ decent_format(floatval(abs($ie->value))) }}</td>
                            </tr>
                        @endforeach
                        @foreach($purchaseReturn->taxes as $tax)
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $tax['tax_name'] }}:</strong></td>
                                <td class="text-right"> {{ $purchaseReturn->currency }}{{ decent_format(floatval($tax['tax_amount'])) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right">
                                <strong>{{ $purchaseReturn->currency }}{{ decent_format($purchaseReturn->total) }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Paid:</strong></td>
                            <td class="text-right">
                                <strong>{{ $purchaseReturn->currency }}{{ decent_format($purchaseReturn->payment) }}</strong>
                            </td>
                        </tr>
                        @if($purchaseReturn->due>0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Due:</strong></td>
                                <td class="text-right">
                                    <strong>{{ $purchaseReturn->currency }}{{ decent_format($purchaseReturn->due) }}</strong>
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
                {{ $purchaseReturn->terms_condition }}</p>
            <p class=""><strong>Notes :</strong> <br>
                {{ $purchaseReturn->notes }}</p>
        </div>
        <div class="col text-right">
            @foreach($purchaseReturn->extra_fields as $ef)
                <p class=""><strong>{{ $ef->name }} :</strong> <br>
                    {{ $ef->value }}</p>
            @endforeach
        </div>
    </div>

</div>
