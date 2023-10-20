<div id="delivery-container" class="container-fluid invoice-container" contenteditable="true">


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
                <h1>Delivery Note</h1>
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
            <div class="col "><strong>To:</strong>
                @if($invoice->customer)
                    <address>
                        {{ $invoice->customer->company_name?? $invoice->customer->name??'N/A' }}<br>
                        @if($invoice->customer->street_1)
                            {{ $invoice->customer->street_1??'' }} <br>
                        @endif

                        @if($invoice->customer->street_2)
                            {{ $invoice->customer->street_2??'' }}<br>
                        @endif
                        {{ $invoice->customer->state??'' }} {{ $invoice->customer->city??'' }} {{ $invoice->customer->zip_post??'' }} {{ $invoice->customer->country??'' }}
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

            <div class="col align-self-center text-center">
                @foreach($invoice->extra_fields as $ef)

                    @if($ef->name == "")
                        @continue
                    @endif
                    <p><strong>{{ $ef->name }} :</strong> <br>
                        {{ $ef->value }}</p>
                @endforeach
            </div>
            <div class="col text-sm-right "><strong> From:</strong>
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
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 table-sm" style="table-layout: fixed">
                        <thead class="card-header">
                        <tr>
                            <td class=" " width="30"><strong>SL</strong></td>
                            <td class=" "><strong>Description</strong></td>
                            <td class=" text-center " width="80"><strong>Unit</strong></td>

                            <td class=" text-center " width="120"><strong>QTY</strong></td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($invoice->invoice_items as $item)

                            <tr class="">
                                <td>{{ $loop->iteration }}</td>
                                <td class="" style="width: 200px!important;">
                                    <span>
                                           {{ optional($item->product)->name??'Item Deleted!' }}
                                    </span>

                                    @if($item->description)
                                        <br>
                                        <small> {{ $item->description }} </small>
                                    @endif
                                </td>
                                <td class="text-center ">{{ $item->unit }}</td>

                                <td class="text-center ">X{{ decent_format($item->qnt) }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->

    <div class="row mt-4 justify-content-center align-items-center">
        <div class="col ">
            @if($invoice->terms_condition)
                <p><strong>Terms & Condition :</strong> <br>
                    {{ $invoice->terms_condition }}</p>
            @endif
            @if($invoice->notes)
                <p><strong>Notes :</strong> <br>
                    {{ $invoice->notes }}</p>
            @endif
        </div>




    </div>

    <div class=" " style="margin-top: 50px;position:relative;">
        <div class="row ">
            <div class="col">

            </div>
            <div class="col">
                <hr>
                <p class="text-right"><b>Authorized Signature</b></p>
            </div>
        </div>
        <table id="delivery_note" class="delivery_note table table-borderless" style="width: 100%;">
            <th>
                <tr>
                    <td class="p-l-0"><strong>Goods Received By</strong></td>


                </tr>
                <tr>
                    <td class="p-l-0">
                        <div style="width: 400px" class="d-flex align-content-between justify-content-between">
                            <p>
                                Name:
                            </p>
                            <p>
                                Date:
                            </p>
                        </div>
                    </td>


                </tr>
                <tr>
                    <td class="p-l-0">
                        Signature _____________________
                    </td>


                </tr>
            </th>
        </table>


    </div>


</div>


<style>
    .p-l-0 {
        padding-left: 0 !important;
    }
</style>
