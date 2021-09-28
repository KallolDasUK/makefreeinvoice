<h1>{{ $posSale->pos_number }}</h1>
<table class="table text-center">
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
        <td> {{ $posSale->sub_total }}</td>
    </tr> <tr>
        <td></td>
        <td></td>
        <td><h3>Total</h3></td>
        <td><h3> {{ $posSale->total }}</h3></td>
    </tr>
</table>


