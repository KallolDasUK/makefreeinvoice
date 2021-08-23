@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h2>Trial Balance ({{ $branch_name }})</h2>
        <p> {{ \Illuminate\Support\Carbon::parse($start_date)->format('d-M-Y') }}
            - {{ \Illuminate\Support\Carbon::parse($end_date)->format('d-M-Y') }}
        </p>

    </center>


    <table>
        <thead>
        <col>
        <colgroup span="2"></colgroup>
        <colgroup span="2"></colgroup>
        <tr>
            <th rowspan="2">Particulars</th>
            <th rowspan="2">Opening Balance</th>
            <th colspan="2" scope="colgroup">Transaction Details</th>
            <th colspan="2" scope="colgroup">Closing Balance</th>
        </tr>
        <tr>
            <th scope="col">Debit</th>
            <th scope="col">Credit</th>
            <th scope="col">Debit</th>
            <th scope="col">Credit</th>
        </tr>
        </thead>
        <tbody>
        @php($cr=0)
        @php($cdr=0)
        @php($ccr=0)
        @php($dr=0)
        @foreach($records as $group_name=> $record)
            <tr>
                <td style="font-weight: bolder"> {{ $group_name }}</td>
            </tr>
            @foreach($record as $ledger)
                <tr style="margin">
                    <td> {{ $ledger->ledger_name }}</td>
                    <td style="text-align: center"> {{ $ledger->opening_balance }} {{ $ledger->opening_balance_type }}</td>
                    <td style="text-align: center"> {{ $ledger->total_debit }}</td>
                    <td style="text-align: center"> {{ $ledger->total_credit }}</td>
                    <td style="text-align: center"> {{ $ledger->closing_debit }}</td>
                    <td style="text-align: center"> {{ $ledger->closing_credit }}</td>
                </tr>

                @php($cdr = $cdr + $ledger->closing_debit)
                @php($ccr = $ccr + $ledger->closing_credit)
                @php($dr = $dr + $ledger->total_debit)
                @php($cr = $cr + $ledger->total_credit)
            @endforeach
        @endforeach
        <tr style="font-weight: bolder;text-align: center">
            <td colspan="2"></td>
            <td colspan=""> {{ $dr }} </td>
            <td colspan="">{{ $cr }} </td>
            <td colspan="">{{ $cdr }} </td>
            <td colspan="">{{ $ccr }} </td>
        </tr>

        </tbody>
    </table>

    @include ('acc::partials.signature')
@endsection
