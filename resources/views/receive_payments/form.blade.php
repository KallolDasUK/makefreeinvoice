
<div class="form-group row">
        <label class="col-lg-2 "  for="customer_id">Customer</label>
            <select class="form-control col-lg-4" id="customer_id" name="customer_id" required="true">
        	    <option value="" style="display: none;" {{ old('customer_id', optional($receivePayment)->customer_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select customer</option>
        	@foreach ($customers as $key => $customer)
			    <option value="{{ $key }}" {{ old('customer_id', optional($receivePayment)->customer_id) == $key ? 'selected' : '' }}>
			    	{{ $customer }}
			    </option>
			@endforeach
        </select>

            {!! $errors->first('customer_id', '<p class="form-text text-danger">:message</p>') !!}
</div>

<div class="form-group row">

        <label class="col-lg-2" for="payment_date">Payment Date     <span class="text-danger font-bolder">*</span></label>



        <input class="form-control col-lg-4 {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" name="payment_date" type="date" id="payment_date" value="{{ old('payment_date', optional($receivePayment)->payment_date) }}" data=" required="true""  placeholder="Enter payment date here...">

            {!! $errors->first('payment_date', '<p class="form-text text-danger">:message</p>') !!}

</div>

<div class="form-group row">

        <label for="payment_sl" class="col-lg-2">Payment # <span class="text-danger font-bolder">*</span> </label>
        <input class="form-control col-lg-4 {{ $errors->has('payment_sl') ? 'is-invalid' : '' }}" name="payment_sl" type="text" id="payment_sl" value="{{ old('payment_sl', optional($receivePayment)->payment_sl) }}" data=""  placeholder="Enter payment sl here...">
            {!! $errors->first('payment_sl', '<p class="form-text text-danger">:message</p>') !!}

</div>

<div class="form-group row">

        <label for="payment_method_id" class="col-lg-2">Payment Method</label>
            <select class="form-control col-lg-4" id="payment_method_id" name="payment_method_id">
        	    <option value="" style="display: none;" {{ old('payment_method_id', optional($receivePayment)->payment_method_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select payment method</option>
        	@foreach ($paymentMethods as $key => $paymentMethod)
			    <option value="{{ $key }}" {{ old('payment_method_id', optional($receivePayment)->payment_method_id) == $key ? 'selected' : '' }}>
			    	{{ $paymentMethod }}
			    </option>
			@endforeach
        </select>
            {!! $errors->first('payment_method_id', '<p class="form-text text-danger">:message</p>') !!}

</div>

<div class="form-group row">
        <label for="deposit_to" class="col-lg-2">Deposit To</label>


            <select class="form-control col-lg-4" id="deposit_to" name="deposit_to" required="true">
        	    <option value="" style="display: none;" {{ old('deposit_to', optional($receivePayment)->deposit_to ?: '') == '' ? 'selected' : '' }} disabled selected>Enter deposit to here...</option>
        	@foreach (['0' => 'Petty Cash','1' => 'Bank Account 1','2' => 'Test 2'] as $key => $text)
			    <option value="{{ $key }}" {{ old('deposit_to', optional($receivePayment)->deposit_to) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>

            {!! $errors->first('deposit_to', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<table class="table line-item-table"><thead><tr class="line-item-header"><th>Date</th> <th>Invoice Number</th> <th class="text-right">Invoice Amount</th> <th class="text-right"> Amount Due</th> <!----><!----> <th class="text-right" style="width:16%;">Payment</th></tr></thead> <tbody> <tr id="ember3172" class="ember-view"><td> 18 Jul 2021<br><small><span class="text-muted">Due Date</span>: 18 Jul 2021</small></td> <td>INV-000001</td> <td class="text-right"> 70 </td> <td class="text-right"> 70 </td> <!----><!----> <td class="text-right" style="width:16%; position: relative;"><input id="ember3173" class="ember-text-field text-right ember-view form-control" type="text"> <!----><!----> </td></tr><tr id="ember3175" class="ember-view"><td> 18 Jul 2021<br><small><span class="text-muted">Due Date</span>: 18 Jul 2021</small></td> <td>INV-000002</td> <td class="text-right"> 1,256 </td> <td class="text-right"> 256 </td> <!----><!----> <td class="text-right" style="width:16%; position: relative;"><input id="ember3176" class="ember-text-field text-right ember-view form-control" type="text"> <!----><!----> </td></tr> <tr><td colspan="2" style="padding-top: 0px;"><small class="text-muted">**List contains only SENT invoices</small></td> <td colspan="2" class="text-right">Total</td> <!----> <td class="text-right"> 270.00 </td></tr></tbody></table>


<div class="form-group">
    <div class="col-md-10">
        <label for="note">Note</label>


            <textarea class="form-control" name="note" cols="50" rows="10" id="note" minlength="1" maxlength="1000">{{ old('note', optional($receivePayment)->note) }}</textarea>
            {!! $errors->first('note', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

