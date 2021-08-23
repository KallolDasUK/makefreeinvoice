<div>
    <center>
        <strong><h1 style="padding: 0px;margin: 0px"> {{ $settings->business_name??'n/a' }}</h1></strong>
        <address>

            @if($settings->street_1??'')
                <br> {{ $settings->street_1??'' }}
            @endif
            @if($settings->street_2??'')
                <br> {{ $settings->street_2??'' }}
            @endif
            @if(($settings->state??'') || ($settings->zip_post??'') )
                <br> {{ $settings->state??'' }} {{ $settings->zip_post??'' }}
            @endif
            @if($settings->email??'')
                <br> {{ $settings->email??'' }}
            @endif
            @if($settings->phone??'')
                <br> {{ $settings->phone??'' }}
            @endif
        </address>
        <hr>
    </center>


</div>
