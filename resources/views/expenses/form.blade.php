<div class="row">
    <div class="col">
        <div class="form-group row align-items-center">

            <label for="date" class="col-4 text-right">Date <span class="text-danger font-bolder">*</span></label>

            <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }}  col-6" name="date" type="date"
                   required
                   id="date" value="{{ old('date', optional($expense)->date) }}">
        </div>
        {!! $errors->first('date', '<p class="form-text text-danger text-center">:message</p>') !!}

    </div>
    <div class="col">
        <div class="form-group row align-items-center">
            <label for="ledger_id" class="col-4 text-right">Paid Through <span class="text-danger font-bolder">*</span></label>
            <select class="form-control col-6" id="ledger_id" name="ledger_id" required>
                <option value="" style="display: none;"
                        {{ old('ledger_id', optional($expense)->ledger_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select account
                </option>
                @foreach ($ledgers as  $ledger)
                    <option
                        value="{{ $ledger->id }}" {{ old('ledger_id', optional($expense)->ledger_id) == $ledger->id ? 'selected' : '' }}>
                        {{ $ledger->ledger_name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('ledger_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group row align-items-center">
            <label for="vendor_id" class="col-4 text-right">Vendor</label>
            <select class="form-control col-6" id="vendor_id" name="vendor_id">
                <option value="" style="display: none;"
                        {{ old('vendor_id', optional($expense)->vendor_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select vendor
                </option>
                @foreach ($vendors as $key => $vendor)
                    <option
                        value="{{ $key }}" {{ old('vendor_id', optional($expense)->vendor_id) == $key ? 'selected' : '' }}>
                        {{ $vendor }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('vendor_id', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group row align-items-center">

            <label for="customer_id" class="col-4 text-right">Customer</label>
            <select class="form-control  col-6" id="customer_id" name="customer_id">
                <option value="" style="display: none;"
                        {{ old('customer_id', optional($expense)->customer_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select customer
                </option>
                @foreach ($customers as $key => $customer)
                    <option
                        value="{{ $key }}" {{ old('customer_id', optional($expense)->customer_id) == $key ? 'selected' : '' }}>
                        {{ $customer }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('customer_id', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="form-group  row align-items-center">

            <label for="ref" class="col-4 text-right">Ref#</label>

            <input class="form-control input-sm  col-6  {{ $errors->has('ref') ? 'is-invalid' : '' }}" name="ref"
                   type="text"
                   id="ref"
                   placeholder="Reference Number (If have)"
                   value="{{ old('ref', optional($expense)->ref) }}">

        </div>
    </div>
    <div class="col">
        <div class="form-group row align-items-center  d-none">
            <label for="is_billable" class="col-4 text-right">Is Billable</label>
            <div class=" col-6">
                <label class="checkbox checkbox-lg">
                    <input name="is_billable" type="checkbox"
                           value="1" {{ old('is_billable', optional($expense)->is_billable) == '1' ? 'checked' : '' }}>
                    <span class="mr-4"></span> Yes
                </label>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="form-group row align-items-center">
            <label for="file" class="col-4 text-right">Upload Receipt</label>
            <div class="input-group uploaded-file-group col-6">
                <label class="input-group-btn">
                <span class="btn btn-default">
                     <input type="file" name="file" id="file" class="form-control-file">
                </span>
                </label>
                <input type="text" class="form-control uploaded-file-name" hidden>
            </div>
        </div>
    </div>

    <div class="col">


    </div>
</div>
@if (isset($expense->file) && !empty($expense->file))
    <div class="row">
        <div class="col">
            <div class="form-group row align-items-center">
                <label for="delete" class="col-4 text-right">Delete?</label>
                <div class="input-group uploaded-file-group col-6">
                    <label class="input-group-btn">
                <span class="btn btn-default">
                  <input id="delete" type="checkbox" name="custom_delete_file" class="custom-delete-file" value="1" {{ old('custom_delete_file', '0') == '1' ? 'checked' : '' }} />
                </span>
                    </label>
                    <img class="card" src="{{ asset('storage/'.$expense->file) }}" width="100"/></div>
            </div>
        </div>

        <div class="col">


        </div>
    </div>
@endif


<div class="row mx-auto" style="width: 90%">
    <div id="line_table" style="width: 100%"></div>
</div>

<div class="row mx-auto" style="width: 90%">
    <div class="col"></div>
    <div class="col">
        <table class="table table-borderless">
            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 14px">Sub Total</b>
                </td>
                <td style="text-align: end">
                    <input type="number" step="any" id="subTotal" name="sub_total"
                           value="{{ old('sub_total', optional($expense)->sub_total)??0 }}" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end">
                    <span class="currency"></span>

                </td>
            </tr>
            <tbody id="allTaxes">

            </tbody>
            <tr>
                <td>
                    <b class=" font-weight-bolder text-black mr-2" style="font-size: 18px"> Total Expense</b>
                </td>
                <td style="text-align: end">
                    <input type="number" step="any" id="total" name="total"
                           value="{{ old('sub_total', optional($expense)->total)??0.00 }}" readonly
                           style="border: 1px solid transparent; outline: none;text-align: end;font-size: 20px">
                    <span class="currency"></span>

                </td>
            </tr>

        </table>
    </div>

    <div>
        {{-- Hidden Element--}}
        <input type="text" id="expense_items" name="expense_items" hidden>
    </div>
</div>

@verbatim
    <script id="template" type="text/ractive">

                <table id="expense_item_table" class="table text-black text-center  ">
                    <thead>
                    <tr class="font-weight-bolder">
                        <th  class="font-weight-bold" style="text-align: start;"><label for="">Expense Category</label> <span class="text-danger">*</span></th>
                        <th  scope="col" class="font-weight-bold"><label for="">Note</label></th>
                        <th  scope="col" class="font-weight-bold"><label for="">Tax</label> <sup><a target="_blank" href="/taxes">view taxes</a></sup></th>
                        <th   scope="col" class="font-weight-bold"><label for="">Amount</label></th>
                         <th   ></th>
                    </tr>
                    </thead>
                <tbody>
                {{#each expense_items:i}}
        <tr class="ui-state-default" id="row{{i}}" fade-in>
            <td>
                <div class="d-flex">


                <span class="fa fa-grip-vertical p-2" style="cursor: move"></span>
                <select style="width: 100%" id='itemSelect{{ i }}' class="itemSelect form-control input-sm "
                value="{{ ledger_id }}" index="{{ i }}" required>
                            <option disabled selected value=""> -- </option>
                            {{ #each ledgers:i }}
        <option value="{{ id }}" > {{ ledger_name }}</option>
                            {{ /each }}
        </select>
        </div>

            </td>
            <td> <textarea type="text" class="form-control  input-sm " value="{{ notes }}" ></textarea></td>

            <td >
            <select  style="width: 100%"  index="{{i}}" id="itemTax{{i}}" class="form-control " value="{{ tax_id }}">
                    <option value="" selected>--</option>
                    {{ #each taxes:index }}
        <option value="{{id}}">{{ name }} - {{value}}%</option>
                    {{ /each }}
        </select>
        <br>
        &nbsp;
     </td>
    <td >
        <input type="number" step="any" class="font-weight-bolder form-control  input-sm" style="font-size: 16px;text-align:right" value="{{ amount }}" required/>
        <span class="currency d-inline font-weight-bolder" style="font-size: 16px">{{ currency }}</span></td>
            <td on-click="@this.delete(i)" style="cursor: pointer"> <i class="fa fa-trash text-danger" ></i></td>
         </tr>
{{ /each}}
        </tbody>
        </table>

        <div class="">
            <span role="button" on-click="@this.addExpenseItem()" class="p-2 text-center text-primary font-weight-bolder border border-primary "
                  style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Another Line</span>
        </div>
















































    </script>
@endverbatim

@verbatim
    <script id="taxTemplate" type="text/ractive">
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
    </script>

@endverbatim



