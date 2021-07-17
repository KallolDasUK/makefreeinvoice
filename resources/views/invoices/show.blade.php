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
                <button id="downloadButton"
                        class="btn btn-outline-primary  btn-lg " style="font-size: 20px"><i
                        class="fa fa-send"></i> Send Invoice To
                </button>
            </div>
        </div>
        <p class="clearfix"></p>

        <div id="invoice-container" class="container-fluid invoice-container">

            <!-- Header -->
            <header>
                <div class="row align-items-center">
                    <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
                        @if($settings->business_logo??false)
                            <img
                                class="rounded"
                                src="{{ asset('storage/'.$settings->business_logo) }}"
                                width="100"
                                alt="">
                        @endif
                    </div>
                    <div class="col-sm-5 text-center text-sm-right">
                        <h4 class="text-7 mb-0">Invoice</h4>
                    </div>
                </div>
                <hr>
            </header>

            <!-- Main Content -->
            <main>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/y') }}</div>
                    <div class="col-sm-6 text-sm-right"><strong>Invoice No:</strong> {{ $invoice->invoice_number }}
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6 text-sm-right order-sm-1"><strong> From:</strong>
                        <address>
                            Koice Inc<br>
                            2705 N. Enterprise St<br>
                            Orange, CA 92865<br>
                            contact@koiceinc.com
                        </address>
                    </div>
                    <div class="col-sm-6 order-sm-0"><strong>To:</strong>
                        <address>
                            Smith Rhodes<br>
                            15 Hodges Mews, High Wycombe<br>
                            HP12 3JL<br>
                            United Kingdom
                        </address>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="card-header">
                                <tr>
                                    <td class=" border-0"><strong>SL</strong></td>
                                    <td class=" border-0"><strong>Description</strong></td>
                                    <td class=" text-center border-0"><strong>Rate</strong></td>
                                    <td class=" text-center border-0"><strong>QTY</strong></td>
                                    <td class=" text-right border-0"><strong>Amount</strong></td>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($invoice->invoice_items as $item)

                                    <tr class="">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="">
                                            {{ $item->product->name }}
                                            @if($item->description)
                                                <br>
                                                <small> {{ $item->description }} </small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $invoice->currency }}{{ number_format($item->price) }}</td>
                                        <td class="text-center ">{{ number_format($item->qnt) }}x</td>
                                        <td class="text-right">{{ $invoice->currency }}{{ number_format($item->amount) }}</td>
                                    </tr>
                                @endforeach


                                </tbody>
                                <tfoot class="card-footer">
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Sub Total:</strong></td>
                                    <td class="text-right">$2150.00</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Tax:</strong></td>
                                    <td class="text-right">$215.00</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                    <td class="text-right">{{ $invoice->currency }}{{ number_format($item->total) }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Footer -->

            <div class="row mt-4">
                <div class="col"><p class="text-1"><strong>Terms & Condition :</strong> <br>
                        {{ $invoice->terms_condition }}</p>
                    <p class="text-1"><strong>Notes :</strong> <br>
                        {{ $invoice->notes }}</p>
                </div>
                <div class="col"></div>
            </div>

        </div>


    </div>

@endsection

@section('js')
    <script>
        $('#printBtn,#downloadButton').on('click', function () {
            window.print()
        })
    </script>
@endsection
