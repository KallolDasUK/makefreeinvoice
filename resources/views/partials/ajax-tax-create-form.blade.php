<div class="modal fade" id="taxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">
        <form id="createTaxForm" method="post" action="{{ route('taxes.tax.store') }}" index="">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">Tax Name</label>
                                <span class="text-danger font-bolder">*</span>
                                <input class="form-control" name="name" type="text" id="name"
                                       placeholder="ex. Sales Tax">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="value">Value (%)</label>
                                <span class="text-danger font-bolder">*</span>
                                <input class="form-control" name="value" type="number" placeholder="ex. 5.5" step="any"
                                       id="value"/>
                            </div>
                        </div>
                        <input type="text" value="%" name="tax_type" hidden>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeProduct">Save Tax</button>
                </div>

            </div>
        </form>

    </div>
</div>


