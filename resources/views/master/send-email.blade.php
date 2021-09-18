@extends('master.master-layout')


@section('content')
    <div class="container">
        <form action="{{ route('master.send_email_store') }}" method="post">
            @csrf
            <input type="text" name="subject" class="form-control" placeholder="Business Name" value="InvoicePedia"
                   required>
            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
            <textarea class="form-control" name="body" id="body" cols="30" rows="10" placeholder="HTML TEMPLATE "></textarea>
            <textarea class="form-control" name="emails" id="emails" cols="30" rows="10" placeholder="Emails Comma Separated"></textarea>
            <br> <input id="client" type="checkbox" name="client">

            <label for="client">
                All Client
            </label>
            <br> <input id="customer" type="checkbox" name="customer">

            <label for="customer">
                All Customer
            </label>
            <br>
            <input id="vendor" type="checkbox" name="vendor">
            <label for="vendor">
                All Vendor
            </label>
            <br>
            <button class="btn btn-primary">Send Email</button>
        </form>
    </div>
@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>

        $(document).ready(function () {

        })
        // CKEDITOR.replace( 'body' );
    </script>
@endsection
