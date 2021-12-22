<!-- Modal-->
<div class="modal fade" id="billPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Record a payment for this bill :
                    <strong class="bill_number"></strong>
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>

            </div>
            <form id="billPaymentForm" action="{{ route('ajax.contactInvoicePayment') }}" method="post">
                @csrf
                <div class="modal-body">

                    <p class="pb-4 form-group">Record a payment you’ve already received, such as cash, check, or bank
                        payment.</p>

                    <div>
                        <input type="text" name="invoice_id" id="invoice_id" hidden>

                        <div class="form-group row">
                            <div class="col-form-label col-lg-4 text-right required">
                                <label class="font-weight-bolder " style="font-size: 16px"> Payment Date <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-6">
                                <input type="date" class="form-control" name="payment_date" id="payment_date"
                                       value="{{ today()->toDateString() }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-4 text-right">
                                <label class="font-weight-bolder" style="font-size: 16px"> Amount Received -
                                    (<small><span class="currency"></span></small>) <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="input-group col-lg-6">
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount"/>
                            </div>
                        </div>

                        <div class="form-group row d-none">
                            <div class="col-form-label col-lg-4 text-right required">
                                <label class="font-weight-bolder " style="font-size: 16px"> Payment Method <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-6">
                                <select id="payment_method_id" class="form-control" name="payment_method_id">
                                    @foreach ($paymentMethods as $paymentMethod )
                                        <option
                                            value="{{ $paymentMethod->id }}" {{ $paymentMethod->is_default ? 'selected' : '' }}>
                                            {{ $paymentMethod->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-4 text-right required">
                                <label class="font-weight-bolder " style="font-size: 16px">  Payment Method <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-6">
                                <select id="ledger_id" class="form-control" name="ledger_id">
                                    @foreach (\Enam\Acc\Models\Ledger::ASSET_LEDGERS() as $account)
                                        <option
                                            value="{{ $account->id }}" {{ $account->id == ($cashAcId??null)?'selected':'' }} >
                                            {{ $account->ledger_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-4 text-right required">
                                <label class="font-weight-bolder" style="font-size: 16px"> Note/Memo (if have)</label>
                            </div>
                            <div class="col-lg-6">
                            <textarea class="form-control" id="notes" cols="30" rows="3" name="notes">
                            </textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
