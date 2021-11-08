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





    <div class="card card-custom card-stretch gutter-b">


        <!--begin::Header-->
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Estimates</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('estimates.estimate.create') }}"
                   class="btn btn-success btn-lg font-weight-bolder font-size-sm  {{ ability(\App\Utils\Ability::ESTIMATE_CREATE) }}" style="font-size: 16px">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>

                    </span>Create an estimate</a>
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
                        <th class="text-start">Estimate Number</th>
                        <th class="pr-0">Client</th>
                        <th>Estimate Date</th>

                        <th class="text-right">Amount</th>
                        <th class="pr-0 text-right" style="min-width: 150px">action</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($estimates as $estimate)

                        <tr>

                            <td class="pl-0">
                                <label class="checkbox checkbox-lg checkbox-inline">
                                    <input type="checkbox" value="1">
                                    <span></span>
                                </label>
                            </td>
                            <td class="text-center">
                                <a class="font-weight-bolder d-block font-size-lg underline text-left estimate_number "
                                   href="{{ route('estimates.estimate.show',$estimate->id) }}">
                                    <i class="fa fa-external-link-alt font-normal text-secondary"
                                       style="font-size: 10px"></i>
                                    {{ $estimate->estimate_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('estimates.estimate.show',$estimate->id) }}"
                                   class="text-dark-75 font-weight-bolder d-block font-size-lg estimate_number btn ">{{ optional($estimate->customer)->name }}</a>
                                <span
                                    class="text-muted font-weight-bold">{{ optional($estimate->customer)->email }}</span>
                            </td>
                            <td class="pl-0">
                                <a href="{{ route('estimates.estimate.show',$estimate->id) }}"
                                   class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg estimate_number">{{ \Carbon\Carbon::parse($estimate->invoice_date)->format('d/m/Y') }}</a>

                                @if($estimate->due_date)
                                    <span
                                        class="text-muted font-weight-bold text-muted d-block">Due on {{ \Carbon\Carbon::parse($estimate->due_date)->format('d/m/Y') }}</span>
                                @endif
                            </td>

                            <td class="text-right">
                                <div class="font-weight-bolder  ">
                                    <span
                                        style="font-size: 20px"><small>{{ $estimate->currency }}</small>{{ number_format($estimate->total,2) }} </span>
                                </div>
                            </td>
                            <td class="pr-0 index text-right">
                                <a href="{{ route('estimates.estimate.convert_to_invoice',$estimate->id) }}"
                                   onclick="return confirm('Are sure to convert estimate to invoice?')"
                                   style="text-decoration: underline"
                                   class=" font-weight-bolder text-success  font-size-lg underline  text-hover-danger cursor-pointer mx-4 recordPaymentBtn"
                                > Make Invoice</a>
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
                                    <div class="dropdown-menu float-left" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('estimates.estimate.show',[$estimate->id,'print'=>true]) }}"
                                           class="dropdown-item btn  {{ ability(\App\Utils\Ability::ESTIMATE_READ) }}" >
                                            <span class="fa fa-print mx-4"></span> <strong>
                                                Print</strong>
                                        </a>
                                        <a href="{{ route('estimates.estimate.show',[$estimate->id,'download'=>true]) }}"
                                           class="dropdown-item btn  {{ ability(\App\Utils\Ability::ESTIMATE_READ) }}" >
                                            <span class="fa fa-download mx-4"></span> <strong>Download</strong>
                                        </a>
                                        <a href="{{ route('estimates.estimate.send',$estimate->id) }}"
                                           class="dropdown-item btn  {{ ability(\App\Utils\Ability::ESTIMATE_READ) }}">
                                            <span class="far fa-envelope-open mx-4"></span> <strong>Email
                                                Estimate</strong>
                                        </a>
                                        <a href="javascript:;"
                                           share_link="{{ route('estimates.estimate.share',$estimate->secret) }}"

                                           class="dropdown-item btn shareLink  {{ ability(\App\Utils\Ability::ESTIMATE_READ) }}">
                                            <span class="fa fa-share mx-4"></span> <strong>Get Share Link</strong>
                                        </a>
                                        <a href="{{ route('estimates.estimate.edit',$estimate->id) }}"
                                           class="dropdown-item btn  {{ ability(\App\Utils\Ability::ESTIMATE_EDIT) }}">
                                            <span class="fa fa-pencil-alt mx-4"></span> <strong>Edit</strong>
                                        </a>


                                        <form method="POST" class="text-danger "
                                              action="{{route('estimates.estimate.destroy', $estimate->id) }}">
                                            {{ csrf_field() }}

                                            @method('DELETE')
                                            <button type="submit" class="btn dropdown-item text-danger"
                                                    {{ ability(\App\Utils\Ability::ESTIMATE_DELETE) }}
                                                    onclick="if (!confirm('Are you sure?')) { return false }"><span>                                                 <span
                                                        class="fa fa-trash-alt mx-4"></span>
                                                    Delete</span></button>


                                        </form>

                                    </div>
                                </div>


                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
                <div class="float-right">
                    {!! $estimates->links() !!}
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
            $('.estimate_number').tooltip({'title': 'Show Estimate'});

        })
    </script>

@endsection


