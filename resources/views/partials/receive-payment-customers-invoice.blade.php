@foreach($invoices as $invoice)
    <tr>
        <td> {{ $invoice->invoice_date }} <br>


        </td>
        <td><a target="_blank"
               href="{{ route('invoices.invoice.show',$invoice->id) }}">{{ $invoice->invoice_number }}</a></td>
        <td> {{ $invoice->due_date??'-' }} </td>


        <td class="text-right"> {{ $invoice->total }} </td>
        <td class="text-right"> {{ $invoice->due }} </td>
        <td class="text-right" style="width:16%; position: relative;">
            <input name="payment[]"
                   invoice_id="{{ $invoice->id }}"
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
