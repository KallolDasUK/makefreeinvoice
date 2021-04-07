@extends('acc::layouts.app')


@section('content')

    <div class="card card-default">

        @if(Session::has('success_message'))
            <div class="alert alert-success">
                <span class="mdi mdi-information-outline"></span>
                {!! session('success_message') !!}

                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="post" action="{{ route('accounting.settings.update') }}" >
                @csrf

                <div class="form-group">
                    <label>Business Name </label>
                    <input type="text" class="form-control" name="name" value="{{ $settings->name }}">

                </div><div class="form-group">
                    <label>Phone </label>
                    <input type="text" class="form-control" name="phone" value="{{ $settings->phone }}">

                </div>
                <div class="form-group">
                    <label>Email </label>
                    <input type="email" class="form-control" name="email" value="{{ $settings->email }}">

                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea type="text" class="form-control" name="address" >{{ $settings->address }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#ledger_name').focus()
            $('#ledger_group_id').select2();
        })
    </script>
@endsection
