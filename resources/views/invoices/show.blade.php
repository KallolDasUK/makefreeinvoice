@extends('acc::layouts.app')

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


            <div class="text-center">

                <form method="POST" action="{!! route('invoices.invoice.destroy', $invoice->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('invoices.invoice.index') }}" class="btn btn-primary mr-2"
                           title="Show All Invoice">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Invoice
                        </a>

                        <a href="{{ route('invoices.invoice.create') }}" class="btn btn-success mr-2"
                           title="Create New Invoice">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Invoice
                        </a>

                        <a href="{{ route('invoices.invoice.edit', $invoice->id ) }}" class="btn btn-primary mr-2"
                           title="Edit Invoice">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Invoice
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Invoice"
                                onclick="return confirm(&quot;Click Ok to delete Invoice.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Invoice
                        </button>
                    </div>
                </form>

            </div>

        </div>
        <p class="clearfix"></p>
        <div class=" text-center">
            <div class="btn-group btn-group-sm d-print-none" style="font-size: 20px">
                <button id="printBtn"
                        class="btn btn-outline-info  btn-lg" style="font-size: 20px"><i
                        class="fa fa-print"></i> Print
                </button>
                <button id="downloadButton"
                        class="btn btn-outline-success  btn-lg" style="font-size: 20px"><i
                        class="fa fa-download"></i> Download
                </button>
                <a href="{{ route('invoices.invoice.send',$invoice->id) }}"
                   class="btn btn-outline-primary  btn-lg " style="font-size: 20px"><i
                        class="fa fa-send"></i> Send Invoice To
                </a>
            </div>
        </div>
        <p class="clearfix"></p>

        @include('partials.invoice')

    </div>

@endsection

@section('js')
    <script>
        $('#printBtn,#downloadButton').on('click', function () {
            window.print()
        })
    </script>
@endsection
