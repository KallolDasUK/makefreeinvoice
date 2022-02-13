@if($vendor->previous_due>0)
    <tr>
        <td colspan="4" style="padding-top: 0px;"></td>
        <td colspan="1" class="text-right">Previous Due</td>
        <td colspan="1" class="text-right">{{ $vendor->previous_due }}</td>
        <td class="text-right">
            <input type="number" step="any" name="previous_due" class="form-control paymentAmount text-right"
                   due="{{ $vendor->previous_due }}"
                   max="{{ $vendor->previous_due }}"
                   id="previous_due"/></td>
    </tr>

@endif


@foreach($bills as $bill)
    <tr>
        <td> {{ $bill->bill_date }} <br>


        </td>
        <td><a target="_blank"
               href="{{ route('bills.bill.show',$bill->id) }}">{{ $bill->bill_number }}</a></td>
        <td> {{ $bill->due_date??'-' }} </td>


        <td class="text-right"> {{ $bill->total }} </td>
        <td class="text-right text-danger"> {{ $bill->purchase_return_amount }} </td>

        <td class="text-right"> {{ $bill->due }} </td>
        <td class="text-right" style="width:16%; position: relative;">
            <input name="payment[]"
                   bill_id="{{ $bill->id }}"
                   class="paymentAmount text-right form-control"
                   step="any"
                   due="{{ $bill->due }}"
                   max="{{ $bill->due }}"
                   type="number"/>
        </td>
    </tr>
@endforeach
<tr>
    <td colspan="4" style="padding-top: 0px;"></td>
    <td colspan="2" class="text-right">Total</td>
    <td class="text-right">
        <input type="number" step="any" name="totalAmount" class="form-control text-right" readonly
                                  style="cursor: no-drop"
                                  id="totalAmount"/></td>
</tr>
