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
                <h4 class="text-7 mb-0">Estimate</h4>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row">
            <div class="col-sm-4">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($estimate->date)->format('d/m/y') }}


            </div>
            <div class="col-sm-4 text-center">
                @if($estimate->due_date)
                    <strong> Expires On:</strong> {{ \Carbon\Carbon::parse($estimate->due_date)->format('d/m/y') }}
                @endif
            </div>
            <div class="col-sm-4 text-sm-right"><strong>Estimate No:</strong> {{ $estimate->estimate_number }}
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 text-sm-right order-sm-1"><strong> From:</strong>
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
            <div class="col-sm-6 order-sm-0"><strong>To:</strong>
                @if($estimate->customer)
                    <address>
                        {{ $estimate->customer->company_name?? $estimate->customer->name??'N/A' }}<br>
                        @if($estimate->customer->street_1)
                            {{ $estimate->customer->street_1??'' }} <br>
                        @endif

                        @if($estimate->customer->street_2)
                            {{ $estimate->customer->street_2??'' }}<br>
                        @endif
                        {{ $estimate->customer->state??'' }} {{ $estimate->customer->zip_post??'' }}
                        @if($estimate->customer->email)
                            <br> {{ $estimate->customer->email??'' }}
                        @endif
                        @if($estimate->customer->phone)
                            <br> {{ $estimate->customer->phone??'' }}
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

                        @foreach($estimate->estimate_items as $item)

                            <tr class="">
                                <td>{{ $loop->iteration }}</td>
                                <td class="">
                                    {{ optional($item->product)->name??'Item Deleted!' }}
                                    @if($item->description)
                                        <br>
                                        <small> {{ $item->description }} </small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->unit }}</td>
                                <td class="text-center">{{ $estimate->currency }}{{ decent_format($item->price) }}</td>
                                <td class="text-center ">X{{ decent_format($item->qnt) }}</td>
                                <td class="text-right">{{ $estimate->currency }}{{ decent_format($item->amount) }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                        <tfoot class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Sub Total:</strong></td>
                            <td class="text-right">{{ $estimate->currency }}{{ decent_format($estimate->sub_total) }}</td>
                        </tr>
                        @if($estimate->discount && $estimate->discount != 0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>
                                        Discount @if($estimate->discount_type == '%') {{ $estimate->discount_value }}{{ $estimate->discount_type }} @endif
                                        :
                                    </strong></td>
                                <td class="text-right">
                                    - {{ $estimate->currency }}{{ decent_format($estimate->discount) }}</td>
                            </tr>
                        @endif
                        @if($estimate->shipping_charge && $estimate->shipping_charge!=0)
                            <tr>
                                <td colspan="5" class="text-right"><strong>Shipping Charge :</strong></td>
                                <td class="text-right">
                                    @if(floatval($estimate->shipping_charge)<0)
                                        - @endif {{ $estimate->currency }}{{ decent_format($estimate->shipping_charge) }}</td>
                            </tr>
                        @endif
                        @foreach($estimate->estimate_extra as $ie )
                            @if(!$ie->value)
                                @continue
                            @endif
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $ie->name }}:</strong></td>
                                <td class="text-right"> @if(floatval($ie->value)<0)
                                        - @endif{{ $estimate->currency }}{{ decent_format(floatval($ie->value)) }}</td>
                            </tr>
                        @endforeach

                        @foreach($estimate->taxes as $tax)
                            <tr>
                                <td colspan="5" class="text-right"><strong>{{ $tax['tax_name'] }}:</strong></td>
                                <td class="text-right"> {{ $estimate->currency }}{{ decent_format(floatval($tax['tax_amount'])) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right">
                                <strong>{{ $estimate->currency }}{{ decent_format($estimate->total) }}</strong>
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
            <p class=""><strong>Terms & Condition :</strong> <br>
                {{ $estimate->terms_condition }}</p>
            <p class=""><strong>Notes :</strong> <br>
                {{ $estimate->notes }}</p>
        </div>
        <div class="col text-right">
            @foreach($estimate->extra_fields as $ef)
                <p class=""><strong>{{ $ef->name }} :</strong> <br>
                    {{ $ef->value }}</p>
            @endforeach
        </div>
    </div>

</div>
