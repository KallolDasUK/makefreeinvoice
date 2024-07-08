<div class="modal fade" id="bankTransferModal" tabindex="-1" role="dialog" aria-labelledby="bankTransferModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="bankTransferForm" action="{{ route('bank.bank.store') }}" method="post">
            @csrf
           
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bank Transfer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close fs-18 text-primary"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" value="transfer">

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="transfer_date" class="col-form-label text-danger">Date *:</label>
                                <input type="date" class="form-control {{ $errors->has('transfer_date') ? 'is-invalid' : '' }}" id="transfer_date" name="transfer_date" required>
                                {!! $errors->first('transfer_date', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="deposit_to" class="col-form-label text-danger">Account From *:</label>
                                <select id="deposit_to_b" class="form-control" name="deposit_to" required>
                                    @foreach ($depositAccounts as $account)
                                    @if (url()->current() !==  env('APP_URL').'/app' || $account->ledger_name !== 'Cash A/C')
                                    <option
                                        value="{{ $account->id }}" {{ $account->id == \Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} >
                                        {{ $account->ledger_name }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('deposit_to', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="account_to" class="col-form-label text-danger">Account To *:</label>
                                <select id="accountNameB" class="form-control" name="account_to" required>
                                    @foreach ($depositAccounts as $account)
                                    @if (url()->current() !==  env('APP_URL').'/app' || $account->ledger_name !== 'Cash A/C')
                                        <option
                                            value="{{ $account->id }}" {{ $account->id == \Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} >
                                            {{ $account->ledger_name }}
                                        </option>
                                    @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('account_to', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="amount" class="col-form-label text-danger">Amount *:</label>
                                <input type="number" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" id="amount" name="amount" step="any" required>
                                {!! $errors->first('amount', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="note" class="col-form-label">Note :</label>
                                <textarea placeholder="Note" id="note" name="note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="transfer-response-msg"></div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="storeBankTransferBtn">
                                <span class="spinner-grow spinner-grow-sm spinner d-none" role="status"
                                        aria-hidden="true"></span>
                                Save</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
