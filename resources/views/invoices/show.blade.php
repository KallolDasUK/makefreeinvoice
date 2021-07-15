@extends('acc::layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">

            <h5 class="my-1 float-left">{{ isset($title) ? $title : 'Invoice' }}</h5>

            <div class="float-right">

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

        <div class="card card-custom overflow-hidden mx-auto" style="width: 70%">
            <div class="card-body p-0">
                <!-- begin: Invoice-->
                <!-- begin: Invoice header-->
                <div class="row justify-content-center bgi-size-cover bgi-no-repeat py-8 px-8 py-md-27 px-md-0"
                     style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo2/dist/assets/media/bg/bg-6.jpg);">
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                            <h1 class="display-4 text-white font-weight-boldest mb-10">INVOICE</h1>
                            <div class="d-flex flex-column align-items-md-end px-0">
                                <!--begin::Logo-->
                                <a href="#" class="mb-5">
                                    @if($settings->business_logo??false)
                                        <img
                                            class="rounded"
                                            src="{{ asset('storage/'.$settings->business_logo) }}"
                                            width="100"
                                            alt="">
                                    @endif
                                </a>
                                <!--end::Logo-->
                                <span class="text-white d-flex flex-column align-items-md-end opacity-70">
															<span>Cecilia Chapman, 711-2880 Nulla St, Mankato</span>
															<span>Mississippi 96522</span>
														</span>
                            </div>
                        </div>
                        <div class="border-bottom w-100 opacity-20"></div>
                        <div class="d-flex justify-content-between text-white pt-6">
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolde mb-2r">DATA</span>
                                <span class="opacity-70">Dec 12, 2017</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">INVOICE NO.</span>
                                <span class="opacity-70">GS 000014</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">INVOICE TO.</span>
                                <span class="opacity-70">Iris Watson, P.O. Box 283 8562 Fusce RD.
														<br>Fredrick Nebraska 20620</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice header-->
                <!-- begin: Invoice body-->
                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-10">
                        <div class="">
                            <table class="table table-sm table-striped">
                                <thead>
                                <tr>
                                    <th class=" font-weight-bold text-muted text-uppercase">Description</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Quantity</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Rate</th>
                                    <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice->invoice_items as $item)
                                    <tr class="font-weight-boldest font-size-lg">
                                        <td class="">
                                            {{ $item->product->name }}
                                            @if($item->description)
                                            <small> {{ $item->description }} </small>
                                                @endif
                                        </td>
                                        <td class="text-right ">{{ number_format($item->qnt) }}x</td>
                                        <td class="text-right">{{ number_format($item->price) }}</td>
                                        <td class="text-danger text-right">{{ number_format($item->amount) }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice body-->
                <!-- begin: Invoice footer-->
                <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between flex-column flex-md-row font-size-lg">
                            <div class="d-flex flex-column mb-10 mb-md-0">
                                <div class="font-weight-bolder font-size-lg mb-3">BANK TRANSFER</div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="mr-15 font-weight-bold">Account Name:</span>
                                    <span class="text-right">Barclays UK</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="mr-15 font-weight-bold">Account Number:</span>
                                    <span class="text-right">1234567890934</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="mr-15 font-weight-bold">Code:</span>
                                    <span class="text-right">BARC0032UK</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column text-md-right">
                                <span class="font-size-lg font-weight-bolder mb-1">TOTAL AMOUNT</span>
                                <span class="font-size-h2 font-weight-boldest text-danger mb-1">$20.600.00</span>
                                <span>Taxes Included</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice footer-->
                <!-- begin: Invoice action-->
                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                    onclick="window.print();">Download Invoice
                            </button>
                            <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">
                                Print Invoice
                            </button>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice action-->
                <!-- end: Invoice-->
            </div>
        </div>
    </div>

@endsection
