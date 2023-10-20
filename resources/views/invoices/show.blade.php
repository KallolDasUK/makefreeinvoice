@extends('acc::layouts.app')
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"
            integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" src="{{ asset('js/jquery.qrcode.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/qrcode.js') }}"></script>

@endsection
@section('css')
    <style>
        .invoice-container {
            margin: 15px auto;
            padding: 70px;
            max-width: 850px;
            background-color: #fff;
            border: 1px solid #ccc;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            -o-border-radius: 6px;
            border-radius: 6px;
        }

        .invoice-container-template-1 {
            margin: 15px auto;
            padding: 0px;
            max-width: 850px;
            background-color: #fff;

            /*border: 1px solid #ccc;*/
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            -o-border-radius: 6px;
            border-radius: 6px;
        }

        b, strong {
            font-weight: bolder;
        }

        .text-1 {
            font-size: 12px !important;
            font-size: 0.75rem !important;
        }

        .text-7 {
            font-size: 28px !important;
            font-size: 1.75rem !important;
        }

        @page {
            margin: 0 !important;
            padding: 0 !important;
        }

        @media print {
            body * {
                visibility: hidden;
                font-size: 1.5rem;
                color: #181818 !important;
            }

            h1 {
                font-size: 4rem;
            }

            h2 {
                font-size: 3rem;
            }

            h3 {
                font-size: 2rem;
            }

            .invoice-container, .delivery-container {
                max-width: 100%;
            }

            #invoice-container * {
                visibility: visible;
            }

            #delivery-container * {
                visibility: visible;
            }

            .paid_watermark {
                visibility: visible;
            }

            #invoice-container {
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
                min-height: 297mm !important;
            }

            #delivery-container {
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
                min-height: 297mm !important;
            }

            footer {
                position: absolute;
                bottom: 0;
                width: 100%;
            }
        }


    </style>
@endsection
@section('content')

    <div class="">

        <div class="d-flex">
            <div class="template_section flex " style="width: 200px;">

                @include('partials.invoice-template-list',['template'=>$template])

            </div>
            <div class="main_section flex" style="width: 100%">
                <div class="">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
                            {!! session('success_message') !!}

                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    @endif

                    <div class="" style="margin: 0px auto;max-width: 850px">

                        <form method="POST" action="{!! route('invoices.invoice.destroy', $invoice->id) !!}"
                              accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            {{ csrf_field() }}
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('invoices.invoice.index') }}"
                                   class="btn btn-primary mr-2   {{  ability(\App\Utils\Ability::INVOICE_READ) }}"
                                   title="Show All Invoice">
                                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                                    Show All Invoice
                                </a>

                                <a href="{{ route('invoices.invoice.create') }}"
                                   class="btn btn-success mr-2   {{  ability(\App\Utils\Ability::INVOICE_CREATE) }}"
                                   title="Create New Invoice">
                                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                                    Create New Invoice
                                </a>

                                <a href="{{ route('invoices.invoice.edit', $invoice->id ) }}"
                                   class="btn btn-primary mr-2   {{  ability(\App\Utils\Ability::INVOICE_EDIT) }}"
                                   title="Edit Invoice">
                                    <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                                    Edit Invoice
                                </a>

                                <button type="submit" class="btn btn-danger" title="Delete Invoice"
                                        {{  ability(\App\Utils\Ability::INVOICE_DELETE) }}
                                        onclick="return confirm('Click Ok to delete Invoice.')">
                                    <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                                    Delete Invoice
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
                <p class="clearfix"></p>
                <div class="bg-white mb-0" style="margin: 0px auto;max-width: 850px">
                    <div class="btn-group btn-group-sm d-print-none" style="width: 100%">
                        <button id="printBtn"
                                class="btn btn-outline-secondary  btn-lg" style="font-size: 20px"><i
                                class="fa fa-print"></i> Print
                        </button>
                        <button id="downloadButton"
                                class="btn btn-outline-secondary   btn-lg" style="font-size: 20px"><i
                                class="fa fa-download"></i> Download
                        </button>
                        <a href="{{ route('invoices.invoice.share',$invoice->secret) }}"
                           class="btn btn-outline-secondary   btn-lg " style="font-size: 20px"><i
                                class="fa fa-share"></i> Share
                        </a>
                        <a href="{{ route('invoices.invoice.send',$invoice->id) }}"
                           class="btn btn-outline-secondary   btn-lg " style="font-size: 20px"><i
                                class="far fa-envelope-open"></i> Email Invoice
                        </a>
                        <button type="button" id="delivery_button"
                                class="btn btn-outline-secondary   btn-lg delivery_button" style="font-size: 20px"><i
                                class="far fa-sticky-note"></i> Delivery Note
                        </button>
                    </div>
                </div>
                <p class="clearfix"></p>
                <div class="paid_watermark">
                    {{--                    {{ dd($invoice->due) }}--}}
                    @if(($settings->paid_watermark??false) && floatval($invoice->due) == 0)
                        <div class="paid_watermark" style=" position: absolute;
                          left: 0;
                          right: 0;
                          margin-top: 20px;
                          z-index: 99999;
                          margin-left: auto;
                          margin-right: auto;
                          width: 100px;">
                            <img class="paid_watermark" width="200" src="{{ asset('images/paid.webp') }}" alt="">
                        </div>
                    @endif
                    @if($template == "template_1")
                        @include('partials.invoice_template.template_1')
                    @elseif($template == "arabic")
                        @include('partials.invoice_template.arabic')

                    @else
                        @include('partials.invoice_template.classic')
                    @endif

                    @include('partials.invoice_template.delivery_note')

                </div>
            </div>


        </div>


    </div>

@endsection

@push('js')
    <script>


        $('#downloadButton').on('click', function () {
            var element = document.getElementById('invoice-container');
            let invoice_number = "{{ $invoice->invoice_number??'invoice_invoicepedia' }}"
            var opt = {
                filename: invoice_number + '.pdf',
                image: {type: 'jpeg', quality: 0.98},
                html2canvas: {scale: 2},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
            };
            html2pdf(element, opt);
        })


        var qr_code_style = @json($qr_code_style);
        if (qr_code_style !== 'hide') {
            jQuery('#qr_code').qrcode({
                text: "{{ $qr_code }}",
                width: 120, height: 120,
            });
        }


        $('#printBtn').on('click', function () {
            // Apply styles for the invoice container
            $('#delivery-container').css('visibility', 'hidden');
            $('#delivery-container').hide()
            $('#invoice-container').css('visibility', 'visible');
            setTimeout(function () {
                window.print();
                $('#delivery-container').show()

            }, 100);


        });

        $('#delivery_button').on('click', function () {
            // Apply styles for the delivery container
            $('#invoice-container').css('visibility', 'hidden');
            $('#invoice-container').hide();
            $('#delivery-container').css('visibility', 'visible');
            setTimeout(function () {
                window.print();
                $('#invoice-container').show();

            }, 100);

        });

        window.onafterprint = function () {
            // Restore visibility of both containers
            $('#invoice-container').css('visibility', 'visible');
            $('#delivery-container').css('visibility', 'visible');
        };


    </script>
@endpush
