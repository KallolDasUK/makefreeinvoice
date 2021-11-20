@extends('acc::layouts.app')



@section('css')
    <style>
        .dropdown-toggle:hover {
            color: #0d71bb !important;
        }

        svg:hover {
            color: #0d71bb !important;
        }

        .dropdown-toggle::before {
            content: "";

            border-right: 0em solid !important;

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

    @include('partials.ajax-ledger-create-form')

    @include('partials.bill-payment-modal')

    <div class="card rounded  mb-4">
        <div class="">
            <div class="row align-items-center">
                <div class="col ">

                    <div class="card " style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Total Amount
                                <h3>{{ $settings->currency??'$' }}{{ decent_format_dash($totalAmount??'') }}</h3>
                            </div>
                            <div class="vertical-divider"></div>
                        </div>

                    </div>


                </div>
                <div class="col ">

                    <div class="card " style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Total Due
                                <h3>{{ $settings->currency??'$' }}{{ decent_format_dash($totalDue??'') }}</h3>
                            </div>
                            <div class="vertical-divider"></div>
                        </div>

                    </div>


                </div>
                <div class="col ">

                    <div class="card " style="border: none">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-body ">
                                Total Paid
                                <h3>{{ $settings->currency??'$' }}{{ decent_format_dash($totalPaid??'') }}</h3>
                            </div>
                            <div class="vertical-divider"></div>
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
                <span class="card-label font-weight-bolder text-dark">Bills</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm"></span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('bills.bill.create') }}"
                   class="btn btn-success btn-lg font-weight-bolder font-size-sm {{ ability(\App\Utils\Ability::BILL_CREATE) }}"
                   style="font-size: 16px">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>

                    </span>Create a bill</a>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-0">
            <form action="{{ route('bills.bill.index') }}">
                <div class="row align-items-center mb-4">

                    <div class="col-lg-3 col-xl-2">
                        <input name="q" type="text" class="form-control" placeholder="Bil Number #"
                               value="{{ $q }}"
                        >
                    </div>
                    <div class="mx-2">
                        <select name="vendor" id="vendor" class="form-control"
                                style="min-width: 200px;max-width: 200px">
                            <option></option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}"
                                        @if($vendor->id == $vendor_id) selected @endif>{{ $vendor->name }} {{ $vendor->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(auth()->user()->is_admin)
                        <div class="mx-2">
                            <select name="user_id" id="user_id" class="form-control"
                                    style="max-width: 130px">
                                <option></option>
                                @foreach(\App\Models\User::query()->where('client_id',auth()->user()->client_id)->get() as $user)
                                    <option value="{{ $user->id }}"
                                            @if($user->id == $user_id) selected @endif>{{ $user->name }} {{ $user->email }} </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="input-daterange input-group" id="start_date">
                                <input type="text" class="form-control col-2" name="start_date"
                                       value="{{ $start_date }}"
                                       placeholder="From">
                                <div class="input-group-append">
									<span class="input-group-text">
                                       ...
                                    </span>
                                </div>
                                <input type="text" class="form-control col-2" name="end_date" id="end_date"
                                       value="{{ $end_date }}"

                                       placeholder="To">
                                <button role="button" type="submit"
                                        class="btn btn-secondary px-6 mx-2 col-3 font-weight-bold">
                                    <i class="fas fa-sliders-h"></i>
                                    Filter
                                </button>

                                @if($start_date != null || $end_date != null || $vendor_id !=null || $q != null)
                                    <a href="{{ route('bills.bill.index') }}" title="Clear Filter"
                                       class="btn btn-icon btn-light-danger"> X</a>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </form>
            <div>
                @if(count($bills)>0)
                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                        <thead>
                        <tr class="text-left">
                            <th class="pl-0" style="width: 20px">
                                <label class="checkbox checkbox-lg checkbox-inline">
                                    <input type="checkbox" value="1">
                                    <span></span>
                                </label>
                            </th>
                            <th class="text-left">Bill Number</th>
                            <th class="pr-0">Vendor</th>
                            <th>Bill Date</th>
                            <th>Payment</th>
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
                                    <a class="font-weight-bolder d-block font-size-lg underline text-left bill_number {{ ability(\App\Utils\Ability::BILL_READ)=='disabled'?'no-link':'' }}"
                                       href="{{ route('bills.bill.show',$bill->id) }}">
                                        <i class="fa fa-external-link-alt font-normal text-secondary "
                                           style="font-size: 10px"></i>
                                        {{ $bill->bill_number }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('bills.bill.show',$bill->id) }}"
                                       class="text-dark-75 font-weight-bolder d-block font-size-lg bill_number {{ ability(\App\Utils\Ability::BILL_READ)=='disabled'?'no-link':'' }}">{{ optional($bill->vendor)->name }}</a>
                                    <span
                                        class="text-muted font-weight-bold">{{ optional($bill->vendor)->email }}</span>
                                </td>
                                <td class="pl-0">
                                    <a href="{{ route('bills.bill.show',$bill->id) }}"
                                       class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg bill_number  {{ ability(\App\Utils\Ability::BILL_READ)=='disabled'?'no-link':'' }}">{{ \Carbon\Carbon::parse($bill->bill_date)->toDateString() }}</a>

                                    @if($bill->due_date)
                                        <span
                                            class="text-muted font-weight-bold text-muted d-block">Due on {{ \Carbon\Carbon::parse($bill->due_date)->toDateString() }}</span>
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
                                        <span style="font-size: 12px"
                                              class="{{ $class }} ">{{ $bill->payment_status }}</span>
                                    </div>
                                </td>

                                <td class="text-right">
                                    <div class="font-weight-bolder  ">
                                    <span
                                        style="font-size: 20px"><small>{{ $bill->currency }}</small>{{ decent_format($bill->total,2) }} </span>

                                    </div>
                                    @if($bill->due>0)


                                        <span
                                            class=" font-weight-bold text-info d-block">Due :  {{ decent_format($bill->due) }}</span>

                                    @endif
                                </td>
                                <td class="pr-0 text-right">
                                    @if($bill->due > 0)
                                        <span style="text-decoration: underline"
                                              class=" font-weight-bolder text-success  font-size-lg underline  text-hover-danger cursor-pointer mx-4 billPaymentBtn"
                                              bill_id="{{ $bill->id }}" currency="{{ $bill->currency }}"
                                              bill_number="{{ $bill->bill_number }}"
                                              due="{{ $bill->due }}">Record Payment</span>
                                    @endif


                                    <div class="dropdown d-inline dropleft">
                                    <span class=" dropdown-toggle mr-4 " type="button" style="font-size: 25px"
                                          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false">
                                        <svg
                                            style="height: 35px;width: 35px"
                                            aria-hidden="true" focusable="false" data-prefix="far"
                                            data-icon="caret-circle-down" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512"
                                            class="svg-inline--fa fa-caret-circle-down fa-w-16 fa-3x"><path
                                                fill="currentColor"
                                                d="M157.1 216h197.8c10.7 0 16.1 13 8.5 20.5l-98.9 98.3c-4.7 4.7-12.2 4.7-16.9 0l-98.9-98.3c-7.7-7.5-2.3-20.5 8.4-20.5zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-48 0c0-110.5-89.5-200-200-200S56 145.5 56 256s89.5 200 200 200 200-89.5 200-200z"
                                                class=""></path></svg>
                                    </span>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <a href="javascript:;"
                                               share_link="{{ route('bills.bill.share',$bill->secret??'null') }}"

                                               class="dropdown-item btn shareLink {{ ability(\App\Utils\Ability::BILL_CREATE) }}">
                                                <span class="fa fa-share mx-4"></span> <strong>Get Share Link</strong>
                                            </a>
                                            <a href="{{ route('bills.bill.edit',$bill->id) }}"
                                               class="dropdown-item btn {{ ability(\App\Utils\Ability::BILL_EDIT) }}">
                                                <span class="fa fa-pencil-alt mx-4"></span> <strong>Edit</strong>
                                            </a>


                                            <form method="POST"
                                                  action="{!! route('bills.bill.destroy', $bill->id) !!}">
                                                {{ csrf_field() }}
                                                <button class="dropdown-item "
                                                        {{ ability(\App\Utils\Ability::BILL_DELETE) }}
                                                        onclick="return confirm('Click Ok to delete Bill')">
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

                @else
                    <div class="text-center">
                        <img style="text-align: center;margin: 0 auto;"
                             src="https://1.bp.blogspot.com/-oFZuUJWkeVI/YU2wRxUt26I/AAAAAAAAFKw/tA92-qZCPksDCerRYqgANfzaeF8xtGTFQCLcBGAsYHQ/s320/norecord.png"
                             alt="">
                    </div>
                @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $('.billPaymentBtn').on('click', function () {
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
                $('#billPaymentModal').modal('show')
            });
            $('#payment_method_id').select2()
            // $('#deposit_to').select2()
            $('#billPaymentForm').validate({
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        beforeSend: () => {
                            $('button[type=submit]').prop('disabled', true)
                        },
                        success: function (response) {
                            $('#billPaymentModal').modal('hide');
                            Swal.fire(response.success_message)
                                .then(function (result) {
                                    window.location.reload()
                                })
                            $('#billPaymentForm').trigger("reset");
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
            $('#vendor').select2({placeholder: 'All Vendor', allowClear: true})


            var datepicker = $.fn.datepicker.noConflict();
            $.fn.bootstrapDP = datepicker;
            $("#start_date,#end_date").bootstrapDP({

                autoclose: true,
                format: "yyyy-mm-dd",
                immediateUpdates: true,
                todayBtn: true,
                todayHighlight: true,
                clearBtn: true

            });
            $('#ledger_id').select2({
                placeholder: "--", allowClear: true
            }).on('select2:open', function () {
                let a = $(this).data('select2');
                let doExits = a.$results.parents('.select2-results').find('button')
                if (!doExits.length) {
                    a.$results.parents('.select2-results')
                        .append('<div><button  data-toggle="modal" data-target="#ledgerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Account</button></div>')
                        .on('click', function (b) {
                            $("#ledger_id").select2("close");
                        });
                }


            })
            /* Creating Ledger Account Via Ajax With Validation */
            $('#createLedgerForm').validate({
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        beforeSend: () => {
                            $('#storeLedger').prop('disabled', true)
                            $('.spinner').removeClass('d-none')
                        },
                        success: function (response) {
                            $('#ledgerModal').modal('hide');
                            let i = $('#createLedgerForm').attr('index') || 0;
                            if (i === 0 || i === '') {
                                $("#ledger_id").append(new Option(response.ledger_name, response.id));
                                $("#ledger_id").val(response.id)
                                $("#ledger_id").trigger('change')
                            } else {
                                ractive.push('ledgers', response)
                                ractive.set(`expense_items.${i}.ledger_id`, response.id)
                            }

                            console.log(ractive.get('taxes'))
                            $('#createLedgerForm').trigger("reset");
                            $('#storeLedger').prop('disabled', false)
                            $('.spinner').addClass('d-none')
                        },

                    });
                },
                rules: {
                    ledger_name: {required: true,},
                    ledger_group_id: {required: true,},
                    value: {required: true,},
                },
                messages: {
                    name: {required: "Name is required",},
                    sell_price: {required: "required",},
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        })
    </script>

@endsection


