@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h2>Day Book Report ({{ $branch_name??'All' }})</h2>
        <p> {{ \Illuminate\Support\Carbon::parse($start_date)->format('d-M-Y') }}
            - {{ \Illuminate\Support\Carbon::parse($end_date)->format('d-M-Y') }}
        </p>

    </center>


    <table style="table-layout: fixed;
    width:100%;text-align: center">
        <thead>
        <tr >
            <th style="text-align: center">Date</th>
            <th  style="max-width: 150px; word-wrap: break-word;">Ledger Name</th>
            <th style="text-align: center">Note</th>
            <th style="text-align: center">Voucher Number</th>
            <th style="text-align: center">Voucher Type</th>
            <th style="text-align: center">Debit</th>
            <th style="text-align: center">Credit</th>
        </tr>
        </thead>
        <tbody>
        @php($cr=0)
        @php($dr=0)
        @foreach($txn_details as $txn_detail)

            <tr>
                <td>{{ $txn_detail->date }}</td>
                <td style="max-width: 50px!important; word-wrap: break-word;text-align: start">{{ $txn_detail->ledger->ledger_name??'-' }}</td>
                <td>{{ $txn_detail->note }}</td>
                <td>{{ $txn_detail->voucher_no }}</td>
                <td>{{ $txn_detail->transaction->txn_type }}</td>
                @if($txn_detail->entry_type==\Enam\Acc\Utils\EntryType::$CR)
                    <td>{{ number_format($txn_detail->amount) }}</td>
                    <td>0</td>
                    @php($dr+=$txn_detail->amount)
                @else
                    <td>0</td>
                    <td>{{ number_format($txn_detail->amount) }}</td>
                    @php($cr+=$txn_detail->amount)

                @endif

            </tr>
        @endforeach

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>

            <td>{{ $dr }}</td>
            <td>{{ $cr }}</td>

        </tr>
        </tbody>
    </table>


    @include ('acc::partials.signature')
@endsection
