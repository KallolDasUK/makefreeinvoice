<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="col">
                <label for="customer_id">Customer</label>
                <span class="text-danger font-bolder">*</span>


                <select class="form-control searchable" id="customer_id" name="customer_id">
                    <option value="" style="display: none;"
                            {{ old('customer_id', optional($customerAdvancePayment)->customer_id ?: '') == '' ? 'selected' : '' }} disabled
                            selected>Select customer
                    </option>
                    @foreach ($customers as $key => $customer)
                        <option
                            value="{{ $key }}" {{ old('customer_id', optional($customerAdvancePayment)->customer_id) == $key ? 'selected' : '' }}>
                            {{ $customer }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('customer_id', '<p class="form-text text-danger">:message</p>') !!}

            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <div class="col">
                <label for="ledger_id">Payment Method</label>

                <span class="text-danger font-bolder">*</span>
                <select class="form-control searchable" id="ledger_id" name="ledger_id">
                    <option value="" style="display: none;"
                            {{ old('ledger_id', optional($customerAdvancePayment)->ledger_id ?: '') == '' ? 'selected' : '' }} disabled
                            selected>Select ledger
                    </option>
                    @foreach ($ledgers as $key => $ledger)
                        <option
                            value="{{ $key }}" {{ old('ledger_id', optional($customerAdvancePayment)->ledger_id) == $key ? 'selected' : '' }}
                        @if($customerAdvancePayment==null) {{ $key==\Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} @endif
                        >
                            {{ $ledger }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('ledger_id', '<p class="form-text text-danger">:message</p>') !!}

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="col">
                <label for="amount">Amount</label>
                <span class="text-danger font-bolder">*</span>
                <input class="form-control  {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount"
                       type="number" step="any"
                       id="amount" value="{{ old('amount', optional($customerAdvancePayment)->amount) }}" minlength="1">

                {!! $errors->first('amount', '<p class="form-text text-danger">:message</p>') !!}

            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <div class="col">
                <label for="date">Date</label>
                <span class="text-danger font-bolder">*</span>
                <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" type="date"
                       id="date"
                       value="{{ old('date', optional($customerAdvancePayment)->date)??today()->toDateString() }}"
                       minlength="1">

                {!! $errors->first('date', '<p class="form-text text-danger">:message</p>') !!}

            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <div class="col">
        <label for="note">Note</label>


        <textarea class="form-control" name="note" cols="10" rows="2" id="note" minlength="1"
                  maxlength="1000">{{ old('note', optional($customerAdvancePayment)->note) }}</textarea>
        {!! $errors->first('note', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

