<div>

    @if($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
</div>
<div class="row">


    <div class="col">
        <div class="form-group">

            <label class="font-weight-bolder" for="bill_number">Bill Number</label>
            <span class="text-danger font-bolder text-danger">*</span>
            <br>
            <input class="form-control  {{ $errors->has('bill_number') ? 'is-invalid' : '' }}"
                   name="bill_number"
                   type="text" id="bill_number"
                   value="{{ old('bill_number', optional($bill)->bill_number)??$next_invoice }}" required>
            {!! $errors->first('bill_number', '<p class="form-text text-danger">:message</p>') !!}
        </div>

    </div>
    <div class="col">
        <div class="form-group">
            <label class="font-weight-bolder" for="order_number">Order Number</label>
            <br>
            <input class="form-control {{ $errors->has('order_number') ? 'is-invalid' : '' }}"
                   name="order_number"
                   type="text" id="order_number" value="{{ old('order_number', optional($bill)->order_number) }}">

            {!! $errors->first('order_number', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="font-weight-bolder" for="bill_date">Bill Date</label> <span
                class="text-danger font-bolder text-danger">*</span>
            <br>
            <input class="form-control  {{ $errors->has('bill_date') ? 'is-invalid' : '' }}"
                   name="bill_date"
                   type="date" id="bill_date"
                   value="{{ old('bill_date', optional($bill)->bill_date)??today()->toDateString() }}"
                   required>

            {!! $errors->first('bill_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">

            <label class="font-weight-bolder" for="due_date">Due Date</label>
            <br>
            <input class="form-control  {{ $errors->has('due_date') ? 'is-invalid' : '' }}"
                   name="due_date" type="date"
                   id="due_date" value="{{ old('due_date', optional($bill)->due_date) }}">
            {!! $errors->first('due_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>

</div>


<div class="row">

    <div class="col">
        <div class="form-group mini">
            <label class="font-weight-bolder">From Vendor</label>

            <br>

            <select class="vendor form-control select2" id="vendor_id" name="vendor_id" required>
                <option value="" disabled
                        selected></option>
                @foreach ($vendors as $key => $vendor)
                    <option
                        value="{{ $key }}" {{ old('vendor_id', optional($bill)->vendor_id) == $key ? 'selected' : '' }}>
                        {{ $vendor }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('vendor_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group mini">
            <label class="font-weight-bolder">Currency</label>

            <br>

            <select class=" form-control select2" id="currency" name="currency">
                <option value="" disabled selected></option>
                @foreach (currencies() as $currency)
                    <option
                        value="{{ $currency['symbol'] }}" {{ old('currency', optional($bill)->currency) == $currency['symbol'] ? 'selected' : '' }} @if($bill == null) {{ ($settings->currency??'$') == $currency['symbol'] ? 'selected' : '' }} @endif>
                        {{ $currency['name'] ?? $currency['currencyname'] }} - {{ $currency['symbol'] }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('vendor_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">

    </div>
    <div class="col">

    </div>
</div>


<div>
    <div id="target"></div>


</div>

<br>
<div class="row">
    <div class="col">

        <p class="p-2 rounded text-primary d-flex font-weight-bolder text-center"
           style="background: whitesmoke;font-size: 16px;cursor:pointer;"
           data-toggle="collapse"
           href="#additionalCollapse" role="button"
           aria-expanded="false" aria-controls="additionalCollapse">

            <span class="mr-4">Additional Information</span>
            <i id="caret" class="fa fa-caret-down my-auto"></i>


        </p>
        <div class="collapse" id="additionalCollapse">
            <table class="table table-borderless">


                <tbody id="additionalFieldTarget">

                </tbody>
            </table>
        </div>
        <div><label class=" form-check form-check-inline form-control-plaintext" id="paymentSection">
                <input id="paymentCheckBox" class="form-check-input" name="is_payment"
                       type="checkbox" {{ optional($bill)->is_payment?'checked':'' }}>
                &nbsp;
                <label for="paymentCheckBox" class="form-check-label"><span
                        class="text-bold"> I have paid the bill </span></label>
            </label>

            <div class="advanceContainer d-none">
                <label>→ <span id="using_advance_amount"></span> is being used from advance payment (<span
                        id="advance_amount" class="font-weight-bolder text-primary"></span>).

                </label>
                <input type="text" name="from_advance" id="from_advance" hidden value="0">
                <input type="text" name="advance" id="advance" hidden value="0">
            </div>

            <div class="paymentContainer mt-4" @if(optional($bill)->is_payment) style="display: block"
                 @else style="display: none" @endif>
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right required">
                        <label class="font-weight-bolder " style="font-size: 14px"> Amount <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-6">
                        <input type="number" step="any" id="paymentAmount" class="form-control" name="payment_amount"
                               value="{{ optional($bill)->payment_amount??'' }}" min="0"
                               max="{{ optional($bill)->total??'' }}"/>
                    </div>
                </div>
                <div class="form-group row d-none">
                    <div class="col-form-label col-lg-4 text-right required">
                        <label class="font-weight-bolder " style="font-size: 14px"> Payment Method <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-6">
                        <select id="payment_method_id" class="form-control" name="payment_method_id">
                            @foreach ($paymentMethods as $paymentMethod )
                                <option
                                    value="{{ $paymentMethod->id }}"
                                    {{ optional($bill)->payment_method_id == $paymentMethod->id ? 'selected' : '' }} @if($bill == null && $paymentMethod->is_default) selected @endif>
                                    {{ $paymentMethod->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-form-label col-lg-4 text-right required">
                        <label class="font-weight-bolder " style="font-size: 14px"> Payment Method<span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-6">
                        <select id="deposit_to" class="form-control" name="deposit_to">
                            @foreach ($depositAccounts as $account)
                                <option
                                    value="{{ $account->id }}" {{ $account->id == optional($bill)->deposit_to?'selected':'' }} @if($bill == null) {{ $account->id == \Enam\Acc\Models\Ledger::CASH_AC()?'selected':'' }} @endif >
                                    {{ $account->ledger_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">


        <table class="table table-borderless">
            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 14px">Sub Total</b>

                </td>
                <td style="text-align: end">
                    <input type="number" step="any" id="subTotal" name="sub_total"
                           value="{{ old('sub_total', optional($bill)->sub_total) }}" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end">
                    <span class="currency"></span>

                </td>
            </tr>
            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 14px">Discount</b>
                    <input type="number" step="any" class="input-sm form-control d-inline-block"
                           style="max-width: 100px; text-align: end" id="discountValue" name="discount_value"
                           value="{{ old('discount_value', optional($bill)->discount_value) }}">
                    <select class="input-sm small-input d-inline" id="discount_type" name="discount_type">

                        @foreach ([ '%', 'Flat'] as $key => $text)
                            <option
                                value="{{ $text }}" {{ old('discount_type', optional($bill)->discount_type) == $text ? 'selected' : '' }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td style="text-align: end">

                    <input type="number" step="any" id="discount" name="discount"
                           value="{{ old('discount', optional($bill)->discount) }}>" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end" hidden>

                    <input type="number" step="any" id="discountShown"
                           value="{{ old('discount', optional($bill)->discount) }}" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end">
                    <span class="currency"></span>

                </td>
            </tr>
            <tr>
                <td style="display: none"><b class="font-weight-bolder text-black mr-2" style="font-size: 14px">Shipping Charges</b>

                    <input type="number" step="any" class="input-sm form-control d-inline-block"
                           style="max-width: 100px;text-align: end"
                           name="shipping_input"
                           id="shipping_input"
                           value="{{ old('shipping_charge', optional($bill)->shipping_charge) }}">
                </td>
                <td style="text-align: end">
                    <input type="number" id="shipping_charge" name="shipping_charge"
                           value="{{ old('shipping_charge', optional($bill)->shipping_charge) }}" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end">
                    <span class="currency"></span>

                </td>
            </tr>

            <tbody id="extra">

            </tbody>

            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 20px">Total</b>
                </td>
                <td class="d-flex" style="text-align: end">

                    <input class="font-weight-bolder d-inline" type="number" step="any" id="total" name="total"
                           value="0.00" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end;font-size: 20px">
                    <span class="currency font-weight-bolder d-inline" style="font-size: 20px"></span>

                </td>
            </tr>
        </table>

    </div>


</div>


<br>
<br>
<br>
<br>
<div class="row">

    <div class="col">
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" name="notes" cols="50" rows="5"
                      id="notes">{{ old('notes', optional($bill)->notes) ??$settings->notes??'' }}</textarea>
            {!! $errors->first('notes', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="col"></div>
    <div class="col align-self-center border">
        <div class="form-group p-1">
            <label for="attachment">Attach File(s) to Bill</label>
            <div class="input-group uploaded-file-group">
                <label class="input-group-btn">
                <span class="btn btn-default">
                     <input type="file" name="attachment" id="attachment" class="form-control-file">
                </span>
                </label>
                <input type="text" class="form-control uploaded-file-name" hidden>
            </div>

            @if (isset($bill->attachment) && !empty($bill->attachment))
                <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_attachment" class="custom-delete-file" value="1" {{ old('custom_delete_attachment', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                    <span class="input-group-addon custom-delete-file-name">
                   <img class="card" src="{{ asset('storage/'.$bill->attachment) }}" width="200">

                </span>
                </div>
            @endif

            {!! $errors->first('attachment', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>


<div class="hidden">
    <input type="text" id="bill_items" name="bill_items" hidden>
    <input type="text" id="additional" name="additional" hidden>
    <input type="text" id="additionalField" name="additional_fields" hidden>
</div>



@verbatim
    <script id="template" type="text/ractive">

                <table id="bill_item_table" class="table text-black text-center  ">
                    <thead>
                    <tr class="">
                        <th  class="font-weight-bold" style="text-align: start;">Items <span class="text-danger">*</span></th>
                        <th style="width: 13%" scope="col" class="font-weight-bold">Stock</th>
                         {{# exp_based_product }}
        <th style="width: 13%" scope="col" class="font-weight-bold">Batch</th>
        <th style="width: 13%" scope="col" class="font-weight-bold">Exp At</th>

{{/ exp_based_product }}
        <th style="width: 13%" scope="col" class="font-weight-bold">Rate</th>
        <th style="width: 13%"  scope="col" class="font-weight-bold">Quantity</th>
        <th  style="width: 20%"  scope="col" class="font-weight-bold">Tax <sup><a target="_blank" href="/taxes">view taxes</a></sup></th>
        <th  style="width: 13%" scope="col" class="font-weight-bold">Amount</th>
         <th   ></th>
    </tr>
    </thead>
<tbody>
{{#each bill_items:i}}
        <tr class="ui-state-default" id="row{{i}}" fade-in>
            <td>
                <div class="d-flex">


                <span class="fa fa-grip-vertical p-2" style="cursor: move"></span>
                <select style="width: 100%" id='itemSelect{{ i }}' class="itemSelect form-control input-sm "
                value="{{ product_id }}" index="{{ i }}" required>
                            <option disabled selected value=""> -- </option>
                            {{ #each products:i }}
        <option value="{{ id }}" > {{ name }}</option>
                            {{ /each }}
        </select>
        </div>
   <input type="text" value="{{ description }}" style="border: none!important;" class="form-control  input-sm description" placeholder="Item Description ...">
            </td>
             <td> {{ stock }}</td>
             {{# exp_based_product }}
        <td style="width: 13%" scope="col" class="font-weight-bold"><input class="form-control form-control-sm" type="text" value="{{ batch }}"></td>
        <td style="width: 13%" scope="col" class="font-weight-bold"><input class="form-control form-control-sm" type="date" value="{{ exp_date }}"></td>
             {{/ exp_based_product }}
        <td> <input type="number" step="any" style="text-align: end"  class="form-control  input-sm rate" value="{{ price }}" required></td>
            <td> <input type="number" step="any" style="text-align: end"  class="form-control   input-sm qnt" index="{{ i }}
        " value="{{ qnt }}" required>
            <input class="text-right form-control input-sm unit" type="text" style="outline: none;border:0 !important;text-align: end; text-decoration: underline;text-decoration-style: dashed;text-decoration-color: red"  value="{{ unit }}"/>
             </td>
            <td >
            <select index="{{i}}" id="itemTax{{i}}" class="form-control " value="{{ tax_id }}">
                    <option value="" selected>--</option>
                    {{ #each taxes:index }}
        <option value="{{id}}">{{ name }} - {{value}}%</option>
                    {{ /each }}
        </select>
        <br>
        &nbsp;
     </td>
    <td >
        <span class="font-weight-bolder" style="font-size: 16px"> {{ (parseFloat((price||0) * (qnt||0))).toFixed(2) }}</span>
        <span class="currency d-inline font-weight-bolder" style="font-size: 16px">{{ currency }}</span></td>
            <td on-click="@this.delete(i)" style="cursor: pointer"> <i class="fa fa-trash text-danger" ></i></td>
         </tr>
{{ /each}}
        </tbody>
        </table>
        <br>
        <br>
        <div class="">
            <span role="button" on-click="@this.addBillItem()" class="btn btn-sm btn-primary"
                  style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Line</span>
        </div>







































    </script>
@endverbatim
@verbatim
    <script id="extraTemplate" type="text/ractive">
            {{#each appliedTax:i}}
        <tr>
            <td>
                <span class="font-weight-bolder">{{ name }}</span>

                    </td>
                    <td style="text-align: end">
                        <input type="number" value="{{ amount.toFixed(2) }}" readonly
                        style="border: 1px solid transparent; outline: none;text-align: end">
                        <span class="currency d-inline" style="font-size: 16px">{{ currency }}</span>
                    </td>
                </tr>

             {{/each}}
        {{#each pairs:i}}
        <tr>
            <td class="d-flex">
                <input type="text" class="input-sm form-control d-inline-block" style="" placeholder="Additional.." value="{{ name }}">
                        <input type="number" step="any" class="input-sm form-control d-inline-block" style="text-align: end" value="{{ value }}">
                        <i class="fa fa-minus text-danger mx-2" on-click="@this.removeExtraField(i)" style="cursor:pointer;"></i>
                        <b class="far fa-question-circle" data-toggle="tooltip" title="Add any other +ve or -ve charges that need to be applied to adjust the total amount of the transaction Eg. +10 or -10.">

                    </td>
                    <td style="text-align: end">

                        <input type="number"  value="{{ value }}" readonly
                        class="{{ className }}" style="border: 1px solid transparent; outline: none;text-align: end">
                                                <span class="currency d-inline {{ className }}" style="font-size: 16px">{{ currency }}</span>

                    </td>
                </tr>

             {{/each}}
        <tr>
                          <td><span class="text-primary " on-click="@this.addExtraField()" style="cursor:pointer;">+ Add More</span></td>
                          <td></td>
                      </tr>

























































































    </script>
@endverbatim
@verbatim
    <script id="additionalFieldTemplate" type="text/ractive">

        {{#each additional_fields:i}}
        <tr>
            <td>
                <input type="text" class="form-control  font-weight-bolder"  placeholder="ex. Vat No" value="{{ name }}">

                    </td>
                    <td>
                   <input type="text" step="any" class="form-control " placeholder="ex. 77GH77G9 " value="{{ value }}">

                    </td>
                    <td class="text-center"> <i class="fa fa-trash text-danger my-auto text-center" on-click="@this.removeAdditionalField(i)" style="cursor:pointer;"></i>
</td>
                </tr>

             {{/each}}
        <tr>
              <td><span class="text-primary " on-click="@this.addAdditionalField()" style="cursor:pointer;">+ Add More</span></td>
              <td></td>
          </tr>

























































































    </script>
@endverbatim
