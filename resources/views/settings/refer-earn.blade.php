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
    @include('partials.settings-tab',['page'=>'refer_earn'])

    <br>
    <br>


    <div>
        @csrf
        <div class="form-group">

            <h1 class="font-weight-bolder text-center">Your Affiliate Link</h1>

            <div class="row">
                <input type="text" class="form-control col-9" id="refer_link" name="refer_link" readonly
                       value="{{ route('register',['via'=>$user->affiliate_tag]) }}" style="font-size: 25px">
                <button id="copyLink" class="btn btn-secondary mx-4 col">Copy Link</button>
            </div>
        </div>
        @if(count($user->referred) > 0)
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Joined</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->referred as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <h2>You did not referred any users yet. You can <code>earn</code> by referring user.</h2>
                </div>
            </div>
        @endif


    </div>


@endsection

@push('js')
    <script src="{{ asset('js/subscriptions/subscribe.js') }}"></script>
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).val()).select();
            document.execCommand("copy");
            $temp.remove();
            alert('Affiliate Link Copied')
        }

        $(document).ready(function () {
            $('#copyLink').on('click', function () {
                copyToClipboard($('#refer_link'))
            })
        })
    </script>
@endpush

