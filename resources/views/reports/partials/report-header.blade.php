<header>
    <div class="text-center">

        @if($settings->business_name??false)
            <h4 style="margin-bottom: 0; margin-top: 0.5rem">{{ $settings->business_name }}</h4>
            <span>{{ $settings->street_1 }} {{ $settings->street_2 }}, {{ $settings->city }}, {{ $settings->zip_post }}</span>
            <br>
            <span>{{ $settings->email }}, {{ $settings->phone }}, </span>

            {{--                        <h1>Accounts Payable Aging</h1>--}}
            {{--                        <span>Date {{ today()->format('d M Y') }}</span>--}}
            <a href="{{ $settings->website }}">{{ $settings->website }}</a>
        @endif
    </div>

</header>
