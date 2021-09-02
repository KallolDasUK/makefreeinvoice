
<table class="table table-head-custom table-vertical-center">
    <thead>
    <tr>
        <th>SL</th>
        <th>DATE</th>
        <th>Method</th>
        <th>Amount</th>
        <th></th>
    </tr>
    </thead>
<tbody>



@foreach($payments as $payment)
    <tr>
        <td> {{ $loop->iteration }} </td>
        <td>{{ optional($payment->receive_payment)->payment_date }}</td>
        <td>{{ optional($payment->receive_payment)->paymentMethod->name }}</td>
        <td>{{ $payment->amount }}</td>
        <td class="text-right" style="width:16%; position: relative;">
            <div class="row">
                <div class="col"><a href="" class="mr-4 d-block"> Receipt</a></div>
                <div class="col"><button type="submit" style="border: none;background: transparent" title="Delete Inventory Adjustment"
                                         onclick="return confirm('Are you sure.')">
                        <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
                    </button></div>
            </div>



        </td>
    </tr>
@endforeach
<tr>
    <td colspan="1" style="padding-top: 0px;"></td>
    <td colspan="2" class="text-right">Total Payment</td>
    <td class="text-right">{{ $payments->sum('amount') }}</td>
</tr>
</tbody>

</table>
