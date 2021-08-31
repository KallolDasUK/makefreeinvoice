<div class="modal fade" id="subscriptionPaymentModal" data-backdrop="static" data-keyboard="false" tabindex="-3"
     role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">
        <form id="subscriptionPaymentForm" method="post" action="{{ route('subscribe.store') }}"
              data-secret="{{ $intent->client_secret }}">
            <input type="text" id="priceID" hidden name="api_id">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <img src="{{ asset('images/payment methods.PNG') }}" alt="Payment Method" height="80" style="width: 100%">
                        </div>
                        <div class="col-12">
                            <div class="p-4">
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <h4 class="mb-10 font-weight-bold text-dark">Enter your Payment Details</h4>
                                    <div class="row">

                                        <div class="col-12">
                                            <!--begin::Input-->
                                            <div class="form-group fv-plugins-icon-container">
                                                <label>Name on Card</label>
                                                <input id="card-holder-name" type="text"
                                                       class="form-control  input-sm form-control-solid form-control-lg"
                                                       name="card_holder_name" placeholder="Card Name"
                                                       value="{{ auth()->user()->name??'' }}">
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="col-12">
                                            <div id="card-element"></div>
                                            <div id="card-errors" role="alert"></div>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            onclick="$('#subscriptionPaymentModal').modal('hide')">Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="payment_btn">
                        <span class="spinner-grow spinner-grow-sm spinner d-none" role="status"
                              aria-hidden="true"></span>
                        Confirm Payment
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>



