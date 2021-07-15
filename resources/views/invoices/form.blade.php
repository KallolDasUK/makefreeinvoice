<div class="float-right">
    <div class="" style="width: 150px;height: 150px">
        <div class="image-input image-input-outline" id="kt_image_1">
            <div class="image-input-wrapper"
                 @if($settings->business_logo??false)
                 style="background-image: url({{ asset('storage/'.$settings->business_logo)}})"></div>
            @else
                style="background-image: url( https://res.cloudinary.com/teepublic/image/private/s--lPknYmIq--/t_Resized%20Artwork/c_fit,g_north_west,h_954,w_954/co_000000,e_outline:48/co_000000,e_outline:inner_fill:48/co_ffffff,e_outline:48/co_ffffff,e_outline:inner_fill:48/co_bbbbbb,e_outline:3:1000/c_mpad,g_center,h_1260,w_1260/b_rgb:eeeeee/c_limit,f_auto,h_630,q_90,w_630/v1524123000/production/designs/2605867_0.jpg)"></div>
        @endif

            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                   data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                <i class="fa fa-pen icon-sm text-muted"></i>
                <input type="file" name="business_logo" accept=".png, .jpg, .jpeg"/>
                <input type="hidden" name="profile_avatar_remove"/>
            </label>

            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                  data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
  <i class="ki ki-bold-close icon-xs text-muted"></i>
 </span>
        </div>
    </div>

    @if($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
</div>
<div class="row">


    <div class="col">
        <div class="form-group">

            <label class="font-weight-bolder" for="invoice_number">Invoice Number</label>
            <span class="text-danger font-bolder text-danger">*</span>
            <br>
            <input class="form-control  {{ $errors->has('invoice_number') ? 'is-invalid' : '' }}"
                   name="invoice_number"
                   type="text" id="invoice_number"
                   value="{{ old('invoice_number', optional($invoice)->invoice_number)??$next_invoice }}" required>
            {!! $errors->first('invoice_number', '<p class="form-text text-danger">:message</p>') !!}
        </div>

    </div>
    <div class="col">
        <div class="form-group">
            <label class="font-weight-bolder" for="order_number">Order Number</label>
            <br>
            <input class="form-control {{ $errors->has('order_number') ? 'is-invalid' : '' }}"
                   name="order_number"
                   type="text" id="order_number" value="{{ old('order_number', optional($invoice)->order_number) }}">

            {!! $errors->first('order_number', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="font-weight-bolder" for="invoice_date">Invoice Date</label> <span
                class="text-danger font-bolder text-danger">*</span>
            <br>
            <input class="form-control  {{ $errors->has('invoice_date') ? 'is-invalid' : '' }}"
                   name="invoice_date"
                   type="date" id="invoice_date"
                   value="{{ old('invoice_date', optional($invoice)->invoice_date)??today()->toDateString() }}"
                   required>

            {!! $errors->first('invoice_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="font-weight-bolder" for="payment_terms">Payment Terms</label> <br>
            <select class="form-control " id="payment_terms" name="payment_terms" style="width: 70%">
                <option value="" selected>--</option>
                @foreach (['7'=>'Net 7','15'=>'Net 15','30'=>'Net 30','45'=>'Net 45','-1'=>'Custom'] as $key=> $text)
                    <option
                        value="{{ $key }}" {{ old('payment_terms', optional($invoice)->payment_terms) == $key ? 'selected' : '' }}>
                        {{ $text }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('payment_terms', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>

</div>


<div class="row">

    <div class="col">
        <div class="form-group">

            <label class="font-weight-bolder" for="due_date">Due Date</label>
            <br>
            <input class="form-control  {{ $errors->has('due_date') ? 'is-invalid' : '' }}"
                   name="due_date" type="date"
                   id="due_date" value="{{ old('due_date', optional($invoice)->due_date) }}">
            {!! $errors->first('due_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group mini">
            <label class="font-weight-bolder">To Customer</label>

            <br>

            <select class="customer form-control select2" id="customer_id" name="customer_id">
                <option value="" disabled
                        selected></option>
                @foreach ($customers as $key => $customer)
                    <option
                        value="{{ $key }}" {{ old('customer_id', optional($invoice)->customer_id) == $key ? 'selected' : '' }}>
                        {{ $customer }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('customer_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col"></div>
    <div class="col"></div>
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

    </div>
    <div class="col">


        <table class="table table-borderless">
            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 14px">Sub Total</b>

                </td>
                <td style="text-align: end">
                    <input type="number" step="any" id="subTotal" name="sub_total"
                           value="{{ old('sub_total', optional($invoice)->sub_total) }}" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end">
                </td>
            </tr>
            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 14px">Discount</b>
                    <input type="number" step="any" class="input-sm form-control d-inline-block"
                           style="max-width: 100px; text-align: end" id="discountValue" name="discount_value"
                           value="{{ old('discount_value', optional($invoice)->discount_value) }}">
                    <select class="input-sm small-input d-inline" id="discount_type" name="discount_type">

                        @foreach ([ '%', 'Flat'] as $key => $text)
                            <option
                                value="{{ $text }}" {{ old('discount_type', optional($invoice)->discount_type) == $text ? 'selected' : '' }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td style="text-align: end">
                    <label>
                        <input type="number" step="any" id="discount" name="discount"
                               value="{{ old('discount', optional($invoice)->discount) }}>" readonly
                               style="border: 1px solid transparent; outline: none;text-align: end" hidden>
                        <input type="number" step="any" id="discountShown"
                               value="{{ old('discount', optional($invoice)->discount) }}" readonly
                               style="border: 1px solid transparent; outline: none;text-align: end">
                    </label>
                </td>
            </tr>
            <tr>
                <td><b class="font-weight-bolder text-black mr-2" style="font-size: 14px">Shipping Charges</b>

                    <input type="number" step="any" class="input-sm form-control d-inline-block"
                           style="max-width: 100px;text-align: end"
                           name="shipping_input"
                           id="shipping_input"
                           value="{{ old('shipping_charge', optional($invoice)->shipping_charge) }}">
                </td>
                <td style="text-align: end">
                    <input type="number" id="shipping_charge" name="shipping_charge"
                           value="{{ old('shipping_charge', optional($invoice)->shipping_charge) }}" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end">
                </td>
            </tr>

            <tbody id="extra">

            </tbody>

            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 20px">Total</b>
                </td>
                <td style="text-align: end">
                    <input class="font-weight-bolder" type="number" step="any" id="total" name="total" value="0.00"
                           readonly
                           style="border: 1px solid transparent; outline: none;text-align: end;font-size: 20px">
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
            <label for="terms_condition">Terms Condition</label>
            <textarea class="form-control" name="terms_condition" cols="50" rows="5"
                      id="terms_condition">{{ old('terms_condition', optional($invoice)->terms_condition)??$settings->terms_condition??'' }}</textarea>

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" name="notes" cols="50" rows="5"
                      id="notes">{{ old('notes', optional($invoice)->notes) ??$settings->notes??'' }}</textarea>
            {!! $errors->first('notes', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="col align-self-center border">
        <div class="form-group p-1">
            <label for="attachment">Attach File(s) to Invoice</label>
            <div class="input-group uploaded-file-group">
                <label class="input-group-btn">
                <span class="btn btn-default">
                     <input type="file" name="attachment" id="attachment" class="form-control-file">
                </span>
                </label>
                <input type="text" class="form-control uploaded-file-name" hidden>
            </div>

            @if (isset($invoice->attachment) && !empty($invoice->attachment))
                <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_attachment" class="custom-delete-file" value="1" {{ old('custom_delete_attachment', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                    <span class="input-group-addon custom-delete-file-name">
                   <img class="card" src="{{ asset('storage/'.$invoice->attachment) }}" width="200">

                </span>
                </div>
            @endif

            {!! $errors->first('attachment', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>


<div class="hidden">
    <input type="text" id="invoice_items" name="invoice_items" hidden>
    <input type="text" id="additional" name="additional" hidden>
    <input type="text" id="additionalField" name="additional_fields" hidden>
</div>



@verbatim
    <script id="template" type="text/ractive">

                <table class="table text-black text-center  ">
                    <thead>
                    <tr class="">
                        <th  class="font-weight-bold" style="text-align: start;">Items <span class="text-danger">*</span></th>
                        <th style="width: 13%" scope="col" class="font-weight-bold">Rate</th>
                        <th style="width: 13%"  scope="col" class="font-weight-bold">Quantity</th>
                        <th  style="width: 20%"  scope="col" class="font-weight-bold">Tax <sup><a target="_blank" href="/taxes">view taxes</a></sup></th>
                        <th  style="width: 13%" scope="col" class="font-weight-bold">Amount</th>
                         <th   ></th>
                    </tr>
                    </thead>
                <tbody>
                {{#each invoice_items:i}}
        <tr id="row{{i}}" fade-in>
            <td>
                <select style="width: 100%" id='itemSelect{{ i }}' class="itemSelect form-control input-sm "
                value="{{ product_id }}" index="{{ i }}" required>
                            <option disabled selected value=""> -- </option>
                            {{ #each products:i }}
        <option value="{{ id }}" > {{ name }}</option>
                            {{ /each }}
        </select>
   <input type="text" value="{{ description }}" style="border: none!important;" class="form-control  input-sm" placeholder="Item Description ...">
            </td>
            <td> <input type="number" step="any" style="text-align: end"  class="form-control  input-sm rate" value="{{ price }}" required></td>
            <td> <input type="number" step="any" style="text-align: end"  class="form-control   input-sm qnt" value="{{ qnt }}" required>
            <input class="text-right form-control input-sm" type="text" style="outline: none;border:0 !important;text-align: end; text-decoration: underline;text-decoration-style: dashed;text-decoration-color: red"  value="{{ unit }}"/>
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
    <td> <input class="font-weight-bolder" type="number" step="any" style="text-align: end"   style="border: 1px solid transparent; outline: none;text-align: center" twoway="false" readonly value="{{ parseFloat(price * qnt).toFixed(2) }}"></td>
            <td on-click="@this.delete(i)" style="cursor: pointer"> <i class="fa fa-trash text-danger" ></i></td>
         </tr>
{{ /each}}
        </tbody>
        </table>
        <br>
        <br>
        <div class="">
            <span role="button" on-click="@this.addInvoiceItem()" class="p-4 text-center text-primary"
                  style="cursor: pointer">+ Add Line</span>
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
