<div id="invoice-container" class="container-fluid invoice-container">

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
                <h4 class="text-7 mb-0">Bill</h4>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row">
            <div class="col-sm-6">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($bill->date)->format('d/m/y') }}</div>
            <div class="col-sm-6 text-sm-right"><strong>Bill No:</strong> {{ $bill->bill_number }}
            </div>

        </div>
        <hr>
        <div class="row">

            <div class="col-sm-6 order-sm-0"><strong>Vendor:</strong>
                @if($bill->vendor)
                    <address>
                        {{ $bill->vendor->company_name?? $bill->vendor->name??'N/A' }}<br>
                        @if($bill->vendor->street_1)
                            {{ $bill->vendor->street_1??'' }} <br>
                        @endif

                        @if($bill->vendor->street_2)
                            {{ $bill->vendor->street_2??'' }}<br>
                        @endif
                        {{ $bill->vendor->state??'' }} {{ $bill->vendor->zip_post??'' }}
                        @if($bill->vendor->email)
                            <br> {{ $bill->vendor->email??'' }}
                        @endif
                        @if($bill->vendor->phone)
                            <br> {{ $bill->vendor->phone??'' }}
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

                        @foreach($bill->bill_items as $item)

                            <tr class="">
                                <td>{{ $loop->iteration }}</td>
                                <td class="">
                                    {{ $item->product->name }}
                                    @if($item->description)
                                        <br>
                                        <small> {{ $item->description }} </small>
                                    @endif
                                </td>
                                <td class="text-center ">{{ $item->unit }}</td>

                                <td class="text-center">{{ $bill->currency }}{{ decent_format($item->price) }}</td>
                                <td class="text-center ">X{{ decent_format($item->qnt) }}</td>
                                <td class="text-right">{{ $bill->currency }}{{ decent_format($item->amount) }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                        <tfoot class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                            <td class="text-right">{{ $bill->currency }}{{ decent_format($bill->sub_total) }}</td>
                        </tr>
                        @if($bill->discount && $bill->discount != 0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>
                                        Discount @if($bill->discount_type == '%') {{ $bill->discount_value }}{{ $bill->discount_type }} @endif
                                        :
                                    </strong></td>
                                <td class="text-right">
                                    - {{ $bill->currency }}{{ decent_format($bill->discount) }}</td>
                            </tr>
                        @endif
                        @if($bill->shipping_charge && $bill->shipping_charge!=0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Shipping Charge :</strong></td>
                                <td class="text-right">
                                    @if(floatval($bill->shipping_charge)<0)
                                        - @endif {{ $bill->currency }}{{ decent_format($bill->shipping_charge) }}</td>
                            </tr>
                        @endif
                        @foreach($bill->bill_extra as $ie)
                            @if(!$ie->value)
                                @continue
                            @endif
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $ie->name }}:</strong></td>
                                <td class="text-right"> @if(floatval($ie->value)<0)
                                        - @endif{{ $bill->currency }} {{ decent_format(floatval(abs($ie->value))) }}</td>
                            </tr>
                        @endforeach
                        @foreach($bill->taxes as $tax)
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $tax['tax_name'] }}:</strong></td>
                                <td class="text-right"> {{ $bill->currency }}{{ decent_format(floatval($tax['tax_amount'])) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right">
                                <strong>{{ $bill->currency }}{{ decent_format($bill->total) }}</strong>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->

    <div class="row mt-4">
        <div class="col">
            <p class="text-1"><strong>Terms & Condition :</strong> <br>
                {{ $bill->terms_condition }}</p>
            <p class="text-1"><strong>Notes :</strong> <br>
                {{ $bill->notes }}</p>
        </div>
        <div class="col text-right">
            @foreach($bill->extra_fields as $ef)
                <p class="text-1"><strong>{{ $ef->name }} :</strong> <br>
                    {{ $ef->value }}</p>
            @endforeach
        </div>
    </div>

</div>
