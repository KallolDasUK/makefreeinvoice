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
                <span class="card-label font-weight-bolder text-dark">Demand Orders</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm"></span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('purchase_orders.purchase_order.create') }}"
                   class="btn btn-success btn-lg font-weight-bolder font-size-sm  {{  ability(\App\Utils\Ability::PURCHASE_ORDER_CREATE) }}" style="font-size: 16px">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>

                    </span>Demand A Order</a>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-0">
            <form action="{{ route('purchase_orders.purchase_order.index') }}">
                <div class="row align-items-center mb-4">

                    <div class="col-lg-3 col-xl-2">
                        <input name="q" type="text" class="form-control" placeholder="Purchase Order Number #"
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
                                        class="btn btn-primary px-6 mx-2 col-3 font-weight-bold">
                                    <i class="fas fa-sliders-h"></i>
                                    Filter
                                </button>

                                @if($start_date != null || $end_date != null || $vendor_id !=null || $q != null)
                                    <a href="{{ route('purchase_orders.purchase_order.index') }}" title="Clear Filter"
                                       class="btn btn-icon btn-light-danger"> X</a>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </form>
            <div>
                @if(count($purchase_orders)>0)
                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                        <thead>
                        <tr class="text-left">
                            <th class="pl-0" style="width: 20px">
                                <label class="checkbox checkbox-lg checkbox-inline">
                                    <input type="checkbox" value="1">
                                    <span></span>
                                </label>
                            </th>
                            <th class="text-left">Purchase Order Number</th>
                            <th class="pr-0">Vendor</th>
                            <th>Bill Date</th>
                            <th>Payment</th>
                            <th class="text-right">Amount</th>
                            <th class="pr-0 text-right" style="min-width: 150px">action</th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($purchase_orders as $purchase_order)

                            <tr>

                                <td class="pl-0">
                                    <label class="checkbox checkbox-lg checkbox-inline">
                                        <input type="checkbox" value="1">
                                        <span></span>
                                    </label>
                                </td>
                                <td class="text-center ">
                                    <a class="font-weight-bolder d-block font-size-lg underline text-left bill_number"
                                       href="{{ route('purchase_orders.purchase_order.show',$purchase_order->id) }}">
                                        <i class="fa fa-external-link-alt font-normal text-secondary"
                                           style="font-size: 10px"></i>
                                        {{ $purchase_order->purchase_order_number }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('purchase_orders.purchase_order.show',$purchase_order->id) }}"
                                       class="text-dark-75 font-weight-bolder d-block font-size-lg bill_number">{{ optional($purchase_order->vendor)->name }}</a>
                                    <span
                                        class="text-muted font-weight-bold">{{ optional($purchase_order->vendor)->email }}</span>
                                </td>
                                <td class="pl-0">
                                    <a href="{{ route('purchase_orders.purchase_order.show',$purchase_order->id) }}"
                                       class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg bill_number">{{ \Carbon\Carbon::parse($purchase_order->bill_date)->toDateString() }}</a>

                                    @if($purchase_order->delivery_date)
                                        <span
                                            class="text-muted font-weight-bold text-muted d-block">Delivery on {{ \Carbon\Carbon::parse($purchase_order->delivery_date)->toDateString() }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bolder  ">
                                        @php
                                            $class = '';
                                            if ($purchase_order->payment_status_text == \App\Models\Bill::Paid) {
                                                   $class = "badge badge-primary";
                                                }elseif($purchase_order->payment_status_text == \App\Models\Bill::Partial){
                                                $class = "badge badge-warning";
                                                }else{
                                                $class = "badge badge-secondary";

                                                }
                                        @endphp
                                        <span style="font-size: 16px"
                                              class="{{ $class }} ">{{ $purchase_order->payment_status_text }}</span>
                                    </div>
                                </td>

                                <td class="text-right">
                                    <div class="font-weight-bolder  ">
                                    <span
                                        style="font-size: 20px"><small>{{ $purchase_order->currency }}</small>{{ decent_format($purchase_order->total,2) }} </span>

                                    </div>
                                    @if($purchase_order->due>0)

                                        <span
                                            class=" font-weight-bold text-info d-block">Due :  {{ decent_format($purchase_order->due) }}</span>

                                    @endif
                                </td>
                                <td class="pr-0 text-right">
{{--                                    @if(!$purchase_order->converted)--}}
{{--                                        <a style="text-decoration: underline"--}}
{{--                                           class=" font-weight-bolder text-success  font-size-lg underline  text-hover-danger cursor-pointer mx-4"--}}
{{--                                           onclick="return confirm('Are you sure? Got the order?')"--}}
{{--                                           href="{{ route('purchase_orders.purchase_order.convert_to_bill',$purchase_order->id) }}">Receive--}}
{{--                                            Order</a>--}}
{{--                                    @else--}}
{{--                                        <button--}}
{{--                                            type="button"--}}
{{--                                            class="btn btn-outline-info disabled  font-weight-bolder"--}}
{{--                                        >Order Received--}}
{{--                                        </button>--}}
{{--                                    @endif--}}
                                    @if(!$purchase_order->converted)
                                        <a class="border mx-4 text-center btn  {{  ability(\App\Utils\Ability::PURCHASE_ORDER_EDIT) }}"
                                           href="{{ route('purchase_orders.purchase_order.edit',$purchase_order->id) }}">
                                            <svg
                                                style="height: 25px;width: 25px"
                                                aria-hidden="true" focusable="false" data-prefix="far"
                                                data-icon="caret-circle-down" role="img"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="svg-inline--fa fa-caret-circle-down fa-w-16 fa-3x"
                                                version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                width="494.936px" height="494.936px" viewBox="0 0 494.936 494.936"
                                                xml:space="preserve"
                                                fill="currentColor"
                                            ><g>
                                                    <g>
                                                        <path d="M389.844,182.85c-6.743,0-12.21,5.467-12.21,12.21v222.968c0,23.562-19.174,42.735-42.736,42.735H67.157
			c-23.562,0-42.736-19.174-42.736-42.735V150.285c0-23.562,19.174-42.735,42.736-42.735h267.741c6.743,0,12.21-5.467,12.21-12.21
			s-5.467-12.21-12.21-12.21H67.157C30.126,83.13,0,113.255,0,150.285v267.743c0,37.029,30.126,67.155,67.157,67.155h267.741
			c37.03,0,67.156-30.126,67.156-67.155V195.061C402.054,188.318,396.587,182.85,389.844,182.85z"/>
                                                        <path d="M483.876,20.791c-14.72-14.72-38.669-14.714-53.377,0L221.352,229.944c-0.28,0.28-3.434,3.559-4.251,5.396l-28.963,65.069
			c-2.057,4.619-1.056,10.027,2.521,13.6c2.337,2.336,5.461,3.576,8.639,3.576c1.675,0,3.362-0.346,4.96-1.057l65.07-28.963
			c1.83-0.815,5.114-3.97,5.396-4.25L483.876,74.169c7.131-7.131,11.06-16.61,11.06-26.692
			C494.936,37.396,491.007,27.915,483.876,20.791z M466.61,56.897L257.457,266.05c-0.035,0.036-0.055,0.078-0.089,0.107
			l-33.989,15.131L238.51,247.3c0.03-0.036,0.071-0.055,0.107-0.09L447.765,38.058c5.038-5.039,13.819-5.033,18.846,0.005
			c2.518,2.51,3.905,5.855,3.905,9.414C470.516,51.036,469.127,54.38,466.61,56.897z"/>
                                                    </g>
                                                </g>
</svg>
                                        </a>
                                    @endif
                                    <form method="POST" style="display: inline-block"
                                          action="{!! route('purchase_orders.purchase_order.destroy', $purchase_order->id) !!}">
                                        {{ csrf_field() }}
                                        <button class="border mx-4 text-danger"
                                                style="height: 35px;width: 35px"
                                                {{  ability(\App\Utils\Ability::PURCHASE_ORDER_DELETE) }}
                                                onclick="return confirm('Click Ok to delete Bill')">
                                            @method('DELETE')

                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                 y="0px"
                                                 viewBox="0 0 473 473" xml:space="preserve"
                                                 fill="currentColor"

                                                 style="height: 25px;width: 25px"
                                                 aria-hidden="true" focusable="false" data-prefix="far"
                                                 data-icon="caret-circle-down" role="img"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 class="svg-inline--fa fa-caret-circle-down fa-w-16 fa-3x">
<g>
    <path d="M324.285,215.015V128h20V38h-98.384V0H132.669v38H34.285v90h20v305h161.523c23.578,24.635,56.766,40,93.477,40
		c71.368,0,129.43-58.062,129.43-129.43C438.715,277.276,388.612,222.474,324.285,215.015z M294.285,215.015
		c-18.052,2.093-34.982,7.911-50,16.669V128h50V215.015z M162.669,30h53.232v8h-53.232V30z M64.285,68h250v30h-250V68z M84.285,128
		h50v275h-50V128z M164.285,403V128h50v127.768c-21.356,23.089-34.429,53.946-34.429,87.802c0,21.411,5.231,41.622,14.475,59.43
		H164.285z M309.285,443c-54.826,0-99.429-44.604-99.429-99.43s44.604-99.429,99.429-99.429s99.43,44.604,99.43,99.429
		S364.111,443,309.285,443z"/>
    <polygon points="342.248,289.395 309.285,322.358 276.323,289.395 255.11,310.608 288.073,343.571 255.11,376.533 276.323,397.746
		309.285,364.783 342.248,397.746 363.461,376.533 330.498,343.571 363.461,310.608 	"/>
</g>
</svg>


                                        </button>
                                    </form>


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
                    {!! $purchase_orders->links() !!}
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


