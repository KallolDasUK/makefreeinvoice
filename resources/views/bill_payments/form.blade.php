<div class="row">
    <div class="col">
        <div class="form-group row">
            <label class="col " for="vendor_id">Vendor</label>
            <select class="form-control col" id="vendor_id" name="vendor_id" required>
                <option value="" style="display: none;"
                        {{ old('vendor_id', optional($billPayment)->vendor_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select vendor
                </option>
                @foreach ($vendors as $key => $vendor)
                    <option
                        value="{{ $key }}" {{ old('vendor_id', optional($billPayment)->vendor_id) == $key ? 'selected' : '' }}>
                        {{ $vendor }}
                    </option>
                @endforeach
            </select>
            @if($billPayment)
                <input type="text" name="vendor_id" value="{{ optional($billPayment)->vendor_id }}" hidden>
            @endif

            {!! $errors->first('vendor_id', '<p class="form-text text-danger">:message</p>') !!}
        </div>

        <div class="form-group row">

            <label class="col" for="payment_date">Payment Date <span class="text-danger font-bolder">*</span></label>


            <input class="form-control col {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" name="payment_date"
                   type="date" id="payment_date"
                   value="{{ old('payment_date', optional($billPayment)->payment_date)??today()->toDateString() }}"
                   required>

            {!! $errors->first('payment_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>

        <div class="form-group row">

            <label for="payment_sl" class="col">Ref # <span class="text-danger font-bolder">*</span> </label>
            <input class="form-control col {{ $errors->has('payment_sl') ? 'is-invalid' : '' }}" name="payment_sl"
                   type="text" id="payment_sl"
                   value="{{ old('payment_sl', optional($billPayment)->payment_sl)??$paymentSerial }}"

            >
            {!! $errors->first('payment_sl', '<p class="form-text text-danger">:message</p>') !!}

        </div>

        <div class="form-group row d-none">
            <label for="payment_method_id" class="col">Payment Method <span
                    class="text-danger font-bolder">*</span></label>
            <select class="form-control col" id="payment_method_id" name="payment_method_id" required>
                <option value="" style="display: none;"
                        {{ old('payment_method_id', optional($billPayment)->payment_method_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select payment method
                </option>
                @foreach ($paymentMethods as $paymentMethod )
                    <option
                        value="{{ $paymentMethod->id }}" {{ old('payment_method_id', optional($billPayment)->payment_method_id) == $paymentMethod->id ? 'selected' : '' }}
                    @if($billPayment==null) {{ $paymentMethod->name == 'Cash'?'selected':'' }} @endif
                    >
                        {{ $paymentMethod->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('payment_method_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>

        <div class="form-group row">
            <label for="ledger_id" class="col">Payment Method</label>


            <select class="form-control col" id="ledger_id" name="ledger_id" required="true">


                @foreach ($depositAccounts as $account)
                    <option
                        value="{{ $account->id }}" {{ old('ledger_id', optional($billPayment)->ledger_id) == $account->id ? 'selected' : '' }} @if($receivePaymnet??null) {{ $account->id == ($cashAcId??null)?'selected':'' }} @endif  @if($billPayment == null) {{ $account->id == \Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} @endif>
                        {{ $account->ledger_name }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('ledger_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col text-center align-self-center justify-center">
        <div class="card bg-secondary col-8  mx-auto {{ $billPayment !=null?'':'d-none' }} receive">
            <div class="card-body">
                <h3>Paying Amount</h3>
                <input type="number" step="any" class="form-control" id="given" name="given" style="font-size: 20px"

                       value="{{ old('given', optional($billPayment)->given) }}"
                >
            </div>
        </div>
    </div>
</div>


<div class="form-group px-4">
    <h3 class="ml-4">Unpaid Bills</h3>
    <table class="table line-item-table">
        <thead>
        <tr class="line-item-header">
            <th>Date</th>
            <th>Bill Number</th>
            <th>Due Date</th>

            <th class="text-right">Bill Amount</th>
            <th class="text-right"> Amount Due</th> <!----><!---->
            <th class="text-right" style="width:16%;">Payment</th>
        </tr>
        </thead>
        <tbody id="tbody">
        @if($billPayment)

            @if($billPayment->previous_due)
                <tr>
                    <td colspan="3" style="padding-top: 0px;"></td>
                    <td colspan="1" class="text-right">Previous Due</td>
                    <td colspan="1"
                        class="text-right">{{ $billPayment->vendor->previous_due + $billPayment->previous_due }}</td>
                    <td class="text-right">
                        <input type="number" step="any" name="previous_due"
                               class="form-control paymentAmount text-right"
                               due="{{ $billPayment->previous_due + $billPayment->previous_due }}"
                               max="{{ $billPayment->vendor->previous_due + $billPayment->previous_due }}"
                               id="previous_due"
                               value="{{ $billPayment->previous_due }}"/></td>
                </tr>

            @endif



            @foreach($billPayment->items as $item)
                <tr>
                    <td> {{ $item->bill->bill_date }} <br>


                    </td>
                    <td> {{ $item->bill->bill_number }} </td>
                    <td> {{ $item->bill->due_date }}</td>
                    <td class="text-right"> {{ $item->bill->total }} </td>
                    <td class="text-right"> {{ number_format($item->bill->due) }} </td>
                    <td class="text-right" style="width:16%; position: relative;">
                        <input name="payment[]"
                               bill_id="{{ $item->bill->id }}"
                               class="paymentAmount text-right form-control"
                               step="any"
                               value="{{ $item->amount }}"
                               type="number"/>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="padding-top: 0px;"></td>
                <td colspan="2" class="text-right">Total</td>
                <td class="text-right"><input type="text" name="totalAmount" class="form-control"
                                              value="{{ $billPayment->items->sum('amount')??0 }}"
                                              style="cursor: no-drop" id="totalAmount"/></td>
            </tr>
        @endif
        </tbody>

    </table>
</div>

@if(!$billPayment)
    <div id="message" style="min-height: 50px;width: 100%;margin-top: 20px" class="text-center">
        <h3 class="my-auto">Please Select a vendor first</h3>
    </div>
@endif

<div class="form-group">
    <div class="col-md-10">
        <label for="note">Note</label>


        <textarea class="form-control" name="note" cols="50" rows="2" id="note" minlength="1"
                  maxlength="1000">{{ old('note', optional($billPayment)->note) }}</textarea>
        {!! $errors->first('note', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<input type="text" hidden id="data" name="data">

