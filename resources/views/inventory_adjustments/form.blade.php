<div class="col-4">


    <div class="form-group ">
        <div class="row align-items-center">
            <label for="date" class="col-4">Date<span class="text-danger font-bolder">*</span></label>

            <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }} col" name="date" type="text"
                   id="date" value="{{ old('date', optional($inventoryAdjustment)->date)??today()->format('Y-m-d') }}"
                   minlength="1" readonly
            >

            {!! $errors->first('date', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>

    <div class="form-group">
        <div class="row align-items-center">
            <label for="ref" class="col-4">Ref</label>
            <input class="form-control col {{ $errors->has('ref') ? 'is-invalid' : '' }}" name="ref" type="text"
                   id="ref"
                   value="{{ old('ref', optional($inventoryAdjustment)->ref)??$ref }}" minlength="1" data=""
                   placeholder="Enter ref here...">

        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <label for="ledger_id" class="col-4">Account <span class="text-danger font-bolder">*</span></label>


            <select class="form-control col" id="ledger_id" name="ledger_id" required="true">
                <option value="" style="display: none;"
                        {{ old('ledger_id', optional($inventoryAdjustment)->ledger_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select ledger
                </option>
                @foreach ($ledgers as $key => $ledger)
                    <option
                        value="{{ $key }}"
                        {{ old('ledger_id', optional($inventoryAdjustment)->ledger_id) == $key ? 'selected' : '' }} @if($inventoryAdjustment == null && \Enam\Acc\Models\GroupMap::query()->where('key',\Enam\Acc\Utils\LedgerHelper::$INVENTORY_AC)->first()->value == $key) selected @endif>
                        {{ $ledger }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('ledger_id', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>



    <div class="form-group">
        <div class="row">
            <label for="description" class="col-4">Notes</label>


            <textarea class="form-control col" name="description" cols="50" rows="3" id="description" minlength="1"
                      maxlength="1000">{{ old('description', optional($inventoryAdjustment)->description) }}</textarea>
            {!! $errors->first('description', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>

<input type="text" hidden name="inventory_adjustment_items" id="inventory_adjustment_items">

<div>
    <div id="target"></div>
</div>


@verbatim
    <script id="template" type="text/ractive">

                <table id="invoice_item_table" class="table text-black text-center  ">
                    <thead>
                    <tr class="">
                        <th  class="font-weight-bold" style="text-align: start;">Items <span class="text-danger">*</span></th>
                        <th  class="font-weight-bold" style="text-align: start;">Reason</th>
                        <th style="width: 13%" scope="col" class="font-weight-bold">Current Stock</th>
                        <th style="width: 20%"  scope="col" class="font-weight-bold">Type</th>
                        <th  style="width: 13%"  scope="col" class="font-weight-bold">Add Qnt</th>
                        <th  style="width: 13%" scope="col" class="font-weight-bold">Sub Qnt</th>
                         <th   ></th>
                    </tr>
                    </thead>
                <tbody>
                {{#each inventory_adjustment_items:i}}
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
            </td>
            <td><select style="width: 100%" id='reasonSelect{{ i }}' class="reasonSelect form-control input-sm "
                value="{{ reason_id }}" index="{{ i }}" >
                            <option disabled selected value=""> -- </option>
                            {{ #each reasons:i }}
        <option value="{{ id }}" > {{ name }}</option>
                            {{ /each }}
        </select></td>
            <td>  <span>{{ stock }}</span> </td>
            <td> <select  id="itemTax{{i}}" class="form-control input-sm" value="{{ type }}">

                    <option value="add"> Add (+)</option>
                    <option value="sub"> Substract (-)</option>
        </select></td>
            <td >
            <input
            value="{{ add_qnt }}"
             type="text" class="form-control input-sm {{ type=='sub'?'d-none':'' }} " style="text-align: end" {{ type=='add'?'required':'' }}>
     </td>
        <td >
            <input
            value="{{ sub_qnt }}"
            type="text" class="form-control input-sm {{ type=='add'?'d-none':'' }}" style="text-align: end"  {{ type=='sub'?'required':'' }}>
     </td>

            <td on-click="@this.delete(i)" style="cursor: pointer"> <i class="fa fa-trash text-danger" ></i></td>
         </tr>
{{ /each}}
        </tbody>
        </table>
        <br>
        <br>
        <div class="">
            <span role="button" on-click="@this.addItem()" class="p-2 text-center text-primary font-weight-bolder border border-primary"
                  style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Line</span>
        </div>











































    </script>
@endverbatim
