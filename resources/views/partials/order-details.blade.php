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
    <p class="float-right">{{ \Carbon\Carbon::parse($posSale->date)->format('d M Y') }}</p>
    <div class="customer-information">
        @if($posSale->customer)
            <u>Customer</u> <br>
            <address>
                <b>{{ $posSale->customer->company_name?? $posSale->customer->name??'N/A' }}</b><br>
                @if($posSale->customer->street_1)
                    {{ $posSale->customer->street_1??'' }} <br>
                @endif

                @if($posSale->customer->street_2)
                    {{ $posSale->customer->street_2??'' }}<br>
                @endif
                {{ $posSale->customer->state??'' }} {{ $posSale->customer->zip_post??'' }}
                @if($posSale->customer->email)
                    <br> {{ $posSale->customer->email??'' }}
                @endif
                @if($posSale->customer->phone)
                    <br> {{ $posSale->customer->phone??'' }}
                @endif
            </address>
        @else
            <address>
                No address / No Client Selected
            </address>
        @endif
    </div>
    <h3 class="float-left">#{{ $posSale->pos_number }}</h3>
    <h3 class="float-right"><b>{{ decent_format_dash_if_zero($posSale->total) }}</b></h3>
    <div class="clearfix"></div>
</div>


<table class="table text-center table-sm table-bordered" style="color: black">
    <tr>
        <th class="text-left">Item</th>
        <th>Price</th>
        <th>Qnt</th>
        <th>Amount</th>
    </tr>
    @foreach($posSale->pos_items as $pos_item )
        <tr>
            <td class="text-left">{{ optional($pos_item->product)->name }}</td>
            <td>{{ decent_format_dash_if_zero($pos_item->price) }}</td>
            <td><small>X</small>{{ decent_format($pos_item->qnt) }}</td>
            <td> {{ decent_format_dash_if_zero($pos_item->price * $pos_item->qnt)   }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>

        <td colspan="2">Sub Total</td>
        <td> {{ decent_format_dash_if_zero($posSale->sub_total) }}</td>
    </tr>

    @foreach($posSale->pos_charges as $charge)
        @if($charge->amount == 0)
            @continue
        @endif
        <tr>
            <td></td>
            <td colspan="2">{{ $charge->key }}</td>
            <td> {{ decent_format_dash_if_zero($charge->amount) }} @if(str_contains($charge->value,'%'))
                    ({{ $charge->value }}) @endif</td>
        </tr>

    @endforeach

    <tr>
        <td></td>
        <td colspan="2">Total</td>
        <td>  {{ decent_format_dash_if_zero($posSale->total) }}</td>
    </tr>
    @if($posSale->payment>0)
        <tr>


        <td></td>
        <td colspan="2">Paid</td>
        <td> {{ decent_format_dash_if_zero($posSale->payment) }}</td></tr>
    @endif
    @if($posSale->due>0)
        <tr>


        <td></td>
        <td colspan="2">Due</td>
        <td> {{ decent_format_dash_if_zero($posSale->due) }}</td> </tr>
    @endif


</table>
Total in word :
<span> <b>{{ (new NumberFormatter("en", NumberFormatter::SPELLOUT))->format($posSale->total) }}</b> </span>
<br>
@if(!optional(auth()->user())->subscribed('default'))
    <p class="float-right mt-4">Generated on {{ \Carbon\Carbon::parse($posSale->date)->format('d M Y') }} by invoicepedia.com</p>
@endif


