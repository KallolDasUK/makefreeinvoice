@extends('acc::layouts.app')

@section('css')

@endsection
@section('content')


    <div class="card">
        <div class="card-body">
            <div class="mx-auto" style="width: 350px">
                <span class=" font-weight-bolder" style="text-transform: capitalize">403 FORBIDDEN</span>
                <hr>
                <h3>This is a pro feature </h3>
                <p>If you’re ready to take your business to the next level, you can upgrade your plan to use awesome
                    premium features</p>
                <a href="{{ route('subscriptions.settings') }}" class="btn btn-primary btn-lg" style="width: 100%">Upgrade
                    to Pro</a>

            </div>

        </div>

    </div>


@endsection

@push('js')

    <script>

        $(document).ready(function () {

        })


    </script>
@endpush
