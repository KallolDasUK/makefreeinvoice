@extends('acc::layouts.app')



@section('css')
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




    <div class="card card-custom card-stretch gutter-b">


        <!--begin::Header-->
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Bills</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('bills.bill.create') }}"
                   class="btn btn-success btn-lg font-weight-bolder font-size-sm " style="font-size: 16px">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>

                    </span>Create an bill</a>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-0">
            <!--begin::Table-->
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
                        <th>Bill Date</th>
                        <th>Payment Status</th>
                        <th>Due</th>
                        <th class="text-right">Amount</th>
                        <th class="pr-0 text-right" style="min-width: 150px">action</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($bills as $bill)

                        <tr>

                            <td class="pl-0">
                                <label class="checkbox checkbox-lg checkbox-inline">
                                    <input type="checkbox" value="1">
                                    <span></span>
                                </label>
                            </td>
                            <td class="text-center ">
                                <a class="font-weight-bolder d-block font-size-lg underline text-left bill_number"
                                   href="{{ route('bills.bill.show',$bill->id) }}">
                                    <i class="fa fa-external-link-alt font-normal text-secondary"
                                       style="font-size: 10px"></i>
                                    {{ $bill->bill_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('bills.bill.show',$bill->id) }}"
                                   class="text-dark-75 font-weight-bolder d-block font-size-lg bill_number">{{ optional($bill->customer)->name }}</a>
                                <span
                                    class="text-muted font-weight-bold">{{ optional($bill->customer)->email }}</span>
                            </td>
                            <td class="pl-0">
                                <a href="{{ route('bills.bill.show',$bill->id) }}"
                                   class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg bill_number">{{ \Carbon\Carbon::parse($bill->bill_date)->format('d/m/Y') }}</a>

                                @if($bill->due_date)
                                    <span
                                        class="text-muted font-weight-bold text-muted d-block">Due on {{ \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bolder  ">
                                    @php
                                        $class = '';
                                        if ($bill->payment_status == \App\Models\Bill::Paid) {
                                               $class = "badge badge-primary";
                                            }elseif($bill->payment_status == \App\Models\Bill::Partial){
                                            $class = "badge badge-warning";
                                            }else{
                                            $class = "badge badge-secondary";

                                            }
                                    @endphp
                                    <span style="font-size: 16px"
                                          class="{{ $class }}">{{ $bill->payment_status }}</span>
                                </div>
                            </td>
                            <td>
                                @if($bill->due>0)
                                    <span
                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $bill->due }}</span>
                                @endif

                            </td>
                            <td class="text-right">
                                <div class="font-weight-bolder  ">
                                    <span
                                        style="font-size: 20px"><small>{{ $bill->currency }}</small>{{ number_format($bill->total,2) }} </span>
                                </div>
                            </td>
                            <td class="pr-0 text-right">
                                @if($bill->due > 0)
                                    <span style="text-decoration: underline"
                                          class=" font-weight-bolder text-success  font-size-lg underline  text-hover-danger cursor-pointer mx-4 recordPaymentBtn"
                                          bill_id="{{ $bill->id }}" currency="{{ $bill->currency }}"
                                          bill_number="{{ $bill->bill_number }}"
                                          due="{{ $bill->due }}"> Receive Payment</span>
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
                                        <a href="{{ route('bills.bill.send',$bill->id) }}"
                                           class="dropdown-item btn">
                                            <span class="far fa-envelope-open mx-4"></span> <strong> Bill
                                                Email</strong>
                                        </a>
                                        <a href="javascript:;"
                                           share_link="{{ route('bills.bill.share',$bill->secret) }}"

                                           class="dropdown-item btn shareLink">
                                            <span class="fa fa-share mx-4"></span> <strong>Get Share Link</strong>
                                        </a>
                                        <a href="{{ route('bills.bill.edit',$bill->id) }}"
                                           class="dropdown-item btn">
                                            <span class="fa fa-pencil-alt mx-4"></span> <strong>Edit</strong>
                                        </a>

                                        <a class="dropdown-item btn" href="javascript:;"
                                           onclick="return confirm('Click Ok to delete Bill')">
                                            <form method="POST"
                                                  action="{!! route('bills.bill.destroy', $bill->id) !!}">
                                                {{ csrf_field() }}

                                                @method('DELETE')
                                                <span class="fa fa-trash-alt mx-4"></span>
                                                <span>
                                                    <strong>Delete</strong>
                                                </span>

                                            </form>
                                        </a>
                                    </div>
                                </div>


                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
                <div class="float-right">
                    {!! $bills->links() !!}
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

    <script>
        $(document).ready(function () {
            $('.recordPaymentBtn').on('click', function () {
                let bill_id = $(this).attr('bill_id')
                let currency = $(this).attr('currency')
                let due = $(this).attr('due')
                let bill_number = $(this).attr('bill_number')
                $('#bill_id').val(bill_id)
                $('.currency').text(currency)
                $('.bill_number').text(bill_number)
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

            $('.bill_number').tooltip({'title': 'Show Bill'});

        })
    </script>

@endsection


