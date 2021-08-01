@extends('acc::layouts.app')

@section('css')
    <style>
        .rounded {
            border-color: #065a92a3 !important;
        }
    </style>
@endsection
@section('content')

    <div class="card mx-auto rounded mt-4" style="width: 70%">
        <form action="{{ route('estimates.estimate.send_estimate_mail',$estimate->id) }}" method="post">
            @csrf

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right">
                        <label class="font-weight-bolder" style="font-size: 16px"> From<span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="input-group col-lg-6">
                        <input type="text" name="from" id="from" class="form-control" placeholder="From Email"
                               value="{{ $from }}" readonly style="cursor: no-drop;background-color: whitesmoke"/>

                    </div>
                    <div class="col">
                        <b class="far fa-question-circle ml-4 mb-auto" style="font-size: 20px" data-toggle="tooltip"
                           title="You can only send from verified email addresses"></b>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right">
                        <label class="font-weight-bolder" style="font-size: 16px"> To<span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" name="to" id="to" value="{{ $to }}" class="form-control"
                               placeholder="another email here" required>
                        <small class="error text-danger" @if($to  != null) style="display: none"@endif>At least one
                            email is required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right">
                        <label class="font-weight-bolder" style="font-size: 16px"> Subject <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="input-group col-lg-6">
                        <input type="text" name="subject" id="subject" class="form-control" value="{{ $subject }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right">
                        <label class="font-weight-bolder" style="font-size: 16px"> Message <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="input-group col-lg-8">
                    <textarea type="text" name="message" id="message" class="form-control" rows="5">
                        {{ $message }}
                    </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right">

                    </div>
                    <div class="input-group col-lg-6">
                    <span class=" form-check form-check-inline form-control-plaintext">
                        <input id="send_to_business" class="form-check-input" name="send_to_business"
                               type="checkbox" >
                        &nbsp;
                        <label for="send_to_business" class="form-check-label">
                            <span class="text-secondary"> Send a copy to myself at <label
                                    style="text-decoration: underline"> {{ $settings->email??'' }}</label> </ul></label>
                    </span>
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right">

                    </div>
                    <div class="input-group col-lg-6">
                    <span class=" form-check form-check-inline form-control-plaintext">
                        <input id="attach_pdf" class="form-check-input" name="attach_pdf"
                               type="checkbox" checked>
                        &nbsp;
                        <label for="attach_pdf" class="form-check-label text-secondary">
                            Attach the invoice as a PDF
                        </label>
                    </span>
                    </div>

                </div>
                <div class="form-group row ">
                    <div class="col-form-label col-lg-4 ">

                    </div>
                    <div class="input-group col-lg-6">
                        <button type="submit" class="btn btn-primary btn-lg font-weight-bolder ml-auto">
                            <i class="fa fa-send"></i> SEND
                        </button>
                    </div>

                </div>

            </div>
        </form>
    </div>


@endsection

@section('js')

    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script>


        $(document).ready(function () {
            // $('#to').select2()
            var tagify = new Tagify(document.getElementById('to'))
            $('#to').on('change', function () {
                let value = $(this).val();
                if (!value) {
                    $('.error').show()
                } else {
                    $('.error').hide()
                }
                console.log()
            })
            CKEDITOR.replace('message');

        })
    </script>
@endsection
