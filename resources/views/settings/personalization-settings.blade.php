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
    @include('partials.settings-tab',['page'=>'personalization_settings'])

    <br>


    <form method="post" action="{{ route('accounting.settings.pos_settings_store') }}">
        @csrf

        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_stock" class="font-weight-bolder ">Show Youtube Videos</label>
            </div>
            <div class="col-lg-4 bg-secondary">
                <input type="hidden" name="show_youtube_videos" value="0">
                <input id="show_youtube_videos" type="checkbox" name="show_youtube_videos"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->show_youtube_videos??'1')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_price" class="font-weight-bolder ">Show Support Number</label>
            </div>
            <div class="col-lg-4 bg-secondary">
                <input type="hidden" name="show_support_number" value="0">
                <input id="show_support_number" type="checkbox" name="show_support_number"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->show_support_number??'1')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_name" class="font-weight-bolder ">Show Messenger Chat Box</label>
            </div>
            <div class="col-lg-4 bg-secondary">
                <input type="hidden" name="show_messenger_chat_box" value="0">
                <input id="show_messenger_chat_box" type="checkbox" name="show_messenger_chat_box"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->show_messenger_chat_box??'1')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col-form-label col-lg-2 ">
                <label for="pos_hide_name" class="font-weight-bolder ">Manual Customer ID Input</label>
            </div>
            <div class="col-lg-4 bg-secondary">
                <input type="hidden" name="customer_id_feature" value="0">
                <input id="customer_id_feature" type="checkbox" name="customer_id_feature"
                       class="form-control check-mark checkbox form-check-input"
                       value="1" {{ ($settings->customer_id_feature??'0')?'checked':'' }}>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2 required">
                <label class="font-weight-bolder"> </label>
            </div>
            <div class="col-lg-4 text-right">
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

                if (this.checked) {
                    $('#new_password,#confirmed_password').attr('type', 'text')

                } else {
                    $('#new_password,#confirmed_password').attr('type', 'password')

                }
            })
        })
    </script>
@endpush

