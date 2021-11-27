<div class="template-container">


    <div class="title_section m-auto d-flex align-items-center justify-content-center border"
         style="height: 90px;text-align: center">

        <h3 class="underline">Templates <br>
            <i class="fas fa-chevron-down"></i>
        </h3>


    </div>

    <div class="template-list ">

        <div class=" mt-4 card border border-dark template @if($template=='classic') template-active @endif"
        >
            <a href="{{ route('invoices.invoice.show',[$invoice->id,'template'=>'classic']) }}">

                <img class="" src="{{ asset('images/templates/classic.png') }}" alt="" style="width: 100%;"
                     height="180">
                <div class="text-center m-0 p-0 "><b>Classic</b></div>
            </a>
        </div>
        <div class=" mt-4 card border border-dark  template @if($template=='template_1') template-active @endif">

            <a href="{{ route('invoices.invoice.show',[$invoice->id,'template'=>'template_1']) }}">
                <img class="" src="{{ asset('images/templates/arabian.png') }}" alt="" style="width: 100%;"
                     height="180">
                <div class="text-center m-0 p-0 "><b>No Logo + QR Code</b></div>
            </a>
        </div>
    </div>
</div>
