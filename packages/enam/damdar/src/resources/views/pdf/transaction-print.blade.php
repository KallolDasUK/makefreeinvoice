@extends('acc::pdf.pdf')

@section('content')
    <center><h2>Receipt</h2></center>


    <table>
        <thead>
        <tr>
            <td>Voucher No : {{ $transaction->voucher_no }}</td>
            <td></td>
            <td style="text-align: right">Date : {{ $transaction->date }}</td>
        </tr>
        <tr>
            <th> Ledger</th>
            <th> Debit</th>
            <th> Credit</th>
        </tr>
        </thead>
        <tbody>
        @php($cr=0)
        @php($dr=0)
        @foreach($transaction->transaction_details as $txn)
            <tr>
                <td>{{ $txn->ledger->ledger_name }}</td>
                @if($txn->entry_type==\Enam\Acc\Utils\EntryType::$DR)
                    <td>{{ $txn->amount }}</td>
                    @php($dr = $dr+$txn->amount)
                @else
                    <td>0</td>

                @endif

                @if($txn->entry_type==\Enam\Acc\Utils\EntryType::$CR)
                    <td>{{ $txn->amount }}</td>
                    @php($cr = $cr+$txn->amount)

                @else
                    <td>0</td>

                @endif

            </tr>
        @endforeach
        <tr style="font-weight: bolder">
            <td colspan="">Total</td>
            <td colspan=""> {{ $dr }} </td>
            <td colspan="">{{ $cr }} </td>
        </tr>

        </tbody>
    </table>

    <div class="note" style="margin-top: 20px">
        In Word : <strong>{{ \Illuminate\Support\Str::title($in_word??'') }}</strong> <br> <br>
        Note : {{ $transaction->note??'' }}
    </div>

    @include ('acc::partials.signature')
@endsection
