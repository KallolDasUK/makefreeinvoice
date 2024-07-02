<div class="modal fade" id="bankDepositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form id="bankDepositForm" action="{{ route('bank.bank.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bank Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close fs-18 text-primary"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" value="deposit">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date" class="col-form-label text-danger">Date *:</label>
                                <input type="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" id="date" name="date">
                                {!! $errors->first('date', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="deposit_to_a" class="col-form-label text-danger">Select Account *:</label>
                                <select id="deposit_to_a" class="form-control" name="account">
                                    @foreach ($depositAccounts as $account)
                                        <option
                                            value="{{ $account->id }}" {{ $account->id == \Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} >
                                            {{ $account->ledger_name }}
                                        </option>
                                    @endforeach

                                </select>
                                {!! $errors->first('account', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="amount" class="col-form-label text-danger">Amount *: </label>
                                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" type="number" step="any" id="amount">
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
                        <div class="deposit-response-msg"></div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="storeBankDepositBtn">
                                <span class="spinner-grow spinner-grow-sm spinner d-none" role="status"
                                aria-hidden="true"></span>
                                Save
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
