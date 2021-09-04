@foreach($bills as $bill)
    <tr>
        <td> {{ $bill->bill_date }} <br>


        </td>
        <td><a target="_blank"
               href="{{ route('bills.bill.show',$bill->id) }}">{{ $bill->bill_number }}</a></td>
        <td> {{ $bill->due_date??'-' }} </td>


        <td class="text-right"> {{ $bill->total }} </td>
        <td class="text-right"> {{ $bill->due }} </td>
        <td class="text-right" style="width:16%; position: relative;">
            <input name="payment[]"
                   bill_id="{{ $bill->id }}"
                   class="paymentAmount text-right form-control"
                   step="any"
                   type="number"/>
        </td>
    </tr>
@endforeach
<tr>
    <td colspan="3" style="padding-top: 0px;"></td>
    <td colspan="2" class="text-right">Total</td>
    <td class="text-right"><input type="text" name="totalAmount" class="form-control" readonly style="cursor: no-drop"
                                  id="totalAmount"/></td>
</tr>
