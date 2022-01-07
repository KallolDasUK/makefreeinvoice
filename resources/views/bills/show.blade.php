@extends('acc::layouts.app')
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"
            integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>@endsection
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

        @media print {
            body * {
                visibility: hidden;
            }

            #invoice-container, #invoice-container * {
                visibility: visible;
            }

            #invoice-container {
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
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

                <form method="POST" action="{!! route('bills.bill.destroy', $bill->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('bills.bill.index') }}" class="btn btn-primary mr-2 {{ ability(\App\Utils\Ability::BILL_READ) }}"
                           title="Show All Bill">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Bill
                        </a>

                        <a href="{{ route('bills.bill.create') }}" class="btn btn-success mr-2  {{ ability(\App\Utils\Ability::BILL_CREATE) }}"
                           title="Create New Bill">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Bill
                        </a>

                        <a href="{{ route('bills.bill.edit', $bill->id ) }}" class="btn btn-primary mr-2  {{ ability(\App\Utils\Ability::BILL_EDIT) }}"
                           title="Edit Bill">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Bill
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Bill"
                                {{ ability(\App\Utils\Ability::BILL_DELETE) }}
                                onclick="return confirm(&quot;Click Ok to delete Bill.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Bill
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
                <a href="{{ route('bills.bill.share',$bill->secret) }}"
                   class="btn btn-outline-secondary   btn-lg " style="font-size: 20px"><i
                        class="fa fa-share"></i> Share
                </a>
            </div>
        </div>
        <p class="clearfix"></p>

        <div style="position:relative;">
            @if(($settings->paid_watermark??false) && floatval($bill->due) == 0)
                <div style=" position: absolute;
                          left: 0;
                          right: 0;
                          margin-top: 5%;
                          z-index: 99999;
                          margin-left: auto;
                          margin-right: auto;
                          width: 100px;">
                    <img width="200" src="{{ asset('images/paid.png') }}" alt="">
                </div>
            @endif

        @include('partials.bill')
    </div>
    </div>

@endsection

@push('js')
    <script>

        $('#printBtn').on('click', function () {
            window.print()
        })

        $('#downloadButton').on('click', function () {
            var element = document.getElementById('invoice-container');
            let invoice_number = "{{ $bill->bill_number??'invoice_invoicepedia' }}"
            var opt = {
                filename: invoice_number + '.pdf',
                image: {type: 'jpeg', quality: 0.98},
                html2canvas: {scale: 2},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
            };
            html2pdf(element, opt);
        })


    </script>
@endpush
