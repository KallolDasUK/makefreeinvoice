<div class="row align-items-end">
    <div class="col">
        <div>
            @if($settings->business_logo??false)
                <img
                    class="rounded mb-4"
                    src="{{ asset('storage/'.$settings->business_logo) }}"
                    width="100"
                    height="100"
                    alt="">

            @endif
            <h2>{{ $settings->business_name??'n/a' }}</h2>
            @if($settings->street_1??'')
                <br> {{ $settings->street_1??'' }}
            @endif
            @if($settings->street_2??'')
                , {{ $settings->street_2??'' }}
            @endif
            @if(($settings->state??'') || ($settings->zip_post??'') )
                , {{ $settings->state??'' }} {{ $settings->zip_post??'' }}
            @endif
            @if($settings->email??'')
                <br> {{ $settings->email??'' }}
            @endif
            @if($settings->phone??'')
                <br> {{ $settings->phone??'' }}
            @endif

        </div>
    </div>
    <div class="col align-self-center">
        <h1>Money Receipt</h1>

    </div>
    <div class="col align-self-center">

        <p class="float-right">{{ \Carbon\Carbon::parse($rp->payment_date)->format('d M Y') }}</p>
        <div class="customer-information">
            @if($rp->customer)
                <u>Customer</u> <br>
                <span>
                    <b>{{ $rp->customer->company_name.' '. $rp->customer->name??'N/A' }}</b><br>
                    @if($rp->customer->street_1)
                        {{ $rp->customer->street_1??'' }}
                    @endif

                    @if($rp->customer->street_2)
                        , {{ $rp->customer->street_2??'' }}<br>
                    @endif
                    {{ $rp->customer->state??'' }} {{ $rp->customer->zip_post??'' }}
                    @if($rp->customer->email)
                        <br> {{ $rp->customer->email??'' }}
                    @endif
                    @if($rp->customer->phone)
                        <br> {{ $rp->customer->phone??'' }}
                    @endif
                </span>
            @else
                <address>
                    No address / No Client Selected
                </address>
            @endif
        </div>
        <h3 class="float-left">#{{ $rp->payment_sl}}</h3>
        <h3 class="float-right"><b>{{ decent_format_dash_if_zero($rp->amount) }}</b></h3>
        <div class="clearfix"></div>
    </div>
</div>

<hr>
<div>

</div>


<table class="table " style="color: black">
    <tr>
        <th>SL</th>
        <th class="text-left">Invoice</th>
        <th>Payment By</th>
        <th>Amount</th>
    </tr>
    @if($rp->previous_due>0)
        <tr>
            <td>1</td>
            <td class="text-left">Previous Due Payment</td>
            <td>{{ optional($rp->ledger)->ledger_name }}</td>
            <td>{{ decent_format_dash_if_zero($rp->previous_due)}}</td>
        </tr>

    @endif
    @foreach($rp->items as $item)
        <tr>
            @if($rp->previous_due>0)
                <td>{{ $loop->iteration + 1 }}</td>
            @else
                <td>{{ $loop->iteration }}</td>
            @endif

            <td class="text-left">{{ optional($item->invoice)->invoice_number }}</td>
            <td>{{ optional($rp->ledger)->ledger_name }}</td>
            <td>{{ decent_format_dash_if_zero($item->amount)}}</td>
        </tr>

    @endforeach
    <tr>
        <td></td>
        <td class="text-left"></td>
        <td><b>Total</b></td>
        <td><b>{{ decent_format_dash_if_zero($rp->amount)}}</b></td>
    </tr>

    @if($rp->customer->receivables>0)
        <tr>
            <td></td>
            <td class="text-left"></td>
            <td><b>Current Due</b></td>
            <td><b>{{ decent_format_dash_if_zero($rp->customer->receivables)}}</b></td>
        </tr>

    @endif

</table>

<table>

</table>
<br>
<br>
Validated By  <input type="text" placeholder="" class="ml-4">
<hr>
Total in word :
<span> <b>{{ (new NumberFormatter("en", NumberFormatter::SPELLOUT))->format($rp->amount) }}</b> </span>
<br>
@if(!optional(auth()->user())->subscribed('default'))
    <p class="float-right mt-4">Generated on {{ \Carbon\Carbon::parse($rp->payment_date)->format('d M Y') }} by
        invoicepedia.com</p>
@endif


