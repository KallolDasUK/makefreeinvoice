<div id="invoice-container" class="container-fluid invoice-container" contenteditable="true">


    <header>
        <div class="row align-items-center">
            <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
                @if($settings->business_logo??false)
                    <img
                        class="rounded"
                        src="{{ asset('storage/'.$settings->business_logo) }}"
                        width="100"
                        height="100"
                        alt="">
                @endif
                @if($settings->business_name ?? false)
                    <h3 class="mt-2"> {{ $settings->business_name ?? '' }}</h3>
                @endif
            </div>
            <div class="col-sm-5 text-center text-sm-right">
                <h1 >Invoice</h1>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row">
            <div class="col-sm-4">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</div>

            <div class="col-sm-4 text-center">
                @if($invoice->due_date)
                    <strong> Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/y') }}
                @endif
            </div>
            <div class="col-sm-4 text-sm-right"><strong>Invoice No:</strong> {{ $invoice->invoice_number }}
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
                @if($invoice->customer)
                    <address>
                        {{ $invoice->customer->company_name?? $invoice->customer->name??'N/A' }}<br>
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

                        @foreach($invoice->invoice_items as $item)

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

    <div class="row mt-4">
        <div class="col">
            <p><strong>Terms & Condition :</strong> <br>
                {{ $invoice->terms_condition }}</p>
            <p><strong>Notes :</strong> <br>
                {{ $invoice->notes }}</p>
        </div>
        <div class="col text-right">
            @foreach($invoice->extra_fields as $ef)
                <p><strong>{{ $ef->name }} :</strong> <br>
                    {{ $ef->value }}</p>
            @endforeach
        </div>
    </div>

</div>
