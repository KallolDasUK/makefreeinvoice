@extends('acc::pdf.pdf')

@section('content')
    <center>
        <h3>Receipt & Payment Reports ({{ $record['branch']??'n/a' }})
            of {{ \Illuminate\Support\Carbon::parse($month)->format('M-Y') }}</h3>
    </center>


    <table>
        <thead>
        <tr>
            <th>Particulars</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
        </thead>
        <tbody>


        @foreach($record as $key => $value)
            @if($key==='branch'||$key ==='payment')
                @continue
            @endif

            @if($key==='revenue')
                <tr>
                    <td>{{ \Illuminate\Support\Str::title($key) }}</td>
                    <td></td>
                    <td>{{ $value }}</td>
                </tr>
            @elseif($key==='net_revenue')
                <tr>
                    <td style="font-weight: bold">Service Revenue = {{ $value }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @else
                <tr>
                    <td>{{ \Illuminate\Support\Str::title($key) }}</td>
                    <td>{{ $value }}</td>
                    <td></td>
                </tr>
            @endif


        @endforeach


        </tbody>

    </table>

    @include ('acc::partials.signature')
@endsection


