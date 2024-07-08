<div class="modal fade" id="bankWithdrawModal" tabindex="-1" role="dialog" aria-labelledby="bankWithdrawLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="bankWithdrawForm" action="{{ route('bank.bank.store') }}" method="post">
            @csrf
           
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bankWithdrawLabel">Bank Withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close fs-18 text-primary"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" value="withdraw">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="withdraw_date" class="col-form-label text-danger">Date *:</label>
                                <input type="date" class="form-control {{ $errors->has('withdraw_date') ? 'is-invalid' : '' }}" id="withdraw_date" name="withdraw_date">
                                {!! $errors->first('withdraw_date', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="deposit_to" class="col-form-label text-danger">Select Account *:</label>
                                <select id="deposit_to_c" class="form-control" name="deposit_to">
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
                        <div class="col-6">
                            <div class="form-group">
                                <label for="withdraw_amount" class="col-form-label text-danger">Amount *: </label>
                                <input class="form-control {{ $errors->has('withdraw_amount') ? 'is-invalid' : '' }}" name="withdraw_amount" type="number" step="any" id="withdraw_amount">
                                {!! $errors->first('withdraw_amount', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="cheque_no" class="col-form-label">Cheque No :</label>
                                <input class="form-control {{ $errors->has('cheque_no') ? 'is-invalid' : '' }}" name="cheque_no" type="text" id="cheque_no">
                                {!! $errors->first('cheque_no', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="cheque_date" class="col-form-label">Cheque Date :</label>
                                <input type="date" class="form-control {{ $errors->has('cheque_date') ? 'is-invalid' : '' }}" id="cheque_date" name="cheque_date">
                                {!! $errors->first('cheque_date', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="withdraw_note" class="col-form-label">Note :</label>
                                <textarea placeholder="Note" id="withdraw_note" name="withdraw_note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                    
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="withdraw-response-msg"></div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="storeBankWithdrawBtn">
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
