<div class="text-center">

    <span style="font-size: 20px">{{ $settings->business_name??'n/a' }}</span>
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

</div>

<div>
    <p class="float-right">{{ \Carbon\Carbon::parse($rp->payment_date)->format('d M Y') }}</p>
    <div class="customer-information">
        @if($rp->customer)
            <u>Customer</u> <br>
            <address>
                <b>{{ $rp->customer->company_name.' '. $rp->customer->name??'N/A' }}</b><br>
                @if($rp->customer->street_1)
                    {{ $rp->customer->street_1??'' }} <br>
                @endif

                @if($rp->customer->street_2)
                    {{ $rp->customer->street_2??'' }}<br>
                @endif
                {{ $rp->customer->state??'' }} {{ $rp->customer->zip_post??'' }}
                @if($rp->customer->email)
                    <br> {{ $rp->customer->email??'' }}
                @endif
                @if($rp->customer->phone)
                    <br> {{ $rp->customer->phone??'' }}
                @endif
            </address>
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


<table class="table text-center table-sm table-bordered" style="color: black">
    <tr>
        <th class="text-left">Invoice</th>
        <th>Payment By</th>
        <th>Amount</th>
    </tr>

    @foreach($rp->items as $item)
        <tr>
            <td class="text-left">{{ optional($item->invoice)->invoice_number }}</td>
            <td>{{ optional($rp->ledger)->ledger_name }}</td>
            <td>{{ decent_format_dash_if_zero($item->amount)}}</td>
        </tr>

    @endforeach


</table>
Total in word :
<span> <b>{{ (new NumberFormatter("en", NumberFormatter::SPELLOUT))->format($rp->amount) }}</b> </span>
<br>
@if(!optional(auth()->user())->subscribed('default'))
    <p class="float-right mt-4">Generated on {{ \Carbon\Carbon::parse($rp->payment_date)->format('d M Y') }} by
        invoicepedia.com</p>
@endif


