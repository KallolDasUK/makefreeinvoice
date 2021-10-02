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

<h1>{{ $posSale->pos_number }}</h1>
<table class="table text-center table-sm">
    <tr>
        <th class="text-left">Item</th>
        <th>Price</th>
        <th>Qnt</th>
        <th>Amount</th>
    </tr>
    @foreach($posSale->pos_items as $pos_item )
        <tr>
            <td class="text-left">{{ optional($pos_item->product)->name }}</td>
            <td>{{ $settings->currency??'$' }} {{ $pos_item->price }}</td>
            <td>{{ $pos_item->qnt }}</td>
            <td>{{ $settings->currency??'$' }} {{ $pos_item->price * $pos_item->qnt   }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td>Sub Total</td>
        <td>{{ $settings->currency??'$' }}  {{ $posSale->sub_total }}</td>
    </tr>

    @foreach($posSale->pos_charges as $charge)
        @if($charge->amount == 0)
            @continue
        @endif
        <tr>
            <td></td>
            <td></td>
            <td>{{ $charge->key }}</td>
            <td>{{ $settings->currency??'$' }}  {{ $charge->amount }} @if(str_contains($charge->value,'%'))
                    ({{ $charge->value }}) @endif</td>
        </tr>

    @endforeach

    <tr>

        <td colspan="2">Total</td>
        <td colspan="2" class="text-right"><h3>{{ $settings->currency??'$' }}  {{ $posSale->total }}</h3></td>
    </tr>
    @if($posSale->payment>0)
        <td colspan="2">Paid</td>
        <td colspan="2" class="text-right"><h3>{{ $settings->currency??'$' }}  {{ $posSale->payment }}</h3></td>
    @endif


</table>


