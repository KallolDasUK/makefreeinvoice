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
            padding: 13px;
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
            body {
                -webkit-print-color-adjust: exact !important;
            }

            .border_bottom {
                border: none !important;
            }

            body * {
                visibility: hidden;
                font-size: 1.5rem;
                -webkit-print-color-adjust: exact !important;
                /*color: #181818 !important;*/

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

            .invoice-container {
                /*margin: 0px;*/
                max-width: 100%;
            }

            #invoice-container, #invoice-container * {
                visibility: visible;
            }

            #invoice-container {
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
            <div class="text-center">

                <form method="POST"
                      action="{!! route('contact_invoices.contact_invoice.destroy', $contact_invoice->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('contact_invoices.contact_invoice.index') }}"
                           class="btn btn-primary mr-2 {{ ability(\App\Utils\Ability::BILL_READ) }}"
                           title="Show All Contact Invoice">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Contact Invoice
                        </a>

                        <a href="{{ route('contact_invoices.contact_invoice.create') }}"
                           class="btn btn-success mr-2  {{ ability(\App\Utils\Ability::BILL_CREATE) }}"
                           title="Create New Contact Invoice">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Contact Invoice
                        </a>

                        <a href="{{ route('contact_invoices.contact_invoice.edit', $contact_invoice->id ) }}"
                           class="btn btn-primary mr-2  {{ ability(\App\Utils\Ability::BILL_EDIT) }}"
                           title="Edit Contact Invoice">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Contact Invoice
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Contact Invoice"
                                {{ ability(\App\Utils\Ability::BILL_DELETE) }}
                                onclick="return confirm(&quot;Click Ok to delete Contact Invoice.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Contact Invoice
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <p class="clearfix"></p>
        <div class="text-center bg-white mb-0" style="margin: 0px auto;max-width: 850px">
            <div class="btn-group btn-group-sm d-print-none" style="width: 100%">
                <button id="printBtn"
                        class="btn btn-outline-secondary  btn-lg" style="font-size: 20px"><i
                        class="fa fa-print"></i> Print
                </button>
                <button id="downloadButton"
                        class="btn btn-outline-secondary   btn-lg" style="font-size: 20px"><i
                        class="fa fa-download"></i> Download
                </button>

            </div>
        </div>
        <p class="clearfix"></p>
        @include('partials.contact_invoice_template.classic')
        <input type="hidden" id="customer_id" value="{{ optional($contact_invoice->customer)->id }}">
        <input type="hidden" id="contact_invoice_id" value="{{ $contact_invoice->id }}">
    </div>

@endsection

@push('js')
    <script>

        $('#printBtn').on('click', function () {
            window.print()
        })

        $('#downloadButton').on('click', function () {
            var element = document.getElementById('invoice-container');
            let invoice_number = "{{ $contact_invoice->bill_number??'invoice_invoicepedia' }}"
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
        //

        $('#supplier_name_ar').on('blur', function () {
            saveInsertedData()
        })
        $('#supplier_address_ar').on('blur', function () {
            saveInsertedData()
        })

        $('#supplier_vat_ar').on('blur', function () {
            saveInsertedData()
        })


        $('#customer_name_ar').on('blur', function () {
            saveInsertedData()
        })
        $('#customer_address_ar').on('blur', function () {
            saveInsertedData()
        })
        $('#subject_ar').on('blur', function () {
            saveInsertedData()
        })
        $('#month_ar').on('blur', function () {
            saveInsertedData()
        })

        function saveInsertedData() {
            var _token = $('meta[name=csrf-token]').attr('content');
            let customer_name_ar = $('#customer_name_ar').text();
            let customer_address_ar = $('#customer_name_ar').text();
            let supplier_name_ar = $('#supplier_name_ar').text();
            let supplier_address_ar = $('#supplier_address_ar').text();
            let supplier_vat_ar = $('#supplier_vat_ar').text();
            let subject_ar = $('#subject_ar').text();
            let month_ar = $('#month_ar').text();
            let customer_id = $('#customer_id').val();
            let contact_invoice_id = $('#contact_invoice_id').val();

            $.ajax({
                url: route('ajax.storeContactInvoiceInfo'),
                type: 'post',
                data: {
                    _token,
                    customer_id,
                    contact_invoice_id,
                    customer_name_ar,
                    customer_address_ar,
                    supplier_name_ar,
                    supplier_address_ar,
                    supplier_vat_ar,
                    subject_ar,
                    month_ar
                },
            });
        }


    </script>
@endpush
