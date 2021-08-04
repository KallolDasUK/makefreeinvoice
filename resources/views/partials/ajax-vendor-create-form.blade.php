<div class="modal fade" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">

        <form id="createVendorForm" action="{{ route('vendors.vendor.store') }}" method="post">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="col-form-label text-danger">Vendor Name *:</label>
                                <input type="text" class="form-control " id="name" name="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Phone :</label>
                                <input class="form-control " id="phone" name="phone"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Website :</label>
                                <input class="form-control " id="website" name="website"/>
                            </div>

                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email :</label>
                                <input class="form-control " id="email" name="email"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address :</label>
                        <div class="row">
                            <div class="col">
                                <textarea placeholder="Street 1" id="street_1" name="street_1"
                                          class="form-control"
                                          style="margin-top: 0px; margin-bottom: 0px; height: 62px;"></textarea>
                            </div>
                            <div class="col">
                                <textarea placeholder="Street 1" id="street_1" name="street_1" class="form-control"
                                          style="margin-top: 0px; margin-bottom: 0px; height: 62px;"></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <input placeholder="City" id="city" name="city" class="form-control" type="text">
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <input placeholder="State/Province *" class="form-control" type="text" name="state">

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <input placeholder="Zip/Postal Code" id="zip_post" name="zip_post" class="form-control"
                                   type="text">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeCustomerBtn">Save Vendor</button>
                </div>

            </div>
        </form>

    </div>
</div>
