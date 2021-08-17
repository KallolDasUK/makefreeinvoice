@extends('acc::layouts.app')



@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<style>
        .dropdown-toggle:hover {
            color: #0d71bb !important;
        }

        svg:hover {
            color: #0d71bb !important;
        }

        .dropdown-toggle::after {
            content: "";
            border-top: 0em solid;
        }


    </style>
@endsection
@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif


    @include('modals.receive-payment-modal')

    <div class="card rounded  mb-4">
        <div class="">
            <div class="row align-items-center">
                <div class="col ">

                    <div class="card " style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Overdue
                                <h3>{{ $settings->currency??'$' }}{{ $overdue }}</h3>
                            </div>
                            <div class="vertical-divider"></div>
                        </div>

                    </div>


                </div>
                <div class="col ">

                    <div class="card " style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Draft Amount
                                <h3>{{ $settings->currency??'$' }}{{ $draft }}</h3>
                            </div>
                            <div class="vertical-divider"></div>
                        </div>

                    </div>


                </div>
                <div class="col ">
                    <div class="card" style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Paid Amount
                                <h3>{{ $settings->currency??'$' }}{{ $paid }}</h3>
                            </div>
                            <div class="vertical-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="col ">
                    <div class="card" style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Due within next 30 days
                                <h3>{{ $settings->currency??'$' }}{{ $due_next_30 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="card card-custom card-stretch gutter-b">


        <!--begin::Header-->
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">INVOICES</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('invoices.invoice.create') }}"
                   class="btn btn-success btn-lg font-weight-bolder font-size-sm " style="font-size: 16px">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>

                    </span>Create an invoice</a>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-0">
            <!--begin::Filter-->
            <form action="{{ route('invoices.invoice.index') }}">
                <div class="row align-items-center mb-4">

                    <div class="col-lg-3 col-xl-2">
                        <input name="q" type="text" class="form-control" placeholder="Invoice Number #"
                               value="{{ $q }}"
                        >
                    </div>
                    <div class="mx-2">
                        <select name="customer" id="customer" class="form-control">
                            <option></option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                        @if($customer->id == $customer_id) selected @endif>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="input-daterange input-group" id="start_date">
                                <input type="text" class="form-control col-2" name="start_date"
                                       value="{{ $start_date }}"
                                       placeholder="From">
                                <div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-ellipsis-h"></i>
                                        To
                                    </span>
                                </div>
                                <input type="text" class="form-control col-2" name="end_date" id="end_date"
                                       value="{{ $end_date }}"

                                       placeholder="To">
                                <button role="button" type="submit"
                                        class="btn btn-primary px-6 mx-2 col-3 font-weight-bold">
                                    <i class="fas fa-sliders-h"></i>
                                    Filter
                                </button>

                                @if($start_date != null || $end_date != null || $customer_id !=null || $q != null)
                                    <a href="{{ route('invoices.invoice.index') }}" title="Clear Filter"
                                       class="btn btn-icon btn-light-danger"> X</a>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </form>
            <div>
                <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                    <thead>
                    <tr class="text-left">
                        <th class="pl-0" style="width: 20px">
                            <label class="checkbox checkbox-lg checkbox-inline">
                                <input type="checkbox" value="1">
                                <span></span>
                            </label>
                        </th>
                        <th class="text-center">Invoice Number</th>
                        <th class="pr-0">Client</th>
                        <th>Invoice Date</th>
                        <th>Payment Status</th>
                        <th>Due</th>
                        <th class="text-right">Amount</th>
                        <th class="pr-0 text-right" style="min-width: 150px">action</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($invoices as $invoice)

                        <tr>

                            <td class="pl-0">
                                <label class="checkbox checkbox-lg checkbox-inline">
                                    <input type="checkbox" value="1">
                                    <span></span>
                                </label>
                            </td>
                            <td class="text-center ">
                                <a class="font-weight-bolder d-block font-size-lg underline text-left invoice_number"
                                   href="{{ route('invoices.invoice.show',$invoice->id) }}">
                                    <i class="fa fa-external-link-alt font-normal text-secondary"
                                       style="font-size: 10px"></i>
                                    {{ $invoice->invoice_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('invoices.invoice.show',$invoice->id) }}"
                                   class="text-dark-75 font-weight-bolder d-block font-size-lg invoice_number">{{ optional($invoice->customer)->name }}</a>
                                <span
                                    class="text-muted font-weight-bold">{{ optional($invoice->customer)->email }}</span>
                            </td>
                            <td class="pl-0">
                                <a href="{{ route('invoices.invoice.show',$invoice->id) }}"
                                   class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg invoice_number">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</a>

                                @if($invoice->due_date)
                                    <span
                                        class="text-muted font-weight-bold text-muted d-block">Due on {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bolder  ">
                                    @php
                                        $class = '';
                                        if ($invoice->payment_status == \App\Models\Invoice::Paid) {
                                               $class = "badge badge-primary";
                                            }elseif($invoice->payment_status == \App\Models\Invoice::Partial){
                                            $class = "badge badge-warning";
                                            }else{
                                            $class = "badge badge-secondary";

                                            }
                                    @endphp
                                    <span style="font-size: 16px"
                                          class="{{ $class }}">{{ $invoice->payment_status }}</span>
                                </div>
                            </td>
                            <td>
                                @if($invoice->due>0)
                                    <span
                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $invoice->due }}</span>
                                @endif

                            </td>
                            <td class="text-right">
                                <div class="font-weight-bolder  ">
                                    <span
                                        style="font-size: 20px"><small>{{ $invoice->currency }}</small>{{ number_format($invoice->total,2) }} </span>
                                </div>
                            </td>
                            <td class="pr-0 text-right">
                                @if($invoice->due > 0)
                                    <span style="text-decoration: underline"
                                          class=" font-weight-bolder text-success  font-size-lg underline  text-hover-danger cursor-pointer mx-4 recordPaymentBtn"
                                          invoice_id="{{ $invoice->id }}" currency="{{ $invoice->currency }}"
                                          invoice_number="{{ $invoice->invoice_number }}"
                                          due="{{ $invoice->due }}"> Receive Payment</span>
                                @endif


                                <div class="dropdown d-inline">
                                    <span class=" dropdown-toggle mr-4 " type="button" style="font-size: 25px"
                                          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far"
                                             data-icon="caret-circle-down" role="img" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512"
                                             class="svg-inline--fa fa-caret-circle-down fa-w-16 fa-3x"><path
                                                fill="currentColor"
                                                d="M157.1 216h197.8c10.7 0 16.1 13 8.5 20.5l-98.9 98.3c-4.7 4.7-12.2 4.7-16.9 0l-98.9-98.3c-7.7-7.5-2.3-20.5 8.4-20.5zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-48 0c0-110.5-89.5-200-200-200S56 145.5 56 256s89.5 200 200 200 200-89.5 200-200z"
                                                class=""></path></svg>
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('invoices.invoice.send',$invoice->id) }}"
                                           class="dropdown-item btn">
                                            <span class="far fa-envelope-open mx-4"></span> <strong> Invoice
                                                Email</strong>
                                        </a>
                                        <a href="javascript:;"
                                           share_link="{{ route('invoices.invoice.share',$invoice->secret) }}"

                                           class="dropdown-item btn shareLink">
                                            <span class="fa fa-share mx-4"></span> <strong>Get Share Link</strong>
                                        </a>
                                        <a href="{{ route('invoices.invoice.edit',$invoice->id) }}"
                                           class="dropdown-item btn">
                                            <span class="fa fa-pencil-alt mx-4"></span> <strong>Edit</strong>
                                        </a>


                                        <form method="POST"
                                              action="{!! route('invoices.invoice.destroy', $invoice->id) !!}">
                                            {{ csrf_field() }}
                                            <button class="dropdown-item "
                                                    onclick="return confirm('Click Ok to delete Invoice')">
                                                @method('DELETE')
                                                <span class="fa fa-trash-alt mx-4 text-danger"></span>
                                                <span>
                                                    <strong>Delete</strong>
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>


                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
                <div class="float-right">
                    {!! $invoices->links() !!}
                </div>
            </div>
            <!--end::Table-->
        </div>

        <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalLabel">Get a shareable link</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4><input type="text" id="shareLinkInput" class="form-control"></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="copyLink" class="btn btn-primary">Copy</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $('.recordPaymentBtn').on('click', function () {
                let invoice_id = $(this).attr('invoice_id')
                let currency = $(this).attr('currency')
                let due = $(this).attr('due')
                let invoice_number = $(this).attr('invoice_number')
                $('#invoice_id').val(invoice_id)
                $('.currency').text(currency)
                $('.invoice_number').text(invoice_number)
                $('#amount').val(due)
                setTimeout(() => {
                    $('#amount').focus()
                }, 500)
                $('#recordPaymentModal').modal('show')
            });
            $('#payment_method_id').select2()
            $('#deposit_to').select2()
            $('#recordPaymentForm').validate({
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        beforeSend: () => {
                            $('button[type=submit]').prop('disabled', true)
                        },
                        success: function (response) {
                            $('#recordPaymentModal').modal('hide');
                            Swal.fire(response.success_message)
                                .then(function (result) {
                                    window.location.reload()
                                })
                            $('#recordPaymentForm').trigger("reset");
                            $('button[type=submit]').prop('disabled', false)

                        },

                    });
                },
                rules: {
                    amount: {required: true},
                    deposit_to: {required: true},
                    payment_method_id: {required: true},
                    payment_date: {required: true},
                },
                messages: {},
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    // element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('.shareLink').on('click', function () {
                let link = $(this).attr('share_link');
                $('#shareModal').modal('show')
                $('#shareLinkInput').val(link)
                setTimeout(() => {
                    $('#shareLinkInput').select()

                }, 500)
            })
            $('#copyLink').on('click', function () {
                document.execCommand("copy");
                $('#shareModal').modal('hide')
                $.notify('I have a progress bar', {showProgressbar: true});

            })

            $('.invoice_number').tooltip({'title': 'Show Invoice'});
            $('#customer').select2({placeholder: 'Customer', allowClear: true})


            var datepicker = $.fn.datepicker.noConflict();
            $.fn.bootstrapDP = datepicker;
            $("#start_date,#end_date").bootstrapDP({
                autoclose: true,
                format: "yyyy-mm-dd",
                immediateUpdates: true,
                todayBtn: true,
                todayHighlight: true
            });

        })
    </script>

@endsection


