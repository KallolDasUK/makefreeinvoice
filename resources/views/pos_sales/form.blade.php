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
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="40px" height="40px"><path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"/></svg>

            </div>
            @foreach($categories as $category)
                <div class="ml-2 category_item d-flex align-items-center justify-content-center rounded">
                    <span class="">{{ $category->name }}</span>
                </div>
            @endforeach
        </div>
        <div class="d-flex items mt-4" style="max-height: 550px;overflow: scroll">
            <div class="ml-2 item d-flex align-items-center justify-content-center rounded btn btn-primary">

                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px"><path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"/></svg>
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
            @foreach(range(1,31) as $product)
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
            <div class="row align-items-center justify-content-center">
                <a href="{{ route('acc.home') }}" class="col-2 mx-1 btn btn-outline-primary text-center">
                    <i class="fa fa-home"></i>
                    HOME
                </a>
                <button type="button" class="col mx-1 btn btn-outline-primary">
                    <i class="fa fa-cog"></i>
                    POS Settings
                </button>
                <button type="button" class="col mx-1 btn btn-outline-primary text-center">
                    <i class="fa fa-cog"></i>
                    Receipt Settings
                </button>

                <button type="button" class="col mx-1 btn btn-outline-info">
                    <i class="fa fa-file-audio"></i>
                    Upgrade
                </button>
            </div>
        </div>
        <div class="cart bg-white">
            <h2 class="ml-4 mt-4">In Cart </h2>
            <table class="table " style="overflow: scroll">
                <tr>
                    <th>Item
                        <small>Attribute</small>
                    </th>
                    <th>Price</th>
                    <th>Qnt</th>
                    <th>Amount</th>
                </tr>
            </table>
            <div class="empty-cart bg-white text-center d-flex align-items-center justify-content-center rounded"
                 style="height: 400px;display: none">
                <div>
                    <img width="100" height="100" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_UGVlPqcYGJxa04bB_ZnDWZpja9qvT3ywew&usqp=CAU" alt="">
                    <h2>Empty Cart</h2>
                    <p>Search Item or Scan Barcode to add item to cart</p>
                </div>

            </div>
        </div>
    </div>

</div>
