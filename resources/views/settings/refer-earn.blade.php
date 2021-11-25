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
        <div class="row">
            <div class="col">
                <div class="form-group">

                    <h3 class="font-weight-bolder text-center">Your Affiliate Link</h3>

                    <div class="row">
                        <input type="text" class="form-control col-9" id="refer_link" name="refer_link" readonly
                               value="{{ route('register',['via'=>$user->affiliate_tag]) }}" style="font-size: 14px">
                        <button id="copyLink" class="btn btn-secondary mx-4 col">Copy Link</button>
                    </div>
                    <div class="row">
                        <div class="col-6 mt-4">
                            <div class="card ">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="card-body ">
                                        <button class="btn btn-primary" style="width: 100%">
                                            <i class="fa fa-outdent"></i>
                                            Withdraw Fund</button>
                                        <hr>
                                        <button class="btn btn-info" style="width: 100%">
                                            <i class="fa fa-history"></i>
                                            Payment History</button>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <h2>Frequently Asked Questions</h2>
                <hr>

                <div class="accordion accordion-toggle-arrow" id="accordionExample1">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" data-toggle="collapse" data-target="#collapseOne1">
                                Can anyone join the InvoicePedia Affiliate Program?
                            </div>
                        </div>
                        <div id="collapseOne1" class="collapse show" data-parent="#accordionExample1">
                            <div class="card-body">
                                YES
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo1">
                                When do I get paid?
                            </div>
                        </div>
                        <div id="collapseTwo1" class="collapse" data-parent="#accordionExample1">
                            <div class="card-body">
                                ...
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree1">
                                What form of payment will I receive?
                            </div>
                        </div>
                        <div id="collapseThree1" class="collapse" data-parent="#accordionExample1">
                            <div class="card-body">
                                1. &nbsp;Bank Transfer <br>
                                2. &nbsp;Bkash <br>
                                3. &nbsp;Nagad
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

            </div>
        </div>

        <div class="row mb-4">
            <div class="col-3 ">

                <div class="card ">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-body ">
                            Total Referred User
                            <div class="stage">
                                <div class="ml-4">{{ $totalReferredUser }}</div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <div class="col-3 ">

                <div class="card ">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-body ">
                            Total Earnings
                            <div class="stage">
                                <div class="ml-4">{{ $totalEarnings }}</div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <div class="col-3">
                <div class="card ">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-body ">
                            Available Balance
                            <div class="stage">
                                <div class="ml-4">{{ $balance }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-3">
                <div class="card ">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-body ">
                            Available Balance
                            <div class="stage">
                                <div class="ml-4">{{ $balance }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Joined</th>
                        <th scope="col">Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($affiliatedUsers as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->last_active_at)->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"><h2>You did not referred any users yet. You can <code>earn</code> by
                                    referring user.</h2>
                            </td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>


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

