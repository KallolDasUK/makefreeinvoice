@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h2>{{ $voucher_type }} Voucher Report ({{ $branch_name }})</h2>
        <p> {{ \Illuminate\Support\Carbon::parse($start_date)->format('d-M-Y') }}
            - {{ \Illuminate\Support\Carbon::parse($end_date)->format('d-M-Y') }}
        </p>

    </center>


    <table>
        <thead>

        <tr>
            <th>Date</th>
            <th>Voucher Number</th>
            <th>Particulars</th>
            <th style="text-align: center">Debit</th>
            <th style="text-align: center">Credit</th>
        </tr>

        </thead>
        <tbody>
        @php($cr=0)
        @php($dr=0)
        @foreach($txns as $txn)
            <tr>
                <td></td>
                <td>{{ $txn->voucher_no }}</td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            @foreach($txn->transaction_details as $txnDetail)
                <tr>
                    <td>{{ $txnDetail->date }}</td>
                    <td></td>
                    <td>{{ $txnDetail->ledger->ledger_name }}</td>

                    @if($txnDetail->entry_type == \Enam\Acc\Utils\EntryType::$CR)
                        <td style="text-align: center">{{ $txnDetail->amount }}</td>
                        <td style="text-align: center">0</td>
                        @php($cr+=$txnDetail->amount)

                    @else
                        <td style="text-align: center">0</td>
                        <td style="text-align: center">{{ $txnDetail->amount }}</td>
                        @php($dr+=$txnDetail->amount)

                    @endif

                </tr>
            @endforeach
        @endforeach

        <tr style="font-weight: bolder;text-align: center">
            <td colspan="3" style="text-align: start">Grand Total</td>
            <td>{{ $cr }}</td>
            <td>{{ $dr }}</td>

        </tr>
        </tbody>
    </table>

    @include ('acc::partials.signature')
@endsection
