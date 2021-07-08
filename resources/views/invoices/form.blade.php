<div class="float-right">
    <div class="">
        <img class="border border-dashed border-red text-center" src="https://via.placeholder.com/150" width="100px"
             height="80px">
    </div>
</div>
<div class="row">


    <div class="col">
        <div class="form-group">
            <label for="invoice_number" class="text-danger">Invoice Number</label>
            <span class="text-danger font-bolder">*</span>
            <br>
            <input class="small-input {{ $errors->has('invoice_number') ? 'is-invalid' : '' }}"
                   name="invoice_number"
                   type="text" id="invoice_number"
                   value="{{ old('invoice_number', optional($invoice)->invoice_number) }}">
            {!! $errors->first('invoice_number', '<p class="form-text text-danger">:message</p>') !!}
        </div>

    </div>
    <div class="col">
        <div class="form-group">
            <label for="order_number">Order Number</label>
            <br>
            <input class="small-input {{ $errors->has('order_number') ? 'is-invalid' : '' }}" name="order_number"
                   type="text" id="order_number" value="{{ old('order_number', optional($invoice)->order_number) }}">

            {!! $errors->first('order_number', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="text-danger" for="invoice_date">Invoice Date</label> <span
                class="text-danger font-bolder">*</span>
            <br>
            <input class="input-small {{ $errors->has('invoice_date') ? 'is-invalid' : '' }}"
                   style="outline: none;border: 1px dashed gray" name="invoice_date"
                   type="date" id="invoice_date" value="{{ old('invoice_date', optional($invoice)->invoice_date) }}">

            {!! $errors->first('invoice_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="payment_terms">Payment Terms</label> <br>
            <select class="small-input" id="payment_terms" name="payment_terms" style="width: 70%">
                <option value="" selected>--</option>
                @foreach (['Net 30','Net 15'] as $key => $text)
                    <option
                        value="{{ $key }}" {{ old('payment_terms', optional($invoice)->payment_terms) == $key ? '' : '' }}>
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

            <label for="due_date">Due Date</label>
            <br>
            <input class="small-input  {{ $errors->has('due_date') ? 'is-invalid' : '' }}" name="due_date" type="date"
                   id="due_date" value="{{ old('due_date', optional($invoice)->due_date) }}">
            {!! $errors->first('due_date', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>To Customer <span type="button" class="text-primary " data-toggle="modal"
                                     data-target="#customerModal">+ New</span></label>

            <br>

            <select class="customer " id="customer_id" name="customer_id">
                <option value="" style="display: none;"
                        {{ old('customer_id', optional($invoice)->customer_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select customer
                </option>
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
                    <input type="number" step="any" id="subTotal" name="sub_total" value="0.00" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end">
                </td>
            </tr>
            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 14px">Discount</b>
                    <input type="number" step="any" class="small-input"
                           style="max-width: 100px; text-align: end" id="discountValue" name="discountValue">
                    <select class="small-input" id="discount_type" name="discount_type">

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
                        <input type="number" step="any" id="discount" name="discount" value="0.00" readonly
                               style="border: 1px solid transparent; outline: none;text-align: end" hidden>
                        <input type="number" step="any" id="discountShown" value="0.00" readonly
                               style="border: 1px solid transparent; outline: none;text-align: end">
                    </label>
                </td>
            </tr>
            <tr>
                <td><b class="font-weight-bolder text-black mr-2" style="font-size: 14px">Shipping Charges</b>

                    <input type="number" step="any" class="small-input" style="max-width: 100px;text-align: end"
                           name="shipping_input"
                           id="shipping_input">
                </td>
                <td style="text-align: end">
                    <input type="number" id="shipping_charge" name="shipping_charge" value="0.00" readonly
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
                      id="terms_condition">{{ old('terms_condition', optional($invoice)->terms_condition) }}</textarea>
            {!! $errors->first('terms_condition', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" name="notes" cols="50" rows="5"
                      id="notes">{{ old('notes', optional($invoice)->notes) }}</textarea>
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


<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Recipient:</label>
                    <input type="text" class="form-control" id="recipient-name">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Message:</label>
                    <textarea class="form-control" id="message-text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
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

                <table class="table text-black text-center ">
                    <thead>
                    <tr class="">
                        <th colspan="2" scope="col" class="font-weight-bold" style="text-align: start;">Items <span class="text-danger">*</span></th>
                        <th scope="col" class="font-weight-bold">Rate</th>
                        <th scope="col" class="font-weight-bold">Quantity</th>
                        <th scope="col" class="font-weight-bold">Tax</th>
                        <th scope="col" class="font-weight-bold">Amount</th>
                         <th>Action</th>
                    </tr>
                    </thead>
                <tbody>
                {{#each invoice_items:i}}
        <tr fade-in>
            <td colspan="2" style="text-align: start; " >
                <select id="itemSelect{{i}}"  value="{{ product_id }}" index="{{ i }}" required>
                            <option disabled selected value=""> -- </option>
                            {{ #each products:i }}
        <option value="{{ id }}" > {{ name }}</option>
                            {{ /each }}
        </select>
        <input type="text" value="{{ description }}" style="border: none!important;" class="small-input" placeholder="Item Description ...">
            </td>
            <td> <input type="number" step="any" style="text-align: end"  class="small-input" value="{{ price }}" required></td>
            <td> <input type="number" step="any" style="text-align: end"  class="small-input" value="{{ qnt }}" required>
            <br>
            <p class="mr-4"> <input class="" type="text" style="width: 100%;outline: none;border:0 !important;text-align: end;padding: 5px"  value="{{ unit }}"/> </p>
             </td>
            <td style="max-width: 120px">
            <select class="small-input" value="{{ tax_id }}" style="min-width: 80%;max-width: 80%">
                    <option value="">--</option>
                    {{ #each taxes:index }}
        <option value="{{id}}">{{ name }} - {{value}}%</option>
                    {{ /each }}
        </select>
        <br>
        &nbsp;
     </td>
    <td> <input type="number" step="any" style="text-align: end"   style="border: 1px solid transparent; outline: none;text-align: center" readonly value="{{ parseFloat(price * qnt).toFixed(2) }}"></td>
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
            <td>
                <input type="text" class="small-input font-weight-bolder" style="width: 50%" placeholder="Additional.." value="{{ name }}">
                        <input type="number" step="any" class="small-input" style="width: 50%;text-align: end" value="{{ value }}">
                        <i class="fa fa-minus text-danger mx-2" on-click="@this.removeExtraField(i)" style="cursor:pointer;"></i>
                        <b class="far fa-question-circle" data-toggle="tooltip" title="Add any other +ve or -ve charges that need to be applied to adjust the total amount of the transaction Eg. +10 or -10.">

                    </td>
                    <td style="text-align: end">
                        <input type="number" id="shipping_charge" name="shipping_charge" value="{{ value }}" readonly
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
                <input type="text" class="form-control form-control-sm font-weight-bolder"  placeholder="ex. Vat No" value="{{ name }}">

                    </td>
                    <td>
                   <input type="text" step="any" class="form-control form-control-sm" placeholder="ex. 77GH77G9 " value="{{ value }}">

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
