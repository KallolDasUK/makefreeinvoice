<div class="form-group row">
    <label class="col-lg-2 " for="customer_id">Customer</label>
    <select class="form-control col-lg-4" id="customer_id" name="customer_id" required>
        <option value="" style="display: none;"
                {{ old('customer_id', optional($receivePayment)->customer_id ?: '') == '' ? 'selected' : '' }} disabled
                selected>Select customer
        </option>
        @foreach ($customers as $key => $customer)
            <option
                value="{{ $key }}" {{ old('customer_id', optional($receivePayment)->customer_id) == $key ? 'selected' : '' }}>
                {{ $customer }}
            </option>
        @endforeach
    </select>
    @if($receivePayment)
        <input type="text" name="customer_id" value="{{ optional($receivePayment)->customer_id }}" hidden>
    @endif

    {!! $errors->first('customer_id', '<p class="form-text text-danger">:message</p>') !!}
</div>

<div class="form-group row">

    <label class="col-lg-2" for="payment_date">Payment Date <span class="text-danger font-bolder">*</span></label>


    <input class="form-control col-lg-4 {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" name="payment_date"
           type="date" id="payment_date" value="{{ old('payment_date', optional($receivePayment)->payment_date) }}"
           required>

    {!! $errors->first('payment_date', '<p class="form-text text-danger">:message</p>') !!}

</div>

<div class="form-group row">

    <label for="payment_sl" class="col-lg-2">Payment # <span class="text-danger font-bolder">*</span> </label>
    <input class="form-control col-lg-4 {{ $errors->has('payment_sl') ? 'is-invalid' : '' }}" name="payment_sl"
           type="text" id="payment_sl"
           value="{{ old('payment_sl', optional($receivePayment)->payment_sl)??$paymentSerial }}"

           >
    {!! $errors->first('payment_sl', '<p class="form-text text-danger">:message</p>') !!}

</div>

<div class="form-group row">
    <label for="payment_method_id" class="col-lg-2">Payment Method <span
            class="text-danger font-bolder">*</span></label>
    <select class="form-control col-lg-4" id="payment_method_id" name="payment_method_id" required>
        <option value="" style="display: none;"
                {{ old('payment_method_id', optional($receivePayment)->payment_method_id ?: '') == '' ? 'selected' : '' }} disabled
                selected>Select payment method
        </option>
        @foreach ($paymentMethods as $paymentMethod )
            <option
                value="{{ $paymentMethod->id }}" {{ old('payment_method_id', optional($receivePayment)->payment_method_id) == $paymentMethod->id ? 'selected' : '' }}>
                {{ $paymentMethod->name }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('payment_method_id', '<p class="form-text text-danger">:message</p>') !!}

</div>

<div class="form-group row">
    <label for="deposit_to" class="col-lg-2">Deposit To</label>


    <select class="form-control col-lg-4" id="deposit_to" name="deposit_to" required="true">


        @foreach ($depositAccounts as $account)
            <option
                value="{{ $account->id }}" {{ old('deposit_to', optional($receivePayment)->deposit_to) == $account->id ? 'selected' : '' }} @if($receivePayment == null) {{ $account->id == \Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} @endif>
                {{ $account->ledger_name }}
            </option>
        @endforeach
    </select>

    {!! $errors->first('deposit_to', '<p class="form-text text-danger">:message</p>') !!}

</div>
</div>


<div class="form-group px-4">
    <h3 class="ml-4">Unpaid Invoices</h3>
    <table class="table line-item-table">
        <thead>
        <tr class="line-item-header">
            <th>Date</th>
            <th>Invoice Number</th>
            <th>Due Date</th>

            <th class="text-right">Invoice Amount</th>
            <th class="text-right"> Amount Due</th> <!----><!---->
            <th class="text-right" style="width:16%;">Payment</th>
        </tr>
        </thead>
        <tbody id="tbody">
        @if($receivePayment)
            @foreach($receivePayment->items as $item)
                <tr>
                    <td> {{ $item->invoice->invoice_date }} <br>
                        @if($item->invoice->due_date)
                            <small> <span class="text-muted">Due Date</span>: {{ $item->invoice->due_date }} </small>
                        @endif

                    </td>
                    <td> {{ $item->invoice->invoice_number }} </td>
                    <td class="text-right"> {{ $item->invoice->total }} </td>
                    <td class="text-right"> {{ number_format($item->invoice->due) }} </td>
                    <td class="text-right" style="width:16%; position: relative;">
                        <input name="payment[]"
                               invoice_id="{{ $item->invoice->id }}"
                               class="paymentAmount text-right form-control"
                               step="any"
                               value="{{ $item->amount }}"
                               type="number"/>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="padding-top: 0px;"></td>
                <td colspan="2" class="text-right">Total</td>
                <td class="text-right"><input type="text" name="totalAmount" class="form-control"
                                              value="{{ $receivePayment->items->sum('amount') }}"
                                              style="cursor: no-drop" id="totalAmount"/></td>
            </tr>
        @endif
        </tbody>

    </table>
</div>

@if(!$receivePayment)
    <div id="message" style="min-height: 50px;width: 100%;margin-top: 20px" class="text-center">
        <h3 class="my-auto">Please Select a Customer first</h3>
    </div>
@endif

<div class="form-group">
    <div class="col-md-10">
        <label for="note">Note</label>


        <textarea class="form-control" name="note" cols="50" rows="2" id="note" minlength="1"
                  maxlength="1000">{{ old('note', optional($receivePayment)->note) }}</textarea>
        {!! $errors->first('note', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<input type="text" hidden id="data" name="data">

