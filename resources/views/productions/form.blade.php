<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="ref">Ref</label>
            <input class="form-control" name="ref" type="text" id="ref"
                   value="{{ old('ref', optional($production)->ref)??$next_ref }}"
                   placeholder="Enter ref here...">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="date">Date</label>
            <span class="text-danger font-bolder">*</span>
            <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" type="date"
                   id="date"
                   value="{{ old('date', optional($production)->date)??today()->toDateString() }}">

            {!! $errors->first('date', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="status">Production Status</label>
            <select class="form-control" id="status" name="status" required="true">

                @foreach (['Completed','Pending','Cancelled','In Progress'] as  $text)
                    <option
                        value="{{ $text }}" {{ old('status', optional($production)->status) == $text ? 'selected' : '' }}>
                        {{ $text }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('status', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>

<div id="target">

</div>
<input type="text" hidden name="used_items" id="used_items">
<input type="text" hidden name="production_items" id="production_items">


<div class="form-group">

    <label for="note">Note</label>
    <input class="form-control" name="note" type="text" id="note"
           value="{{ old('note', optional($production)->note) }}">

</div>


@verbatim
    <script id="template" type="text/ractive">
<div class="row mt-4">
        <div class="col">
            <h5>Ingredients</h5>
            <hr>
              <table id="invoice_item_table" class="table text-black text-center  ">
                    <thead>
                    <tr class="">
                        <th  class="font-weight-bold" style="text-align: start;width: 50%">Items <span class="text-danger">*</span></th>
                        <th  style="width: 50%"  scope="col" class="font-weight-bold"> Qnt</th>
                         <th   ></th>
                    </tr>
                    </thead>
                  <tbody>
            {{#each used_items:i}}
        <tr>
            <td> <select id='itemSelect{{ i }}' class="itemSelect form-control input-sm "
                value="{{ product_id }}" index="{{ i }}" required>
                            <option disabled selected value=""> -- </option>
                            {{ #each products:i }}
        <option value="{{ id }}" > {{ name }}</option>
                            {{ /each }}
        </select></td>
           <td>
            <input
            value="{{ qnt }}" step="any"
             type="number" class="form-control input-sm " style="text-align: end" required>

</td>
            <td on-click="@this.deleteUsedItem(i)" style="cursor: pointer"> <i class="fa fa-trash text-danger" ></i></td>

       </tr>
{{ /each }}
        </tbody>
    </table>
  <div class="">
  <span role="button" on-click="@this.addUsedItem()" class="btn btn-primary btn-sm"
        style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Ingredients</span>
  </div>
</div>
<div class="col">
  <h5>Manufactured Item</h5>
  <hr>
  <table id="invoice_item_table" class="table text-black text-center  ">
      <thead>
      <tr class="">
          <th  class="font-weight-bold" style="text-align: start;width: 50%">Items <span class="text-danger">*</span></th>
          <th  style="width: 50%"  scope="col" class="font-weight-bold"> Qnt</th>
          <th   ></th>
      </tr>
      </thead>
      <tbody>
        {{#each production_items:i}}
        <tr>
            <td> <select id='productionItemSelect{{ i }}' class=" form-control input-sm "
                value="{{ product_id }}" index="{{ i }}" required>
                            <option disabled selected value=""> -- </option>
                            {{ #each products:i }}
        <option value="{{ id }}" > {{ name }}</option>
                            {{ /each }}
        </select></td>
           <td>
            <input
            value="{{ qnt }}" step="any"
             type="number" class="form-control input-sm " style="text-align: end" required>

</td>
            <td on-click="@this.deleteItem(i)" style="cursor: pointer"> <i class="fa fa-trash text-danger" ></i></td>
       </tr>
{{ /each }}
        </tbody>
          </table>
          <div class="">
          <span role="button" on-click="@this.addItem()" class="btn btn-primary btn-sm"
                style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Manufactured</span>
          </div>
        </div>
        </div>

        <br>
















































    </script>
@endverbatim
