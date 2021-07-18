@foreach($invoices as $invoice)
    <tr>
        <td> {{ $invoice->invoice_date }} <br>
            @if($invoice->due_date)
                <small> <span class="text-muted">Due Date</span>: {{ $invoice->due_date }} </small>
            @endif

        </td>
        <td> {{ $invoice->invoice_number }} </td>
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
    <td colspan="2" style="padding-top: 0px;"></td>
    <td colspan="2" class="text-right">Total</td>
    <td class="text-right"><input type="text" name="totalAmount" class="form-control" style="cursor: no-drop" id="totalAmount"/></td>
</tr>
