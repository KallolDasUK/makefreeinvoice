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
                                <input type="text" class="form-control " id="name" name="name">
                            </div>
                        </div>
                        @if($settings->customer_id_feature??'0')
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-form-label" for="customer_ID">Customer ID</label>
                                    <input class="form-control" name="customer_ID" type="text" id="customer_ID">
                                </div>
                            </div>
                        @endif
                        <div class="col">
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Phone :</label>
                                <input class="form-control " id="phone" name="phone"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div>
                                <label for="opening">Opening</label>
                                <div>
                                    <input class="form-control" name="opening" type="number" step="any" id="opening">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <label for="opening_type">Opening Type</label>
                                <div>
                                    <select class="form-control" id="opening_type" name="opening_type">

                                        @foreach (['Dr' => 'Previous Due','Cr' => 'Advance'] as $key => $text)
                                            <option
                                                value="{{ $key }}">
                                                {{ $text }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
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
                                <textarea placeholder="Street 1" id="street_2" name="street_2" class="form-control"
                                          style="margin-top: 0px; margin-bottom: 0px; height: 62px;"></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <select id="country" class="form-control" name="country">
                                <option value="" disabled selected></option>
                                @foreach(countries() as $country)
                                    <option value="{{ $country }}"> {{ $country }}</option>
                                @endforeach
                            </select></div>
                        <div class="col-lg-4">
                            <input placeholder="City" id="city" name="city" class="form-control" type="text">
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <input placeholder="State/Province " class="form-control" type="text" name="state">

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="">&nbsp;</label>
                            <input placeholder="Zip/Postal Code" id="zip_post" name="zip_post" class="form-control"
                                   type="text">
                        </div>
                        <div class="col">
                            <label for="sr_id">Sales Representative</label>
                            <select name="sr_id" id="sr_id" class="form-control searchable">
                                <option></option>
                                @foreach(\App\Models\SR::all() as $sr)
                                    <option value="{{ $sr->id }}"> {{ $sr->name }} {{ $sr->phone }}</option>
                                @endforeach
                            </select>
                        </div>
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
