<div class="modal fade" id="bankDepositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" >

        <form id="createCustomerForm" action="{{ route('customers.customer.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bank Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

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
                                <label for="select_amount" class="col-form-label text-danger">Select Amount *:</label>
                                <select class="form-control {{ $errors->has('select_amount') ? 'is-invalid' : '' }}" id="select_amount" name="select_amount">
                                @foreach (['Dr' => 'Previous Due','Cr' => 'Advance'] as $key => $text)
                                    <option
                                        value="{{ $key }}">
                                        {{ $text }}
                                    </option>
                                @endforeach
                                </select>
                                {!! $errors->first('select_amount', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="amount"  class="col-form-label text-danger">Amount *: </label>
                                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" type="number" step="any" id="amount">
                                {!! $errors->first('amount', '<p class="form-text text-danger">:message</p>') !!}
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="cheque_date" class="col-form-label">Cheque Date :</label>
                                <input type="date" class="form-control " id="cheque_date" name="cheque_date"/>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="cheque_no" class="col-form-label">Cheque No: </label>
                                <input class="form-control" name="cheque_no" type="text" id="cheque_no"> 
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeBankDepositBtn">Save</button>
                </div>

            </div>
        </form>

    </div>
</div>
