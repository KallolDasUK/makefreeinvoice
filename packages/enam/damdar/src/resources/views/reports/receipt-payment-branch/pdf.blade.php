@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h2>Project summary for month of {{ \Illuminate\Support\Carbon::parse($month)->format('M-Y') }}        </h2>
        <p>Receipt & Payment Reports (Branch Wise)</p>


    </center>

    @php($receive = 0)
    @php($expense = 0)
    @php($profit = 0)

    @foreach($records as $index => $record)
        <table>
            <thead>
            <tr>
                <th style="text-align: start;width: 300px;">{{ $record['branch'] }}</th>
                <th style="text-align: center">Debit</th>
                <th style="text-align: center">Credit</th>
                <th style="text-align: center">Revenue</th>

            </tr>
            </thead>
            <tbody style="text-align: center">

            @foreach($record as $key => $value)
                @if($key==='branch'||$key ==='payment')
                    @continue
                @endif

                @if($key==='revenue')
                    <tr>
                        <td style="text-align: start">{{ \Illuminate\Support\Str::title($key) }}</td>
                        <td></td>
                        <td>{{ number_format($value) }}</td>
                    </tr>
                @elseif($key==='net_revenue')
                    <tr>
                        <td style="text-align: start" style="font-weight: bold">Service Revenue</td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($value) }}</td>
                    </tr>
                @else
                    <tr>
                        <td style="text-align: start">{{ \Illuminate\Support\Str::title($key) }}</td>
                        <td>{{ number_format($value) }}</td>
                        <td></td>
                        @php($expense += $value)
                    </tr>
                @endif


            @endforeach
            @if($loop->last)
            <tr style="text-align: center;color: #00C851">
                <td></td>
                <td style="font-weight: bold">{{ number_format($totalRevenue) }}</td>
                <td style="font-weight: bold">{{ number_format($expense) }}</td>
                <td style="font-weight: bold">{{ number_format($totalNetRevenue) }}</td>
            </tr>
            @endif
            </tbody>

        </table>
        <hr>
    @endforeach


    @include ('acc::partials.signature')
@endsection


