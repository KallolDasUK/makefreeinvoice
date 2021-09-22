<div class="row">
    <div class="col-7 ">
        <div class="item-search " style="position:relative;">
            <input name="product_search" id="product_search" type="text" placeholder="Scan/Search Items"
                   class="form-control" style="font-size: 18px;padding-left: 50px">
            <i class="fa fa-barcode" style="font-size: 45px;position:absolute; right: 7px;top: 0px"></i>
            <i class="fa fa-search"
               style="font-size: 20px;position:absolute; left: 16px;top: 12px;color: gray!important;"></i>
        </div>

        <div class="d-flex item-category mt-4">
            <div class="ml-2 category_item d-flex align-items-center justify-content-center rounded btn btn-info">
                <span style="font-size: 14px;">+ <br>New

                    Category</span>
            </div>
            @foreach($categories as $category)
                <div class="ml-2 category_item d-flex align-items-center justify-content-center rounded">
                    <span class="">{{ $category->name }}</span>
                </div>
            @endforeach
        </div>
        <div class="d-flex items mt-4" style="max-height: 550px;overflow: scroll">
            <div class="ml-2 item d-flex align-items-center justify-content-center rounded btn btn-primary">
                <span style="font-size: 14px;">+<br> New

                    Item</span>
            </div>
            @foreach($products as $product)
                <div class="ml-2 item rounded btn">
                    <span class="">{{ $product->name }}</span>
                    <span
                        style="position:absolute;left: 5px;bottom: 5px"><small>{{ decent_format($product->stock) }} {{ $product->sell_unit }}</small></span>
                    <span
                        style="position:absolute;right: 5px;bottom: 5px">{{ decent_format_dash_if_zero($product->sell_price) }}</span>
                </div>
            @endforeach
            @foreach(range(1,30) as $product)
                <div class="ml-2 item rounded btn">
                    <span class=""></span>
                    <span
                        style="position:absolute;left: 5px;bottom: 5px"><small></small></span>
                    <span
                        style="position:absolute;right: 5px;bottom: 5px"></span>
                </div>
            @endforeach
        </div>
    </div>


    <div class="col-5">
        <div style="height: 40px">
            <div class="text-right">
                <a href="{{ route('acc.home') }}" class="btn btn-outline-primary">
                    <i class="fa fa-home"></i>
                    HOME
                </a>
                <button type="button"  class="btn btn-outline-primary">
                    <i class="fa fa-cog"></i>
                    POS Settings
                </button>
                <button type="button" class="btn btn-outline-primary">
                    <i class="fa fa-cog"></i>
                    Receipt Settings
                </button>
                <button type="button"  class="btn btn-outline-primary">
                    <i class="fa fa-file-audio"></i>
                    Sound On/Off
                </button>
            </div>
        </div>
    </div>

</div>
