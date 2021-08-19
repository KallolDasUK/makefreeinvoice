@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h2>Profit & Loss / Income Statement ({{ $branch_name }})</h2>
        <p> {{ \Illuminate\Support\Carbon::parse($start_date)->format('d-M-Y') }}
            - {{ \Illuminate\Support\Carbon::parse($end_date)->format('d-M-Y') }}
        </p>

    </center>


    <table>
        <thead>

        <tr>
            <th>Particulars</th>
            <th style="text-align: center">Amount</th>
            <th>Particulars</th>
            <th style="text-align: center">Amount</th>
        </tr>

        </thead>
        <tbody>
        <tr>
            <td colspan="2" style="">
                <table>
                    @php($amount = 0)
                    @foreach($incomeLedgers as $group_name=> $record)
                        <tr>
                            <td style="font-weight: bolder"> {{ $group_name }}</td>
                        </tr>
                        @foreach($record as $ledger)
                            <tr style="margin:15px">
                                <td> {{ $ledger['ledger_name'] }}</td>
                                <td style="text-align: center"> {{ $ledger['amount'] }}</td>
                            </tr>
                            @php($amount = $amount + intval($ledger['amount']))

                        @endforeach
                    @endforeach
                    <tr>
                        <td><b>Total</b></td>
                        <td style="text-align: center"><b>{{ $amount }}</b></td>
                    </tr>
                </table>
            </td>
            <td colspan="2">
                <table>
                    @php($amount = 0)

                    @foreach($expenseLedgers as $group_name=> $record)
                        <tr>
                            <td style="font-weight: bolder"> {{ $group_name }}</td>
                        </tr>
                        @foreach($record as $ledger)
                            <tr style="margin:15px">
                                <td> {{ $ledger['ledger_name'] }}</td>
                                <td style="text-align: center"> {{ $ledger['amount'] }}</td>
                            </tr>
                            @php($amount = $amount + intval($ledger['amount']))

                        @endforeach
                    @endforeach
                    <tr>
                        <td><b>Total</b></td>
                        <td style="text-align: center"><b>{{ $amount }}</b></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td><b>Gross Profit</b></td>
            <td style="text-align: center"><b>{{ $totalIncome }}</b></td>
            <td><b>Net Profit</b></td>
            <td style="text-align: center"><b>{{ $totalIncome-$totalExpense }}</b></td>
        </tr>


        </tbody>
    </table>

    @include ('acc::partials.signature')
@endsection
