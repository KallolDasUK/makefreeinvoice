<div class="form-group">
    <div class="col-md-10">
        <label for="product_type" class="text-danger">Product Type *</label>

        <div class="radio">
            <label for="product_type_0">
                <input id="product_type_0" class="" name="product_type" type="radio" value="Goods"
                       {{ old('product_type', optional($product)->product_type) == 'Goods' ? 'checked' : '' }} @if(!$product) checked @endif>
                Goods
            </label>
        </div>
        <div class="radio">
            <label for="product_type_1">
                <input id="product_type_1" class="" name="product_type" type="radio"
                       value="Service" {{ old('product_type', optional($product)->product_type) == 'Service' ? 'checked' : '' }}>
                Service
            </label>
        </div>

        {!! $errors->first('product_type', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>


<div class="row">
    <div class="col">
        <div class="form-group">
            <label class="text-danger" for="name">Name *</label>
            <input class="form-control form-control-sm  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                   type="text" id="name"
                   value="{{ old('name', optional($product)->name) }}">

            {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="sku">SKU</label>
            <input class="form-control form-control-sm  {{ $errors->has('sku') ? 'is-invalid' : '' }}" name="sku"
                   type="text" id="sku"
                   value="{{ old('sku', optional($product)->sku) }}">
            {!! $errors->first('sku', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">

            <label for="photo">Product Image</label>

            <div class="input-group uploaded-file-group">
                <label class="input-group-btn">
                <span class="">
                     <input type="file" name="photo" id="photo" class="form-control form-control-sm-file">
                </span>
                </label>
                <input type="text" class="form-control form-control-sm uploaded-file-name" hidden>
            </div>

            @if (isset($product->photo) && !empty($product->photo))
                <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_photo" class="custom-delete-file" value="1" {{ old('custom_delete_photo', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                    <span class="input-group-addon custom-delete-file-name">
                   <img class="card" src="{{ asset('storage/'.$product->photo) }}" width="200">

                </span>
                </div>
            @endif

            {!! $errors->first('photo', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>


<div class="form-group">
    <label for="category_id">Category</label>
    <select class="form-control form-control-sm" id="category_id" name="category_id">
        <option value="" style="display: none;"
                {{ old('category_id', optional($product)->category_id ?: '') == '' ? 'selected' : '' }} disabled
                selected>Select category
        </option>
        @foreach ($categories as $key => $category)
            <option
                value="{{ $key }}" {{ old('category_id', optional($product)->category_id) == $key ? 'selected' : '' }}>
                {{ $category }}
            </option>
        @endforeach
    </select>

    {!! $errors->first('category_id', '<p class="form-text text-danger">:message</p>') !!}

</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="sell_price" class="text-danger">Sell Price *</label>
            <input class="form-control form-control-sm  {{ $errors->has('sell_price') ? 'is-invalid' : '' }}"
                   name="sell_price"
                   type="number" id="sell_price" value="{{ old('sell_price', optional($product)->sell_price) }}">

            {!! $errors->first('sell_price', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="sell_unit">Sell Unit</label>

            <select class="form-control form-control-sm" id="sell_unit" name="sell_unit">
                <option value="" style="display: none;"
                        {{ old('sell_unit', optional($product)->sell_unit ?: '') == '' ? 'selected' : '' }} disabled
                        selected>--
                </option>
                @foreach ($units as $unit)
                    <option
                        value="{{ $unit->name }}" {{ old('sell_unit', optional($product)->sell_unit) == $unit->name ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('sell_unit', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="purchase_price">Purchase Price</label>

            <input class="form-control form-control-sm  {{ $errors->has('purchase_price') ? 'is-invalid' : '' }}"
                   name="purchase_price"
                   type="number" id="purchase_price"
                   value="{{ old('purchase_price', optional($product)->purchase_price) }}">

            {!! $errors->first('purchase_price', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="purchase_unit">Purchase Unit</label>
            <select class="form-control form-control-sm" id="purchase_unit" name="purchase_unit">
                <option value="" style="display: none;"
                        {{ old('purchase_unit', optional($product)->purchase_unit ?: '') == '' ? 'selected' : '' }} disabled
                        selected>--
                </option>
                @foreach ($units as $unit)
                    <option
                        value="{{ $unit->name }}" {{ old('purchase_unit', optional($product)->purchase_unit) == $unit->name ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('purchase_unit', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>


<div class="form-group">
    <label for="description">Description</label>


    <textarea class="form-control form-control-sm" name="description" cols="50" rows="4" id="description"
              maxlength="1000">{{ old('description', optional($product)->description) }}</textarea>
    {!! $errors->first('description', '<p class="form-text text-danger">:message</p>') !!}


</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="is_track">Is Track</label>


            <div class="checkbox">
                <label for="is_track_1">
                    <input id="is_track_1" class="" name="is_track" type="checkbox"
                           value="1" {{ old('is_track', optional($product)->is_track) == '1' ? 'checked' : '' }}>
                    Yes
                </label>
            </div>

            {!! $errors->first('is_track', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="opening_stock">Opening Stock</label>
            <input class="form-control form-control-sm  {{ $errors->has('opening_stock') ? 'is-invalid' : '' }}"
                   name="opening_stock"
                   type="number" id="opening_stock"
                   value="{{ old('opening_stock', optional($product)->opening_stock) }}">

            {!! $errors->first('opening_stock', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="opening_stock_price">Opening Stock Price</label>
            <input class="form-control form-control-sm  {{ $errors->has('opening_stock_price') ? 'is-invalid' : '' }}"
                   name="opening_stock_price" type="number" id="opening_stock_price"
                   value="{{ old('opening_stock_price', optional($product)->opening_stock_price) }}">
            {!! $errors->first('opening_stock_price', '<p class="form-text text-danger">:message</p>') !!}
        </div>
    </div>
</div>






