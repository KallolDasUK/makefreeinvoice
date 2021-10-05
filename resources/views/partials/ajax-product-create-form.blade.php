<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">
        <form id="createProductForm" method="post" action="{{ route('products.product.store') }}" index=""
              enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="col-md-10">
                                    <label for="product_type">Product Type *</label>

                                    <div class="radio">
                                        <label for="product_type_0">
                                            <input id="product_type_0" class="" name="product_type" type="radio"
                                                   value="Goods"
                                                   checked>
                                            Goods
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="product_type_1">
                                            <input id="product_type_1" class="" name="product_type" type="radio"
                                                   value="Service">
                                            Service
                                        </label>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">

                                <label for="photo">Product Image</label>

                                <div class="input-group uploaded-file-group">
                                    <label class="input-group-btn">
                                        <span class="">
                                             <input type="file" name="photo" id="photo"
                                                    class="form-control -file">
                                        </span>
                                    </label>
                                    <input type="text" class="form-control  uploaded-file-name" hidden>
                                </div>


                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">Item Name *</label>
                                <input
                                    class="form-control input-sm"
                                    name="name"
                                    placeholder="Required **"
                                    type="text" id="product_name">


                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control " id="category_id" name="category_id">
                                    <option value="" style="display: none;" disabled
                                            selected>Select category
                                    </option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                    @endforeach
                                </select>


                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select class="form-control form-control-sm" id="brand_id" name="brand_id">
                                    <option value="" style="display: none;" disabled
                                            selected>Select Brand
                                    </option>
                                    @foreach (\App\Models\Brand::query()->pluck('name','id') as $key => $brand)
                                        <option value="{{ $key }}">{{ $brand }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="sell_price">Sell Price *</label>
                                <input class="form-control input-sm"
                                       name="sell_price"
                                       step="any"

                                       type="number" id="sell_price">


                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="sell_unit">Sell Unit</label>

                                <select class="form-control " id="sell_unit" name="sell_unit">
                                    <option value="" style="display: none;" disabled
                                            selected>--
                                    </option>
                                    @foreach (['KG','M', 'CM','BOX','LT.'] as $key => $text)
                                        <option
                                            value="{{ $text }}">
                                            {{ $text }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="purchase_price">Purchase Price</label>

                                <input class="form-control input-sm"
                                       name="purchase_price"
                                       step="any"

                                       type="number" id="purchase_price">


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="purchase_unit">Purchase Unit</label>
                                <select class="form-control " id="purchase_unit" name="purchase_unit">
                                    <option value="" style="display: none;"
                                            disabled
                                            selected>--
                                    </option>
                                    @foreach (['KG','M','CM','BOX','LT.'] as $key => $text)
                                        <option value="{{ $text }}">{{ $text }}</option>
                                    @endforeach
                                </select>


                            </div>
                            <div class="form-group">
                                <label for="purchase_unit">Scan Barcode/QR Code</label>
                                <input class="form-control input-sm"
                                       name="code"
                                       step="any"
                                       type="text" id="code">


                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="description">Description</label>


                                <textarea class="form-control " name="description" cols="50" rows="4"
                                          id="description"
                                          maxlength="1000"></textarea>


                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col d-none">
                            <div class="form-group">
                                <label for="is_track">Track?</label>


                                <div class="checkbox">
                                    <label for="is_track_1">
                                        <input id="is_track_1" class="" name="is_track" type="checkbox"
                                               value="1" checked>
                                        Yes
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="opening_stock">Opening Stock</label>
                                <input class="form-control input-sm "
                                       name="opening_stock"
                                       type="number" id="opening_stock">

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="opening_stock_price">O. Stock Price <small>per item</small></label>
                                <input
                                    readonly
                                    class="form-control input-sm  {{ $errors->has('opening_stock_price') ? 'is-invalid' : '' }}"
                                    name="opening_stock_price" type="number" id="opening_stock_price">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeProduct">Save Product</button>
                </div>

            </div>
        </form>

    </div>
</div>

<script>
    $(document).ready(function () {

        $('#purchase_price,#opening_stock').on('input', function () {
            $('#opening_stock_price').val(parseFloat(($('#purchase_price').val() || 0) * ($('#opening_stock').val() || 0)))
        })
    })
</script>

