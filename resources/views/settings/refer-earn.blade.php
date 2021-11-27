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
                                        <button class="btn btn-primary" style="width: 100%" data-toggle="modal"
                                                data-target="#withdrawModal">
                                            <i class="fa fa-outdent"></i>
                                            Withdraw Fund
                                        </button>
                                        <hr>
                                        <button class="btn btn-info" style="width: 100%" data-toggle="modal"
                                                data-target="#paymentHistoryModal">
                                            <i class="fa fa-history"></i>
                                            Payment History
                                        </button>


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
                                <div class="ml-4">{{ decent_format_dash_if_zero($totalEarnings) }}</div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <div class="col-3">
                <div class="card ">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-body ">
                            Withdrawn
                            <div class="stage">
                                <div class="ml-4">{{ decent_format_dash_if_zero($totalWithdraw) }}</div>
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
                                <div class="ml-4">{{ decent_format_dash_if_zero($balance) }}</div>
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

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <!--Payment History Modal -->
    <div class="modal fade" id="paymentHistoryModal" tabindex="-1" role="dialog"
         aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentHistoryModalLabel">Payment History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th> Date</th>
                            <th> Amount</th>
                            <th> Description</th>
                            <th> Status</th>
                        </tr>
                        @forelse($histories as $history)
                            <tr>
                                <td> {{ $history->date }}</td>
                                <td> {{ decent_format_dash_if_zero($history->amount) }}</td>
                                <td> {{ $history->note }}</td>
                                <td>
                                    @if($history->status=="Approved")
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($history->status=="Processing")
                                        <span class="badge badge-warning">Processing</span>
                                    @elseif($history->status=="Rejected")
                                        <span class="badge badge-danger">Rejected</span>
                                    @else
                                        {{ $history->status }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"> No Transactions.</td>
                            </tr>
                        @endforelse

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel">Withdraw Funds</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($balance > 0)
                        <form id="withdrawForm" action="{{ route('ajax.withdrawFund') }}">
                            @csrf

                            <div class="form-group">
                                <label for="amount">Withdraw Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" required
                                       max="{{ $balance }}"  step="any" value="{{ $balance }}">
                            </div>
                            <div class="form-group">
                                <label for="payment_method">Payment Information</label>
                                <textarea required class="form-control" name="payment_method" id="payment_method"
                                          cols="30"
                                          rows="7"
                                          placeholder="Bank Name: &#10;A/C Name: &#10;or &#10;BKash: &#10;or &#10;Nagad: &#10;"></textarea>


                                <p>It may take upto 3 business days to complete the transfer.</p>
                            </div>
                        </form>
                    @else
                        Not have enough balance to withdraw.
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="$('#withdrawForm').submit()" class="btn btn-primary">Request
                        Withdraw
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let balance = {{ $balance }};
    </script>
    <script src="{{ asset('js/subscriptions/subscribe.js') }}"></script>
    <script src="{{ asset('js/refer-earn.js') }}"></script>

@endpush

