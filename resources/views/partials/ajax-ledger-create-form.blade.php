<div class="modal fade" id="ledgerModal" role="dialog" aria-labelledby="ledgerModalLabel"
     aria-hidden="true" style="z-index: 10000 !important;overflow: hidden">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">
        <form id="createLedgerForm" method="post" action="{{ route('ledgers.ledger.store') }}" index="">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="text-danger font-bolder" for="name">Account Name *</label>

                                <input class="form-control" name="ledger_name" type="text" id="ledger_name"
                                       minlength="1">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="value" class="text-danger font-bolder">Account Group *</label>

                                <select class="form-control" id="ledger_group_id" name="ledger_group_id">
                                    <option></option>
                                    @foreach (\Enam\Acc\Models\LedgerGroup::all() as $ledgerGroup)
                                        @if($ledgerGroup->group_name =='')
                                            @continue
                                        @endif
                                        <option
                                            value="{{ $ledgerGroup->id }}"> {{ $ledgerGroup->group_name??'-' }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="text" name="is_default" hidden value="0">


                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="font-bolder" for="name">Opening Amount</label>

                                <input class="form-control" name="opening" type="number" step="any" id="opening">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="value" class=" font-bolder">Opening Type</label>

                                <select class="form-control" id="opening_type" name="opening_type">
                                    <option value="" style="display: none;" selected>--- Opening Type ---
                                    </option>
                                    @foreach ([ 'Dr', 'Cr'] as $text)
                                        <option value="{{ $text }}"> {{ $text }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeLedger">
                        <span class="spinner-grow spinner-grow-sm spinner d-none" role="status"
                              aria-hidden="true"></span>
                        Save Account
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


