@extends('acc::layouts.app')


@section('content')


    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="mdi mdi-information-outline"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
    @include('partials.settings-tab',['page'=>'change_password'])

    <br>
    <br>


    <form method="post" action="{{ route('settings.update_password.store') }}">
        @csrf
        <div class="form-group row">
            <div class="col-form-label col-lg-2 ">
                <label class="font-weight-bolder "> New Password</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="new_password" name="new_password" value="{{ old('new_password') }}">
                {!! $errors->first('new_password', '<p class="form-text text-danger">:message</p>') !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2 ">
                <label class="font-weight-bolder"> Confirmed Password</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="confirmed_password" name="confirmed_password"
                       value="{{ old('confirmed_password') }}">
                {!! $errors->first('confirmed_password', '<p class="form-text text-danger">:message</p>') !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2 required">
                <label class="font-weight-bolder"> </label>
            </div>
            <div class="col-lg-4 text-right">
                <input id="show" type="checkbox" checked>
                <label for="show" class="mr-4">Show Password</label>
                <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
            </div>
        </div>

    </form>


@endsection

@push('js')
    <script src="{{ asset('js/subscriptions/subscribe.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#show').on('change', function () {

                if (this.checked){
                    $('#new_password,#confirmed_password').attr('type', 'text')

                }else{
                    $('#new_password,#confirmed_password').attr('type', 'password')

                }
            })
        })
    </script>
@endpush

