<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">

        <form id="createCustomerForm" action="{{ route('customers.customer.store') }}" method="post">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="col-form-label text-danger">Name *:</label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Phone :</label>
                                <input class="form-control form-control-sm" id="phone" name="phone"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Website :</label>
                                <input class="form-control form-control-sm" id="website" name="website"/>
                            </div>

                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email :</label>
                                <input class="form-control form-control-sm" id="email" name="email"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address :</label>
                        <textarea class="form-control form-control-sm" id="address" name="address" cols="5" rows="5">

                    </textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeCustomerBtn">Save Customer</button>
                </div>

            </div>
        </form>

    </div>
</div>
