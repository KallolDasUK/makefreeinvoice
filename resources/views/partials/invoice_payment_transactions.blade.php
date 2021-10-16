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
            <td>{{ optional(optional($payment->receive_payment)->ledger)->ledger_name }}</td>
            <td>{{ decent_format_dash_if_zero($payment->amount) }}</td>
            <td class="text-right">

                        <span
                            onclick="showCustomerPaymentReceipt('{{ optional($payment->receive_payment)->id }}')"
                            class="mr-4 btn btn-primary btn-sm"> <i class="fa fa-eye"></i> Receipt</span>

            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="1" style="padding-top: 0px;"></td>
        <td colspan="2" class="text-right"><b>Total Payment</b></td>
        <td class="text-left"><b>{{ decent_format_dash_if_zero($payments->sum('amount')) }}</b></td>
    </tr>
    </tbody>

</table>
