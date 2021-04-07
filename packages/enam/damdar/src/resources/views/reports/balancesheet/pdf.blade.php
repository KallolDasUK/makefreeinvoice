@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h2>Balance Sheet ({{ $branch_name }})</h2>
        <p> {{ \Illuminate\Support\Carbon::parse($start_date)->format('d-M-Y') }}
            - {{ \Illuminate\Support\Carbon::parse($end_date)->format('d-M-Y') }}
        </p>

    </center>


    <h2>Assets</h2>
    <hr>
    <table>
        <thead>
        <tr>
            <th>Particulars</th>
            <th>Amount</th>
            <th>Total Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($assetLedgers as $group_name=> $record)
            <tr>
                <td style="font-weight: bolder"> {{ $group_name }}</td>
            </tr>
            @php($amount = 0)
            @foreach($record as $ledger)
                <tr>
                    <td style="width: 300px"> {{ $ledger['ledger_name'] }}</td>
                    <td style="text-align: center"> {{ number_format($ledger['amount']) }}</td>
                </tr>
                @php($amount = $amount + intval($ledger['amount']))
            @endforeach

            <tr>
                <td></td>
                <td></td>
                <td style="font-weight: bolder"> {{ number_format($amount) }}</td>
            </tr>
        @endforeach
        <tr style="color: #1f6fb2">
            <td><b>Total Assets</b></td>
            <td></td>
            <td><b>{{ number_format($totalAsset) }}</b></td>
        </tr>
        </tbody>
    </table>
    <h2>Liabilities</h2>
    <hr>
    <table>
        <thead>
        <tr>
            <th>Particulars</th>
            <th>Amount</th>
            <th>Total Amount</th>
        </tr>
        </thead>
        @foreach($liabilitiesLedgers as $group_name=> $record)
            <tr>
                <td style="font-weight: bolder"> {{ $group_name }}</td>
            </tr>
            @php($amount = 0)

            @foreach($record as $ledger)
                <tr style="margin:15px">
                    <td style="width: 300px"> {{ $ledger['ledger_name'] }}</td>
                    <td style="text-align: center"> {{ number_format($ledger['amount']) }}</td>
                </tr>
                @php($amount = $amount + intval($ledger['amount']))

            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td style="font-weight: bolder"> {{ number_format($amount) }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="font-weight: bolder">Owner's Equity</td>
            <td></td>
            <td style="font-weight: bolder"></td>
        </tr>
        <tr>
            <td>Net Profit</td>
            <td></td>
            <td style="font-weight: bolder"> {{ number_format($profit) }}</td>
            @php($totalLiability += $profit)
        </tr>

        <tr>
            <td>Equity</td>
            <td></td>
            <td style="font-weight: bolder"> {{ number_format($totalAsset - $totalLiability) }}</td>
            @php($oe =$totalAsset - $totalLiability )
        </tr>
        <tr style="color: #1f6fb2">
            <td><b>Total Liabilities </b></td>
            <td></td>
            <td><b>{{ number_format($totalLiability + $oe )}}</b></td>
        </tr>
    </table>
    <center>
        <table style="color: #1f6fb2;">
            <tr>
                <td><b>Assets</b></td>
                <td style="text-align: center"><b>{{ number_format($totalAsset) }}</b></td>
                <td> =</td>
                <td><b>Liabilities + Owner Equity</b></td>
                <td style="text-align: center"><b>{{ number_format($totalLiability + $oe )}}</b></td>
            </tr>
        </table>

    </center>


    @include ('acc::partials.signature')
@endsection
