<div class="row">
    <div class="col">


        <div class="form-group row">
            <label class="col" for="customer_id">Customer</label>
            <select class="form-control col" id="customer_id" name="customer_id" required>
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

            <label class="col" for="payment_date">Payment Date <span
                    class="text-danger font-bolder">*</span></label>


            <input class="form-control col {{ $errors->has('payment_date') ? 'is-invalid' : '' }}"
                   name="payment_date"
                   type="date" id="payment_date"
                   value="{{ old('payment_date', optional($receivePayment)->payment_date)??today()->toDateString() }}"
                   required>

            {!! $errors->first('payment_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>

        <div class="form-group row">

            <label for="payment_sl" class="col">Payment # <span class="text-danger font-bolder">*</span> </label>
            <input class="form-control col {{ $errors->has('payment_sl') ? 'is-invalid' : '' }}" name="payment_sl"
                   type="text" id="payment_sl"
                   value="{{ old('payment_sl', optional($receivePayment)->payment_sl)??$paymentSerial }}"

            >
            {!! $errors->first('payment_sl', '<p class="form-text text-danger">:message</p>') !!}

        </div>

        <div class="form-group row d-none">
            <label for="payment_method_id" class="col">Payment Method <span
                    class="text-danger font-bolder">*</span></label>
            <select class="form-control col" id="payment_method_id" name="payment_method_id" required>
                <option value="" style="display: none;"
                        {{ old('payment_method_id', optional($receivePayment)->payment_method_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select payment method
                </option>
                @foreach ($paymentMethods as $paymentMethod )
                    <option
                        value="{{ $paymentMethod->id }}" {{ old('payment_method_id', optional($receivePayment)->payment_method_id) == $paymentMethod->id ? 'selected' : '' }}
                    @if($receivePayment==null) {{ $paymentMethod->name == 'Cash'?'selected':'' }} @endif>
                        {{ $paymentMethod->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('payment_method_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>

        <div class="form-group row">
            <label for="deposit_to" class="col">Payment Method </label>


            <select class="form-control col" id="deposit_to" name="deposit_to" required="true">


                @foreach (\Enam\Acc\Models\Ledger::ASSET_LEDGERS() as $account)
                    <option
                        value="{{ $account->id }}" {{ old('deposit_to', optional($receivePayment)->deposit_to) == $account->id ? 'selected' : '' }} @if($receivePayment == null) {{ $account->id == \Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} @endif>
                        {{ $account->ledger_name }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('deposit_to', '<p class="form-text text-danger">:message</p>') !!}

        </div>

    </div>
    <div class="col text-center align-self-center justify-center">
        <div class="card bg-secondary col-8  mx-auto {{ $receivePayment !=null?'':'d-none' }} receive">
            <div class="card-body">
                <h3>Receiving Amount</h3>
                <input type="number" step="any" class="form-control" id="given" name="given" style="font-size: 20px"

                       value="{{ old('given', optional($receivePayment)->given) }}"
                >
            </div>
        </div>
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
            <th class="text-right">Amount Due</th>
            <th class="text-right" style="width:16%;">Payment</th>
        </tr>
        </thead>
        <tbody id="tbody">
        @if($receivePayment)

            @if($receivePayment->previous_due>0)
                <tr>
                    <td colspan="3" style="padding-top: 0px;"></td>
                    <td colspan="1" class="text-right">Previous Due</td>
                    <td colspan="1" class="text-right">{{ $receivePayment->customer->previous_due + $receivePayment->previous_due }}</td>
                    <td class="text-right">
                        <input type="number" step="any"
                               name="previous_due"
                               class="form-control paymentAmount text-right"
                               due="{{ $receivePayment->customer->previous_due + $receivePayment->previous_due }}"
                               max="{{ $receivePayment->customer->previous_due + $receivePayment->previous_due }}"
                               value="{{ $receivePayment->previous_due }}"
                               id="previous_due"/></td>
                </tr>

            @endif

            @foreach($receivePayment->items as $item)
                <tr>
                    <td> {{ $item->invoice->invoice_date }} <br> </td>
                    <td> {{ $item->invoice->invoice_number }} </td>
                    <td>{{ $item->invoice->due_date }}</td>
                    <td class="text-right"> {{ $item->invoice->total }} </td>
                    <td class="text-right"> {{ number_format($item->invoice->due  + $item->amount) }} </td>
                    <td class="text-right" style="width:16%; position: relative;">
                        <input name="payment[]"
                               invoice_id="{{ $item->invoice->id }}"
                               class="paymentAmount text-right form-control"
                               step="any"
                               due="{{ $item->invoice->due + $item->amount   }}"
                               value="{{ $item->amount }}"
                               type="number"/>
                    </td>
                </tr>
            @endforeach
            @foreach($pos_payments as $pos_payment)
                <tr>
                    <td> {{ $pos_payment->date }} <br>


                    </td>
                    <td> {{ optional($pos_payment->pos_sale)->pos_number }} </td>
                    <td> - </td>


                    <td class="text-right"> {{ optional($pos_payment->pos_sale)->total }} </td>
                    <td class="text-right"> {{ optional($pos_payment->pos_sale)->due + $pos_payment->amount }} </td>
                    <td class="text-right" style="width:16%; position: relative;">
                        <input name="payment[]"
                               pos_id="{{ optional($pos_payment->pos_sale)->id }}"
                               class="paymentAmount pos text-right form-control"
                               due="{{ optional($pos_payment->pos_sale)->due + $pos_payment->amount  }}"
                                value="{{ $pos_payment->amount }}"
                               step="any"
                               type="number"/>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="padding-top: 0px;"></td>
                <td colspan="3" class="text-right">Total</td>
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
<input type="text" hidden id="pos" name="pos">

