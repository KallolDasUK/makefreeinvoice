<div class="modal fade" id="paymentMethodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">
        <form id="createPaymentMethodForm" method="post" action="{{ route('payment_methods.payment_method.store') }}">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">Payment Method Name</label>
                                <span class="text-danger font-bolder">*</span>
                                <input class="form-control" name="name" type="text" id="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="is_default">Should be selected automatically?</label>
                                <input class="form-check" name="is_default" type="checkbox"
                                       id="is_default"/>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storePaymentMethodBtn">
                        <span class="spinner-grow spinner-grow-sm spinner d-none" role="status"
                              aria-hidden="true"></span>
                        Save Payment Method
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>


