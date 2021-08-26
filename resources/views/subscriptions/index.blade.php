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
    @include('partials.settings-tab',['page'=>'billings'])
    @include('partials.subscribe')


@endsection

@push('js')
    <script src="{{ asset('js/subscriptions/subscribe.js') }}"></script>

@endpush

