@if($customer->previous_due>0)
    <tr>
        <td colspan="3" style="padding-top: 0px;"></td>
        <td colspan="1" class="text-right">Previous Due</td>
        <td colspan="1" class="text-right">{{ $customer->previous_due }}</td>
        <td class="text-right">
            <input type="number" step="any"
                   name="previous_due"
                   class="form-control paymentAmount text-right"
                   due="{{ $customer->previous_due }}"
                   max="{{ $customer->previous_due }}"
                   id="previous_due"/></td>
    </tr>

@endif
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
                   class="paymentAmount invoice text-right form-control"
                   due="{{ $invoice->due  }}"
                   max="{{ $invoice->due  }}"
                   step="any"
                   type="number"/>
        </td>
    </tr>
@endforeach

@foreach($pos_sales as $sale)
    <tr>
        <td> {{ $sale->date }} <br>


        </td>
        <td> {{ $sale->pos_number }} </td>
        <td> {{ $sale->due_date??'-' }} </td>


        <td class="text-right"> {{ $sale->total }} </td>
        <td class="text-right"> {{ $sale->due }} </td>
        <td class="text-right" style="width:16%; position: relative;">
            <input name="payment[]"
                   pos_id="{{ $sale->id }}"
                   class="paymentAmount pos text-right form-control"
                   due="{{ $sale->due  }}"
                   max="{{ $sale->due  }}"
                   step="any"
                   type="number"/>
        </td>
    </tr>
@endforeach

<tr>
    <td colspan="3" style="padding-top: 0px;"></td>
    <td colspan="2" class="text-right">Total Due</td>
    <td class="text-right">
        <input type="number" step="any" name="totalPayable" class="form-control text-right" readonly
               style="cursor: no-drop"
               value="{{ $customer->previous_due + $invoices->sum('due') + $pos_sales->sum('due') }}"
               id="totalPayable"/></td>

</tr><tr>
    <td colspan="3" style="padding-top: 0px;"></td>
    <td colspan="2" class="text-right">Total Amount</td>

    <td class="text-right">
        <input type="number" step="any" name="totalAmount" class="form-control text-right" readonly
               style="cursor: no-drop"
               id="totalAmount"/></td>
</tr>
