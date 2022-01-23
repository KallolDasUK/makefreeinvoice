@extends('master.master-layout')


@section('content')
    <div class="container">
        <form action="{{ route('master.send_email_store') }}" method="post">
            @csrf

            <button class="btn btn-primary">Send Email</button>
        </form>
    </div>
@endsection

@section('js')

    <script>

        $(document).ready(function () {

        })
        // CKEDITOR.replace( 'body' );
    </script>
@endsection
