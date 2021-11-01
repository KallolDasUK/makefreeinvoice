<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="ref">Ref</label>
            <input class="form-control " name="ref" type="text" id="ref"
                   value="{{ old('ref', optional($stockEntry)->ref) }}" minlength="1" data=""
                   placeholder="Enter ref here...">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="date">Date</label>
            <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" type="date"
                   id="date"
                   value="{{ old('date', optional($stockEntry)->date)??today()->toDateString() }}">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="brand_id">Brand</label>
            <select class="form-control searchable" id="brand_id" name="brand_id">
                <option value="" style="display: none;"
                        {{ old('brand_id', optional($stockEntry)->brand_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select brand
                </option>
                @foreach ($brands as $key => $brand)
                    <option
                        value="{{ $key }}" {{ old('brand_id', optional($stockEntry)->brand_id) == $key ? 'selected' : '' }}>
                        {{ $brand }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control searchable" id="category_id" name="category_id">
                <option value="" style="display: none;"
                        {{ old('category_id', optional($stockEntry)->category_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select category
                </option>
                @foreach ($categories as $key => $category)
                    <option
                        value="{{ $key }}" {{ old('category_id', optional($stockEntry)->category_id) == $key ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="product_id">Product</label>
            <select class="form-control searchable" id="product_id" name="product_id">
                <option value="" style="display: none;"
                        {{ old('product_id', optional($stockEntry)->product_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>Select product
                </option>
                @foreach ($products as $key => $product)
                    <option
                        value="{{ $product->id }}" {{ old('product_id', optional($stockEntry)->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<input type="text" hidden id="items" name="items">

<div class="row">
    <div id="target">

    </div>
</div>

@verbatim
    <script id="template" type="text/ractive">
<div class="row mx-4">

             <div class="row align-items-center justify-content-center" style="width: 100%">
  <div class="col-3 text-right font-weight-bolder">Item Name</div>
            <div class="col-3 text-center font-weight-bolder">Qnt</div>
            <div class="col-3 text-right font-weight-bolder">Item Name</div>
            <div class="col-3 text-center font-weight-bolder">Qnt</div>

            {{#each items:i}}
        <div class="col-3 mt-4">

            <p class="text-right">{{ product.name }} →</p>

       </div>
       <div class="col-3 ">
          <input
            value="{{ qnt }}" step="any"
             type="number" class="form-control  bg-secondary" placeholder="Quantity" style="text-align: end"  >
</div>
{{ /each }}

        </div>

                </div>


















































</script>
@endverbatim



