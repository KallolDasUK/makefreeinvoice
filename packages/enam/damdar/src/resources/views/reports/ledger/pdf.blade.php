@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h2>Ledger Report ({{ $branch_name??'All' }})</h2>
        <h3>{{ $ledger_name??'' }}</h3>
        <p> {{ \Illuminate\Support\Carbon::parse($start_date)->format('d-M-Y') }}
            - {{ \Illuminate\Support\Carbon::parse($end_date)->format('d-M-Y') }}
        </p>

    </center>


    <table>
        <thead>

        <tr>
            <th>Date</th>
            <th>Particulars</th>
            <th>Note</th>
            <th>Voucher Type</th>
            <th>Voucher No</th>
            <th style="text-align: center">Debit</th>
            <th style="text-align: center">Credit</th>
        </tr>

        </thead>
        <tbody>
        <tr style="font-weight: bolder;text-align: center">
            <td></td>
            <td colspan="4">Opening Balance</td>
            <td>{{ number_format($opening_debit??0) }}</td>
            <td>{{ number_format($opening_credit??0) }}</td>
        </tr>

        @php($dr = $opening_debit)
        @php($cr = $opening_credit)
        @foreach($ledgerTransactions??[] as $txnDetail)
            <tr>
                <td>{{ \Carbon\Carbon::parse($txnDetail->date)->format('d M y') }}</td>

                <?php
                try {
                    $max = $txnDetail->transaction->transaction_details->max('amount');
                    $name = optional($txnDetail->transaction->transaction_details->where('amount', $max)->where('ledger_id', '!=', $txnDetail->ledger_id)->first())->ledger->ledger_name;
                }catch (Exception $exception){
                    $name = "Debitor";
                }
                ?>
                <td>{{ $name }}</td>
                <td>{{ $txnDetail->note }}</td>
                <td>{{ optional($txnDetail->transaction)->txn_type }}</td>
                <td>{{ $txnDetail->voucher_no }}</td>

                @if($txnDetail->entry_type == \Enam\Acc\Utils\EntryType::$DR)
                    <td style="text-align: center">{{ number_format($txnDetail->amount )}}</td>
                    <td style="text-align: center">0</td>
                    @php($dr +=$txnDetail->amount)
                @else
                    <td style="text-align: center">0</td>
                    <td style="text-align: center">{{ number_format($txnDetail->amount) }}</td>
                    @php($cr +=$txnDetail->amount)

                @endif

            </tr>
        @endforeach
        <tr style="font-weight: bolder;text-align: center">
            <td></td>
            <td colspan="4">Closing Balance</td>
            @if($dr>$cr)
                <td>{{ number_format($dr-$cr) }}</td>
                <td></td>
            @else
                <td></td>

                <td>{{ number_format($cr-$dr) }}</td>
            @endif
        </tr>


        </tbody>
    </table>

    @include ('acc::partials.signature')
@endsection
